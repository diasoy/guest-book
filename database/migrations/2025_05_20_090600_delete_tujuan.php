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
            // Drop the tujuan column
            if (Schema::hasColumn('tamu', 'tujuan')) {
                $table->dropColumn('tujuan');
            }

            // Drop kunjungan if it exists
            if (Schema::hasColumn('tamu', 'kunjungan')) {
                $table->dropColumn('kunjungan');
            }

            // Make sure other necessary fields exist
            if (!Schema::hasColumn('tamu', 'nama')) {
                $table->string('nama');
            }
            if (!Schema::hasColumn('tamu', 'instansi')) {
                $table->string('instansi')->nullable();
            }
            if (!Schema::hasColumn('tamu', 'telepon')) {
                $table->string('telepon')->nullable();
            }
            if (!Schema::hasColumn('tamu', 'email')) {
                $table->string('email')->nullable();
            }
            if (!Schema::hasColumn('tamu', 'keperluan')) {
                $table->text('keperluan');
            }
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
        // Add back the tujuan column if needed
        Schema::table('tamu', function (Blueprint $table) {
            if (!Schema::hasColumn('tamu', 'tujuan')) {
                $table->string('tujuan')->nullable();
            }
        });
    }
};
