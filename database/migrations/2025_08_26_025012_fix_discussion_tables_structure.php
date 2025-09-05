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
        // Fix discussion_participants table
        Schema::table('discussion_participants', function (Blueprint $table) {
            // Remove unwanted column
            if (Schema::hasColumn('discussion_participants', 'edited_at')) {
                $table->dropColumn('edited_at');
            }
            
            // Ensure proper data types for datetime fields
            if (Schema::hasColumn('discussion_participants', 'joined_at')) {
                $table->timestamp('joined_at')->change();
            }
            if (Schema::hasColumn('discussion_participants', 'last_read_at')) {
                $table->timestamp('last_read_at')->nullable()->change();
            }
        });

        // Fix discussion_messages table
        Schema::table('discussion_messages', function (Blueprint $table) {
            // Ensure proper data types for datetime fields
            if (Schema::hasColumn('discussion_messages', 'created_at')) {
                $table->timestamp('created_at')->change();
            }
            if (Schema::hasColumn('discussion_messages', 'updated_at')) {
                $table->timestamp('updated_at')->change();
            }
            if (Schema::hasColumn('discussion_messages', 'edited_at')) {
                $table->timestamp('edited_at')->nullable()->change();
            }
        });

        // Fix book_discussions table
        Schema::table('book_discussions', function (Blueprint $table) {
            // Ensure proper data types for datetime fields
            if (Schema::hasColumn('book_discussions', 'last_activity_at')) {
                $table->timestamp('last_activity_at')->nullable()->change();
            }
            if (Schema::hasColumn('book_discussions', 'created_at')) {
                $table->timestamp('created_at')->change();
            }
            if (Schema::hasColumn('book_discussions', 'updated_at')) {
                $table->timestamp('updated_at')->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This migration is for fixing structure, no rollback needed
    }
};
