<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kehadirans', function (Blueprint $table) {
            $table->id();

            $table->foreignId('guru_id')
                ->constrained('gurus')
                ->cascadeOnDelete();

            $table->date('tanggal');
            $table->time('jam_masuk')->nullable();
            $table->time('jam_pulang')->nullable();
            $table->integer('lembur_menit')->default(0);

            $table->timestamps();

            // satu guru cuma boleh 1 absen per hari
            $table->unique(['guru_id', 'tanggal']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kehadirans');
    }
};
