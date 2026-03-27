<?php

namespace App\Console\Commands;

use App\Models\Absensi;
use App\Models\Kehadiran;
use App\Models\Guru;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class IsiAbsenAlpha extends Command
{
    protected $signature = 'absensi:isi-alpha {--force : Bypass cek hari dan jam}';
    protected $description = 'Otomatis isi alpha untuk guru yang tidak absen masuk';

    const BATAS_JAM_MASUK = '09:00';

    public function handle()
    {
        $hariIni = now()->dayOfWeek;

        if (in_array($hariIni, [0, 6])) {
            $this->info('Hari libur (Sabtu/Minggu), skip.');
            return;
        }

        $jamSekarang = now()->format('H:i');

        if ($jamSekarang < self::BATAS_JAM_MASUK) {
            $this->info('Belum melewati batas jam absen masuk.');
            return;
        }

        $today     = now()->toDateString();
        $semuaGuru = Guru::all();

        foreach ($semuaGuru as $guru) {
            $sudahAbsen = Absensi::where('guru_id', $guru->id)
                ->where('tanggal', $today)
                ->exists();

            if (!$sudahAbsen) {
                Absensi::create([
                    'uuid'    => Str::uuid(),
                    'guru_id' => $guru->id,
                    'tanggal' => $today,
                    'status'  => 'alpha',
                ]);

                Kehadiran::create([
                    'guru_id'    => $guru->id,
                    'tanggal'    => $today,
                    'jam_masuk'  => null,
                    'jam_pulang' => null,
                ]);

                $this->info("Alpha: {$guru->nama_guru}");
            }
        }

        $this->info('Selesai.');
    }
}