<?php

namespace App\Services;

use App\Models\EmailSession;
use App\Models\StorageAnalytics;
use App\Models\EmailProcessingLog;
use Illuminate\Support\Facades\DB;

class StorageAnalyticsService
{
    public function calculateSessionAnalytics(EmailSession $session): void
    {
        $this->calculateTotalAnalytics($session);
        $this->calculateContentTypeAnalytics($session);
        $this->calculateFileTypeAnalytics($session);
        $this->calculateSizeDistributionAnalytics($session);
    }

    public function getSessionAnalytics(EmailSession $session): array
    {
        $analytics = StorageAnalytics::where('email_session_id', $session->id)->get();
        
        $result = [
            'total' => $this->formatAnalyticsData($analytics->where('content_type', 'total')->first()),
            'by_content_type' => [],
            'file_types_breakdown' => [],
            'size_distribution' => [],
            'charts_data' => $this->generateChartsData($analytics),
        ];

        foreach (['text', 'images', 'attachments', 'html'] as $type) {
            $typeAnalytics = $analytics->where('content_type', $type)->first();
            if ($typeAnalytics) {
                $result['by_content_type'][$type] = $this->formatAnalyticsData($typeAnalytics);
            }
        }

        return $result;
    }

    public function getRealTimeProgress(EmailSession $session): array
    {
        $totalEmails = $session->total_emails;
        $processedEmails = $session->processed_emails;
        $progressPercentage = $totalEmails > 0 ? round(($processedEmails / $totalEmails) * 100, 2) : 0;

        $recentLogs = EmailProcessingLog::where('email_session_id', $session->id)
            ->orderBy('processed_at', 'desc')
            ->limit(5)
            ->get();

        $storageStats = $this->calculateCurrentStorageStats($session);

        return [
            'progress_percentage' => $progressPercentage,
            'total_emails' => $totalEmails,
            'processed_emails' => $processedEmails,
            'remaining_emails' => $totalEmails - $processedEmails,
            'storage_saved_mb' => $session->storage_saved_mb,
            'storage_saved_gb' => $session->storage_saved_gb,
            'recent_processed' => $recentLogs->map(function ($log) {
                return [
                    'subject' => $log->subject,
                    'storage_saved_mb' => $log->storage_saved_mb,
                    'processed_at' => $log->processed_at->format('H:i:s'),
                ];
            }),
            'storage_breakdown' => $storageStats,
            'estimated_completion' => $this->estimateCompletion($session),
        ];
    }

