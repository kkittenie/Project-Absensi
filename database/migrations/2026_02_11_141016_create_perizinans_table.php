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
        Schema::table('izins', function (Blueprint $table) {
            $table->enum('status', ['menunggu', 'disetujui', 'ditolak'])
                  ->default('menunggu')
                  ->after('tanggal_izin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::table('izins', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
