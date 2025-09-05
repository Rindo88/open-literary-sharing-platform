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
        Schema::table('books', function (Blueprint $table) {
            // Rename synopsis to description
            $table->renameColumn('synopsis', 'description');
            
            // Add missing columns
            $table->year('published_year')->after('author');
            $table->string('status')->default('published')->after('pages');
            
            // Drop columns that are not needed
            $table->dropColumn(['publication_year', 'is_available', 'total_copies', 'available_copies']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            // Revert changes
            $table->renameColumn('description', 'synopsis');
            $table->year('publication_year')->after('author');
            $table->boolean('is_available')->default(true)->after('category_id');
            $table->integer('total_copies')->default(1)->after('is_available');
            $table->integer('available_copies')->default(1)->after('total_copies');
            
            $table->dropColumn(['published_year', 'status']);
        });
    }
};
