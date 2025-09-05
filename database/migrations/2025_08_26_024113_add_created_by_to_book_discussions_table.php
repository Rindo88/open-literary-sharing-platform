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
        Schema::table('book_discussions', function (Blueprint $table) {
            if (!Schema::hasColumn('book_discussions', 'created_by')) {
                $table->unsignedBigInteger('created_by')->after('book_id')->nullable();
            }
            if (!Schema::hasColumn('book_discussions', 'is_private')) {
                $table->boolean('is_private')->after('status')->default(false);
            }
            if (!Schema::hasColumn('book_discussions', 'max_participants')) {
                $table->integer('max_participants')->after('is_private')->nullable();
            }
        });

        // Add foreign key constraint for created_by
        Schema::table('book_discussions', function (Blueprint $table) {
            if (Schema::hasColumn('book_discussions', 'created_by')) {
                $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop foreign key constraint first
        Schema::table('book_discussions', function (Blueprint $table) {
            if (Schema::hasColumn('book_discussions', 'created_by')) {
                $table->dropForeign(['created_by']);
            }
        });

        Schema::table('book_discussions', function (Blueprint $table) {
            if (Schema::hasColumn('book_discussions', 'created_by')) {
                $table->dropColumn('created_by');
            }
            if (Schema::hasColumn('book_discussions', 'is_private')) {
                $table->dropColumn('is_private');
            }
            if (Schema::hasColumn('book_discussions', 'max_participants')) {
                $table->dropColumn('max_participants');
            }
        });
    }
};
