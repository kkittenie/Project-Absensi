<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestAbsen extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:absen';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $guruIds = [25, 26];

        foreach ($guruIds as $id) {
            \App\Models\Kehadiran::create([
                'guru_id' => $id,
                'tanggal' => now()->toDateString(),
                'jam_masuk' => '07:00:00',
                'jam_pulang' => '14:00:00',
            ]);

            \App\Models\Kehadiran::create([
                'guru_id' => $id,
                'tanggal' => now()->subDay()->toDateString(),
                'jam_masuk' => '08:30:00', // terlambat
                'jam_pulang' => '12:00:00', // pulang cepat
            ]);

            \App\Models\Kehadiran::create([
                'guru_id' => $id,
                'tanggal' => now()->subDays(2)->toDateString(),
                'jam_masuk' => '07:00:00',
                'jam_pulang' => '16:30:00',
            ]);
        }

        $this->info('Data absen test berhasil dibuat!');
    }
}
