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
        Schema::table('reading_sessions', function (Blueprint $table) {
            // Rename columns to match model
            $table->renameColumn('start_time', 'started_at');
            $table->renameColumn('end_time', 'ended_at');
            
            // Add missing columns
            $table->integer('pages_read')->nullable()->after('duration');
            $table->text('notes')->nullable()->after('pages_read');
            
            // Add current_page and total_pages columns
            $table->integer('current_page')->default(1)->after('notes');
            $table->integer('total_pages')->nullable()->after('current_page');
            $table->timestamp('last_read_at')->nullable()->after('total_pages');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reading_sessions', function (Blueprint $table) {
            // Revert changes
            $table->renameColumn('started_at', 'start_time');
            $table->renameColumn('ended_at', 'end_time');
            
            $table->dropColumn(['pages_read', 'notes', 'current_page', 'total_pages', 'last_read_at']);
        });
    }
};
