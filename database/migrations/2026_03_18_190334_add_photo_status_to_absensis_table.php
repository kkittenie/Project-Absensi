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
            if (!Schema::hasColumn('absensis', 'photo')) {
                $table->string('photo')->nullable();
            }
            if (!Schema::hasColumn('absensis', 'photo_pulang')) {
                $table->string('photo_pulang')->nullable();
            }
            if (!Schema::hasColumn('absensis', 'status')) {
                $table->enum('status', ['hadir', 'alpha', 'izin'])->default('hadir');
            }
        });
    }

    public function down(): void
    {
        Schema::table('absensis', function (Blueprint $table) {
            $table->dropColumn([
                'jam_pulang',
                'lembur_menit',
                'photo',
                'photo_pulang',
                'status',
            ]);
        });
    }
};
