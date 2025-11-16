<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->foreignId('author_id')->constrained('author_profiles')->onDelete('cascade');
            $table->string('publisher');
            $table->year('published_year');
            $table->integer('pages');
            $table->string('status')->default('published');
            $table->string('isbn')->nullable()->unique();
            $table->text('description');
            $table->string('cover_image')->nullable();
            $table->string('file_path')->nullable();

            $table->foreignId('category_id')->constrained()->onDelete('cascade');

            $table->timestamps();

            $table->index(['title', 'author_id', 'category_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
