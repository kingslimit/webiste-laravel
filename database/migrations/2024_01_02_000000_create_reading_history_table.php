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
        Schema::create('reading_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('book_identifier')->index();
            $table->text('book_title');
            $table->string('book_author', 500)->nullable();
            $table->text('book_cover')->nullable();
            $table->enum('action_type', ['viewed', 'downloaded'])->default('viewed');
            $table->timestamp('accessed_at')->nullable();
            $table->timestamps();
            
            // Composite indexes for better query performance
            $table->index(['user_id', 'book_identifier']);
            $table->index(['accessed_at', 'action_type']);
            $table->index('accessed_at');
            
            // MySQL specific optimization
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reading_history');
    }
};