    private function calculateTotalAnalytics(EmailSession $session): void
    {
        $totals = EmailProcessingLog::where('email_session_id', $session->id)
            ->selectRaw('
                SUM(original_size_bytes) as total_original,
                SUM(converted_size_bytes) as total_converted,
                SUM(storage_saved_bytes) as total_saved,
                COUNT(*) as total_files
            ')
            ->first();

        $compressionRatio = $totals->total_original > 0 
            ? round((($totals->total_original - $totals->total_converted) / $totals->total_original) * 100, 2)
            : 0;

        StorageAnalytics::updateOrCreate(
            [
                'email_session_id' => $session->id,
                'content_type' => 'total',
            ],
            [
                'original_size_bytes' => $totals->total_original ?? 0,
                'converted_size_bytes' => $totals->total_converted ?? 0,
                'storage_saved_bytes' => $totals->total_saved ?? 0,
                'compression_ratio' => $compressionRatio,
                'file_count' => $totals->total_files ?? 0,
                'calculated_at' => now(),
            ]
        );
    }

    private function calculateContentTypeAnalytics(EmailSession $session): void
    {
        $contentTypes = ['text', 'html', 'mixed'];

        foreach ($contentTypes as $type) {
            $stats = EmailProcessingLog::where('email_session_id', $session->id)
                ->where('content_type', $type)
                ->selectRaw('
                    SUM(original_size_bytes) as total_original,
                    SUM(converted_size_bytes) as total_converted,
                    SUM(storage_saved_bytes) as total_saved,
                    COUNT(*) as total_files
                ')
                ->first();

            if ($stats && $stats->total_files > 0) {
                $compressionRatio = $stats->total_original > 0 
                    ? round((($stats->total_original - $stats->total_converted) / $stats->total_original) * 100, 2)
                    : 0;

                StorageAnalytics::updateOrCreate(
                    [
                        'email_session_id' => $session->id,
                        'content_type' => $type,
                    ],
                    [
                        'original_size_bytes' => $stats->total_original,
                        'converted_size_bytes' => $stats->total_converted,
                        'storage_saved_bytes' => $stats->total_saved,
                        'compression_ratio' => $compressionRatio,
                        'file_count' => $stats->total_files,
                        'calculated_at' => now(),
                    ]
                );
            }
        }
    }

    private function calculateFileTypeAnalytics(EmailSession $session): void
    {
        // Analyze attachment types
        $attachmentStats = EmailProcessingLog::where('email_session_id', $session->id)
            ->whereNotNull('attachments_info')
            ->get()
            ->flatMap(function ($log) {
                return $log->attachments_info ?? [];
            })
            ->groupBy('type')
            ->map(function ($group) {
                return [
                    'count' => $group->count(),
                    'total_size' => $group->sum('size'),
                ];
            });

        // Analyze image types
        $imageStats = EmailProcessingLog::where('email_session_id', $session->id)
            ->whereNotNull('images_info')
            ->get()
            ->flatMap(function ($log) {
                return $log->images_info ?? [];
            })
            ->groupBy('type')
            ->map(function ($group) {
                return [
                    'count' => $group->count(),
                    'total_size' => $group->sum('size'),
                ];
            });

        $fileTypesBreakdown = [
            'attachments' => $attachmentStats->toArray(),
            'images' => $imageStats->toArray(),
        ];

        // Update analytics for attachments and images
        foreach (['attachments', 'images'] as $type) {
            $typeStats = $type === 'attachments' ? $attachmentStats : $imageStats;
            $totalSize = $typeStats->sum('total_size');
            $totalCount = $typeStats->sum('count');

            if ($totalCount > 0) {
                StorageAnalytics::updateOrCreate(
                    [
                        'email_session_id' => $session->id,
                        'content_type' => $type,
                    ],
                    [
                        'original_size_bytes' => $totalSize,
                        'converted_size_bytes' => 0, // Attachments/images are referenced, not converted
                        'storage_saved_bytes' => $totalSize, // All attachment/image space is saved
                        'compression_ratio' => 100,
                        'file_count' => $totalCount,
                        'file_types_breakdown' => $typeStats->toArray(),
                        'calculated_at' => now(),
                    ]
                );
            }
        }
    }

    private function calculateSizeDistributionAnalytics(EmailSession $session): void
    {
        $logs = EmailProcessingLog::where('email_session_id', $session->id)->get();

        $sizeDistribution = [
            'small' => ['count' => 0, 'size' => 0], // < 1MB
            'medium' => ['count' => 0, 'size' => 0], // 1MB - 10MB
            'large' => ['count' => 0, 'size' => 0], // > 10MB
        ];

        foreach ($logs as $log) {
            $sizeMB = $log->original_size_bytes / 1024 / 1024;
            
            if ($sizeMB < 1) {
                $sizeDistribution['small']['count']++;
                $sizeDistribution['small']['size'] += $log->original_size_bytes;
            } elseif ($sizeMB <= 10) {
                $sizeDistribution['medium']['count']++;
                $sizeDistribution['medium']['size'] += $log->original_size_bytes;
            } else {
                $sizeDistribution['large']['count']++;
                $sizeDistribution['large']['size'] += $log->original_size_bytes;
            }
        }

        // Update the total analytics with size distribution
        $totalAnalytics = StorageAnalytics::where('email_session_id', $session->id)
            ->where('content_type', 'total')
            ->first();

        if ($totalAnalytics) {
            $totalAnalytics->update([
                'size_distribution' => $sizeDistribution,
            ]);
        }
    }

    private function calculateCurrentStorageStats(EmailSession $session): array
    {
        $logs = EmailProcessingLog::where('email_session_id', $session->id)->get();

        $stats = [
            'text_emails' => ['count' => 0, 'saved_mb' => 0],
            'html_emails' => ['count' => 0, 'saved_mb' => 0],
            'attachments' => ['count' => 0, 'saved_mb' => 0],
            'images' => ['count' => 0, 'saved_mb' => 0],
        ];

        foreach ($logs as $log) {
            $savedMB = $log->storage_saved_mb;
            
            switch ($log->content_type) {
                case 'text':
                    $stats['text_emails']['count']++;
                    $stats['text_emails']['saved_mb'] += $savedMB;
                    break;
                case 'html':
                    $stats['html_emails']['count']++;
                    $stats['html_emails']['saved_mb'] += $savedMB;
                    break;
                case 'mixed':
                    $stats['attachments']['count'] += $log->attachment_count;
                    $stats['images']['count'] += $log->image_count;
                    $stats['attachments']['saved_mb'] += $savedMB * 0.6; // Estimate
                    $stats['images']['saved_mb'] += $savedMB * 0.4; // Estimate
                    break;
            }
        }

        return $stats;
    }

    private function formatAnalyticsData(?StorageAnalytics $analytics): ?array
    {
        if (!$analytics) {
            return null;
        }

        return [
            'original_size_mb' => $analytics->original_size_mb,
            'converted_size_mb' => $analytics->converted_size_mb,
            'storage_saved_mb' => $analytics->storage_saved_mb,
            'original_size_gb' => $analytics->original_size_gb,
            'converted_size_gb' => $analytics->converted_size_gb,
            'storage_saved_gb' => $analytics->storage_saved_gb,
            'compression_ratio' => $analytics->compression_ratio,
            'file_count' => $analytics->file_count,
            'formatted_original_size' => $analytics->formatted_original_size,
            'formatted_converted_size' => $analytics->formatted_converted_size,
            'formatted_storage_saved' => $analytics->formatted_storage_saved,
        ];
    }

    private function generateChartsData($analytics): array
    {
        return [
            'storage_by_type' => $analytics->whereIn('content_type', ['text', 'html', 'attachments', 'images'])
                ->map(function ($item) {
                    return [
                        'label' => ucfirst($item->content_type),
                        'value' => $item->storage_saved_mb,
                    ];
                })->values()->toArray(),
            'compression_ratios' => $analytics->whereIn('content_type', ['text', 'html', 'mixed'])
                ->map(function ($item) {
                    return [
                        'label' => ucfirst($item->content_type),
                        'value' => $item->compression_ratio,
                    ];
                })->values()->toArray(),
        ];
    }

    private function estimateCompletion(EmailSession $session): ?string
    {
        if ($session->processed_emails === 0) {
            return null;
        }

        $startTime = $session->processing_started_at;
        $currentTime = now();
        $elapsedMinutes = $startTime->diffInMinutes($currentTime);
        
        if ($elapsedMinutes === 0) {
            return 'Calculating...';
        }

        $emailsPerMinute = $session->processed_emails / $elapsedMinutes;
        $remainingEmails = $session->total_emails - $session->processed_emails;
        
        if ($emailsPerMinute > 0) {
            $estimatedMinutes = ceil($remainingEmails / $emailsPerMinute);
            return $estimatedMinutes . ' minutes remaining';
        }

        return null;
    }
}
