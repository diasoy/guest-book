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
        Schema::table('tamu', function (Blueprint $table) {
            // Drop the user_id column
            if (Schema::hasColumn('tamu', 'user_id')) {
                $table->dropForeign(['user_id']); // Drop foreign key if it exists
                $table->dropColumn('user_id');
            }
            
            // Add the image_url column
            if (!Schema::hasColumn('tamu', 'image_url')) {
                $table->string('image_url')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tamu', function (Blueprint $table) {
            // Restore the user_id column
            if (!Schema::hasColumn('tamu', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable();
                $table->foreign('user_id')->references('id')->on('users');
            }
            
            // Remove the image_url column
            if (Schema::hasColumn('tamu', 'image_url')) {
                $table->dropColumn('image_url');
            }
        });
    }
};