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
        Schema::create('email_processing_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('email_session_id')->constrained()->onDelete('cascade');
            $table->string('email_uid')->nullable(); // Email unique identifier
            $table->string('subject')->nullable();
            $table->string('sender')->nullable();
            $table->timestamp('email_date')->nullable();
            $table->enum('action', ['analyzed', 'converted', 'skipped', 'error']);
            $table->enum('content_type', ['text', 'html', 'mixed', 'attachment']);
            $table->integer('attachment_count')->default(0);
            $table->integer('image_count')->default(0);
            $table->bigInteger('original_size_bytes')->default(0);
            $table->bigInteger('converted_size_bytes')->default(0);
            $table->bigInteger('storage_saved_bytes')->default(0);
            $table->json('attachments_info')->nullable(); // Array of attachment details
            $table->json('images_info')->nullable(); // Array of image details
            $table->text('conversion_notes')->nullable();
            $table->text('error_details')->nullable();
            $table->string('output_file_path')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();

            $table->index(['email_session_id', 'action']);
            $table->index(['email_session_id', 'processed_at']);
            $table->index('email_uid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_processing_logs');
    }
};
