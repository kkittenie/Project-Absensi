<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('waktus', function (Blueprint $table) {
            if (Schema::hasColumn('waktus', 'guru_id')) {
                $table->dropForeign(['guru_id']);
                $table->dropColumn('guru_id');
            }
            if (Schema::hasColumn('waktus', 'tanggal')) {
                $table->dropColumn('tanggal');
            }
            if (Schema::hasColumn('waktus', 'jam_masuk')) {
                $table->dropColumn('jam_masuk');
            }
            if (Schema::hasColumn('waktus', 'jam_pulang')) {
                $table->dropColumn('jam_pulang');
            }

            if (!Schema::hasColumn('waktus', 'mulai_tap_in')) {
                $table->time('mulai_tap_in')->default('06:00');
            }
            if (!Schema::hasColumn('waktus', 'akhir_tap_in')) {
                $table->time('akhir_tap_in')->default('09:00');
            }
            if (!Schema::hasColumn('waktus', 'batas_terlambat')) {
                $table->time('batas_terlambat')->default('07:00');
            }
            if (!Schema::hasColumn('waktus', 'mulai_tap_out')) {
                $table->time('mulai_tap_out')->default('13:00');
            }
            if (!Schema::hasColumn('waktus', 'akhir_tap_out')) {
                $table->time('akhir_tap_out')->default('15:00');
            }
        });
    }

    public function down(): void
    {
        Schema::table('waktus', function (Blueprint $table) {
            $table->dropColumn([
                'mulai_tap_in', 'akhir_tap_in', 'batas_terlambat',
                'mulai_tap_out', 'akhir_tap_out'
            ]);
            $table->foreignId('guru_id')->nullable()->constrained('gurus')->cascadeOnDelete();
            $table->date('tanggal')->nullable();
            $table->time('jam_masuk')->nullable();
            $table->time('jam_pulang')->nullable();
        });
    }
};