<?php

namespace App\Console\Commands;

use App\Models\Absensi;
use App\Models\Kehadiran;
use App\Models\Guru;
use Illuminate\Console\Command;

class IsiAbsenAlpha extends Command
{
    protected $signature   = 'absensi:isi-alpha';
    protected $description = 'Otomatis isi alpha untuk guru yang tidak absen masuk';

    const BATAS_JAM_MASUK = '09:00';

    public function handle()
    {
        $jamSekarang = now()->format('H:i');

        if ($jamSekarang < self::BATAS_JAM_MASUK) {
            $this->info('Belum melewati batas jam absen masuk.');
            return;
        }

        $today     = now()->toDateString();
        $semuaGuru = Guru::whereNull('deleted_at')->get();

        foreach ($semuaGuru as $guru) {
            $sudahAbsen = Absensi::where('guru_id', $guru->id)
                ->where('tanggal', $today)
                ->exists();

            if (!$sudahAbsen) {
                Absensi::create([
                    'guru_id' => $guru->id,
                    'tanggal' => $today,
                    'status'  => 'alpha',
                ]);

                Kehadiran::create([
                    'guru_id'   => $guru->id,
                    'tanggal'   => $today,
                    'jam_masuk' => null,
                    'jam_pulang'=> null,
                ]);

                $this->info("Alpha: {$guru->nama_guru}");
            }
        }

        $this->info('Selesai.');
    }
}