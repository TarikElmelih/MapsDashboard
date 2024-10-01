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
        Schema::table('users', function (Blueprint $table) {
            $table->integer('commitment_points')->default(0);
            $table->integer('participation_points')->default(0);
            $table->integer('test_points')->default(0);
            $table->integer('projects_count')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['commitment_points', 'participation_points', 'test_points', 'projects_count']);
        });
    }
};
