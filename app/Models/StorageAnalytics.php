<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StorageAnalytics extends Model
{
    protected $fillable = [
        'email_session_id',
        'content_type',
        'original_size_bytes',
        'converted_size_bytes',
        'storage_saved_bytes',
        'compression_ratio',
        'file_count',
        'file_types_breakdown',
        'size_distribution',
        'calculated_at',
    ];

    protected $casts = [
        'file_types_breakdown' => 'array',
        'size_distribution' => 'array',
        'calculated_at' => 'datetime',
        'compression_ratio' => 'decimal:2',
    ];

    public function emailSession(): BelongsTo
    {
        return $this->belongsTo(EmailSession::class);
    }

    public function getOriginalSizeMbAttribute(): float
    {
        return round($this->original_size_bytes / 1024 / 1024, 2);
    }

    public function getConvertedSizeMbAttribute(): float
    {
        return round($this->converted_size_bytes / 1024 / 1024, 2);
    }

    public function getStorageSavedMbAttribute(): float
    {
        return round($this->storage_saved_bytes / 1024 / 1024, 2);
    }

    public function getOriginalSizeGbAttribute(): float
    {
        return round($this->original_size_bytes / 1024 / 1024 / 1024, 2);
    }

    public function getConvertedSizeGbAttribute(): float
    {
        return round($this->converted_size_bytes / 1024 / 1024 / 1024, 2);
    }

    public function getStorageSavedGbAttribute(): float
    {
        return round($this->storage_saved_bytes / 1024 / 1024 / 1024, 2);
    }

    public function getFormattedOriginalSizeAttribute(): string
    {
        return $this->formatBytes($this->original_size_bytes);
    }

    public function getFormattedConvertedSizeAttribute(): string
    {
        return $this->formatBytes($this->converted_size_bytes);
    }

    public function getFormattedStorageSavedAttribute(): string
    {
        return $this->formatBytes($this->storage_saved_bytes);
    }

    private function formatBytes(int $bytes): string
    {
        if ($bytes >= 1073741824) {
            return round($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return round($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return round($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' B';
        }
    }
}
