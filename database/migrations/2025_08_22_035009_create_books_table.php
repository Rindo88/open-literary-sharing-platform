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
            $table->string('author');
            $table->string('publisher');
            $table->year('publication_year');
            $table->integer('pages');
            $table->string('isbn')->nullable()->unique();
            $table->text('synopsis');
            $table->string('cover_image')->nullable();
            $table->string('file_path')->nullable();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->boolean('is_available')->default(true);
            $table->integer('total_copies')->default(1);
            $table->integer('available_copies')->default(1);
            $table->timestamps();

            $table->index(['title', 'author']);
            $table->index('category_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
