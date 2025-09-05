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
        Schema::table('discussion_participants', function (Blueprint $table) {
            // Drop the existing role column
            $table->dropColumn('role');
        });

        Schema::table('discussion_participants', function (Blueprint $table) {
            // Recreate the role column with proper enum
            $table->enum('role', ['moderator', 'participant', 'viewer'])->default('participant')->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('discussion_participants', function (Blueprint $table) {
            $table->dropColumn('role');
            $table->string('role')->default('participant')->after('user_id');
        });
    }
};
