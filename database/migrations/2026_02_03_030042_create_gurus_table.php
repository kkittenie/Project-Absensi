<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use App\Models\Guru;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('gurus', function (Blueprint $table) {
            $table->uuid('uuid')->nullable()->after('id');
            $table->string('photo')->nullable()->after('nomor_telepon');
            $table->boolean('is_active')->default(true)->index()->after('photo');
            $table->softDeletes()->index();
        });

        // isi uuid untuk data lama
        Guru::whereNull('uuid')->get()->each(function ($g) {
            $g->uuid = Str::uuid();
            $g->save();
        });

        // jadikan uuid unique + not null
        Schema::table('gurus', function (Blueprint $table) {
            $table->uuid('uuid')->unique()->nullable(false)->change();
        });
    }

    public function down(): void
    {
        Schema::table('gurus', function (Blueprint $table) {
            if (Schema::hasColumn('gurus', 'uuid')) {
                $table->dropColumn('uuid');
            }

            if (Schema::hasColumn('gurus', 'photo')) {
                $table->dropColumn('photo');
            }

            if (Schema::hasColumn('gurus', 'is_active')) {
                $table->dropColumn('is_active');
            }

            if (Schema::hasColumn('gurus', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
        });
    }

};
