<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('gurus', function (Blueprint $table) {

            // buat kolom mapel_id dulu
            $table->foreignId('mapel_id')
                ->nullable()
                ->constrained('mapels')
                ->cascadeOnDelete();

        });
    }

    public function down(): void
    {
        Schema::table('gurus', function (Blueprint $table) {

            $table->dropForeign(['mapel_id']);
            $table->dropColumn('mapel_id');

        });
    }
};