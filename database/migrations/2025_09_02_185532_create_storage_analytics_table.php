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
        Schema::create('storage_analytics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('email_session_id')->constrained()->onDelete('cascade');
            $table->enum('content_type', ['text', 'images', 'attachments', 'html', 'total']);
            $table->bigInteger('original_size_bytes')->default(0);
            $table->bigInteger('converted_size_bytes')->default(0);
            $table->bigInteger('storage_saved_bytes')->default(0);
            $table->decimal('compression_ratio', 5, 2)->default(0); // Percentage
            $table->integer('file_count')->default(0);
            $table->json('file_types_breakdown')->nullable(); // Breakdown by file extensions
            $table->json('size_distribution')->nullable(); // Small, medium, large files
            $table->timestamp('calculated_at')->nullable();
            $table->timestamps();

            $table->index(['email_session_id', 'content_type']);
            $table->index(['email_session_id', 'calculated_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('storage_analytics');
    }
};
