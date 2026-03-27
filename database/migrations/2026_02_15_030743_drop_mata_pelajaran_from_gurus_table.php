<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('gurus', 'mata_pelajaran')) {

            Schema::table('gurus', function (Blueprint $table) {
                $table->dropColumn('mata_pelajaran');
            });

        }
    }

    public function down(): void
    {
        //
    }
};