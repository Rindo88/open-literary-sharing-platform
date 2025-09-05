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
        Schema::create('book_discussions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->constrained('books')->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('status', ['active', 'closed', 'archived'])->default('active');
            $table->integer('participants_count')->default(0);
            $table->integer('messages_count')->default(0);
            $table->timestamp('last_activity_at')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index(['book_id', 'status']);
            $table->index('last_activity_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_discussions');
    }
};
