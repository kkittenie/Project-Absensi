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
        Schema::create('gurus', function (Blueprint $table) {
            $table->id(); // primary key
            $table->uuid('uuid')->nullable(); // uuid optional
            $table->string('nama_guru'); // nama guru
            $table->string('nip')->unique(); // nip unik
            $table->string('password'); // password login
            $table->boolean('is_active')->default(true); // status aktif
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gurus');
    }
};