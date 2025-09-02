<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmailProcessingLog extends Model
{
    protected $fillable = [
        'email_session_id',
        'email_uid',
        'subject',
        'sender',
        'email_date',
        'action',
        'content_type',
        'attachment_count',
        'image_count',
        'original_size_bytes',
        'converted_size_bytes',
        'storage_saved_bytes',
        'attachments_info',
        'images_info',
        'conversion_notes',
        'error_details',
        'output_file_path',
        'processed_at',
    ];

    protected $casts = [
        'email_date' => 'datetime',
        'processed_at' => 'datetime',
        'attachments_info' => 'array',
        'images_info' => 'array',
    ];

    public function emailSession(): BelongsTo
    {
        return $this->belongsTo(EmailSession::class);
    }

    public function getStorageSavedMbAttribute(): float
    {
        return round($this->storage_saved_bytes / 1024 / 1024, 2);
    }

    public function getOriginalSizeMbAttribute(): float
    {
        return round($this->original_size_bytes / 1024 / 1024, 2);
    }

    public function getConvertedSizeMbAttribute(): float
    {
        return round($this->converted_size_bytes / 1024 / 1024, 2);
    }

    public function getCompressionRatioAttribute(): float
    {
        if ($this->original_size_bytes === 0) {
            return 0;
        }
        return round((($this->original_size_bytes - $this->converted_size_bytes) / $this->original_size_bytes) * 100, 2);
    }

    public function hasAttachments(): bool
    {
        return $this->attachment_count > 0;
    }

    public function hasImages(): bool
    {
        return $this->image_count > 0;
    }

    public function wasSuccessful(): bool
    {
        return in_array($this->action, ['analyzed', 'converted']);
    }
}
