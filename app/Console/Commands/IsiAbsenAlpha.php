<?php

namespace App\Console\Commands;

use App\Models\Absensi;
use App\Models\Kehadiran;
use App\Models\Guru;
use App\Models\Waktu;
use App\Models\HariLibur;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Carbon\Carbon;

class IsiAbsenAlpha extends Command
{
    protected $signature   = 'absensi:isi-alpha';
    protected $description = 'Otomatis isi alpha untuk guru yang tidak absen masuk';

    public function handle()
    {
        $today = now()->toDateString();
        $jam   = Waktu::first();

        if (!$jam) {
            $this->error('Pengaturan jam belum ada.');
            return;
        }

        // Cek apakah hari ini hari libur mingguan
        $namaHari = Carbon::parse($today)->locale('id')->isoFormat('dddd');
        if (in_array($namaHari, $jam->hari_libur_mingguan ?? [])) {
            $this->info("Hari ini {$namaHari} — hari libur, skip.");
            return;
        }

        // Cek apakah hari ini tanggal merah
        if (HariLibur::where('tanggal', $today)->exists()) {
            $this->info('Hari ini tanggal merah — hari libur, skip.');
            return;
        }

        // Cek apakah sudah lewat batas tap in
        $jamSekarang  = now()->format('H:i');
        $batasAlpha   = $jam->akhir_tap_in;

        if ($jamSekarang < $batasAlpha) {
            $this->info("Belum melewati batas jam absen masuk ({$batasAlpha}).");
            return;
        }

        $semuaGuru = Guru::whereNull('deleted_at')->get();

        foreach ($semuaGuru as $guru) {
            $sudahAbsen = Absensi::where('guru_id', $guru->id)
                ->whereDate('created_at', $today)
                ->exists();

            if (!$sudahAbsen) {
                Absensi::create([
                    'uuid'    => Str::uuid(),
                    'guru_id' => $guru->id,
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