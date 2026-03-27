<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('absensis', function (Blueprint $table) {
            $table->timestamp('waktu_pulang')->nullable()->after('waktu_absen');
            $table->string('photo_pulang')->nullable()->after('photo');
            $table->decimal('latitude_pulang', 10, 8)->nullable()->after('longitude');
            $table->decimal('longitude_pulang', 11, 8)->nullable()->after('latitude_pulang');
        });
    }

    public function down(): void
    {
        Schema::table('absensis', function (Blueprint $table) {
            $table->dropColumn([
                'waktu_pulang',
                'photo_pulang',
                'latitude_pulang',
                'longitude_pulang',
            ]);
        });
    }
};