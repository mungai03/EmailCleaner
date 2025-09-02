<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('email_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->unique();
            $table->string('provider'); // gmail, yahoo, outlook, imap, pop3
            $table->text('encrypted_credentials'); // encrypted email credentials
            $table->string('email_address');
            $table->enum('status', ['connected', 'processing', 'completed', 'failed', 'disconnected'])->default('connected');
            $table->json('connection_settings')->nullable(); // IMAP/POP3 settings
            $table->integer('total_emails')->default(0);
            $table->integer('processed_emails')->default(0);
            $table->bigInteger('total_storage_bytes')->default(0);
            $table->bigInteger('freed_storage_bytes')->default(0);
            $table->timestamp('connected_at')->nullable();
            $table->timestamp('processing_started_at')->nullable();
            $table->timestamp('processing_completed_at')->nullable();
            $table->text('error_message')->nullable();
            $table->timestamps();

            $table->index(['session_id', 'status']);
            $table->index('email_address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_sessions');
    }
};
