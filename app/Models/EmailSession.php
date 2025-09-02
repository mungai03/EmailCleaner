<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Crypt;

class EmailSession extends Model
{
    protected $fillable = [
        'session_id',
        'provider',
        'encrypted_credentials',
        'email_address',
        'status',
        'connection_settings',
        'total_emails',
        'processed_emails',
        'total_storage_bytes',
        'freed_storage_bytes',
        'connected_at',
        'processing_started_at',
        'processing_completed_at',
        'error_message',
    ];

    protected $casts = [
        'connection_settings' => 'array',
        'connected_at' => 'datetime',
        'processing_started_at' => 'datetime',
        'processing_completed_at' => 'datetime',
    ];

    public function processingLogs(): HasMany
    {
        return $this->hasMany(EmailProcessingLog::class);
    }

    public function storageAnalytics(): HasMany
    {
        return $this->hasMany(StorageAnalytics::class);
    }

    public function getDecryptedCredentialsAttribute(): array
    {
        return json_decode(Crypt::decryptString($this->encrypted_credentials), true);
    }

    public function setCredentialsAttribute(array $credentials): void
    {
        $this->encrypted_credentials = Crypt::encryptString(json_encode($credentials));
    }

    public function getProgressPercentageAttribute(): float
    {
        if ($this->total_emails === 0) {
            return 0;
        }
        return round(($this->processed_emails / $this->total_emails) * 100, 2);
    }

    public function getStorageSavedMbAttribute(): float
    {
        return round($this->freed_storage_bytes / 1024 / 1024, 2);
    }

    public function getStorageSavedGbAttribute(): float
    {
        return round($this->freed_storage_bytes / 1024 / 1024 / 1024, 2);
    }

    public function isProcessing(): bool
    {
        return in_array($this->status, ['connected', 'processing']);
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function hasFailed(): bool
    {
        return $this->status === 'failed';
    }
}
