<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('izins', 'status')) {

            Schema::table('izins', function (Blueprint $table) {

                $table->enum('status', [
                    'menunggu',
                    'disetujui',
                    'ditolak'
                ])->default('menunggu');

            });

        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('izins', 'status')) {

            Schema::table('izins', function (Blueprint $table) {

                $table->dropColumn('status');

            });

        }
    }
};