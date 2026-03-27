<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('absensis', function (Blueprint $table) {
            // Tambah kolom yang belum ada
            if (!Schema::hasColumn('absensis', 'tanggal')) {
                $table->date('tanggal')->nullable();
            }
            if (!Schema::hasColumn('absensis', 'photo')) {
                $table->string('photo')->nullable();
            }
            if (!Schema::hasColumn('absensis', 'photo_pulang')) {
                $table->string('photo_pulang')->nullable();
            }
            if (!Schema::hasColumn('absensis', 'latitude')) {
                $table->decimal('latitude', 10, 8)->nullable();
            }
            if (!Schema::hasColumn('absensis', 'longitude')) {
                $table->decimal('longitude', 11, 8)->nullable();
            }
            if (!Schema::hasColumn('absensis', 'latitude_pulang')) {
                $table->decimal('latitude_pulang', 10, 8)->nullable();
            }
            if (!Schema::hasColumn('absensis', 'longitude_pulang')) {
                $table->decimal('longitude_pulang', 11, 8)->nullable();
            }
            if (!Schema::hasColumn('absensis', 'status')) {
                $table->enum('status', ['tepat_waktu', 'terlambat', 'alpha', 'izin'])->default('tepat_waktu');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
