<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('absensis', function (Blueprint $table) {
            // Hapus kolom yang tidak diperlukan
            $cols = [];

            if (Schema::hasColumn('absensis', 'jam_pulang'))   $cols[] = 'jam_pulang';
            if (Schema::hasColumn('absensis', 'waktu_absen'))  $cols[] = 'waktu_absen';
            if (Schema::hasColumn('absensis', 'waktu_pulang')) $cols[] = 'waktu_pulang';
            if (Schema::hasColumn('absensis', 'lembur_menit')) $cols[] = 'lembur_menit';

            if (!empty($cols)) {
                $table->dropColumn($cols);
            }

            // Fix nullable
            $table->decimal('latitude', 10, 8)->nullable()->change();
            $table->decimal('longitude', 11, 8)->nullable()->change();
            $table->string('photo')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('absensis', function (Blueprint $table) {
            $table->timestamp('waktu_absen')->nullable();
            $table->timestamp('waktu_pulang')->nullable();
            $table->time('jam_pulang')->nullable();
            $table->integer('lembur_menit')->default(0);
        });
    }
};