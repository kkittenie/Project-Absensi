<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Absensi;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Total Guru Aktif
        $totalGuru = Guru::where('is_active', true)->count();

        // Perubahan dari bulan lalu
        $totalGuruBulanLalu = Guru::where('is_active', true)
            ->whereMonth('created_at', now()->subMonth()->month)
            ->count();

        $totalGuruChange = $totalGuru - $totalGuruBulanLalu;

        // Data Hari Ini
        $today = Carbon::today();

        $hadirHariIni = Absensi::whereDate('created_at', $today)
            ->where('status', 'hadir')
            ->count();

        $izinHariIni = Absensi::whereDate('created_at', $today)
            ->where('status', 'izin')
            ->count();

        // Alpha = guru aktif yang belum absen hari ini
        $sudahAbsen = Absensi::whereDate('created_at', $today)
            ->pluck('guru_id');

        $alphaHariIni = Guru::where('is_active', true)
            ->whereNotIn('id', $sudahAbsen)
            ->count();

        // Persentase Kehadiran
        $totalGuruAktif = Guru::where('is_active', true)->count();

        $persenKehadiran = $totalGuruAktif > 0
            ? round(($hadirHariIni / $totalGuruAktif) * 100)
            : 0;

        // Data Chart 5 Hari Terakhir
        $chartData = $this->getChartData();

        // Absensi Terbaru (5 terakhir)
        $recentAbsensi = Absensi::with('guru')
            ->latest('created_at')
            ->take(5)
            ->get();

        return view('admin.dashboard', [
            'totalGuru' => $totalGuru,
            'totalGuruChange' => $totalGuruChange,
            'hadirHariIni' => $hadirHariIni,
            'izinHariIni' => $izinHariIni,
            'alphaHariIni' => $alphaHariIni,
            'persenKehadiran' => $persenKehadiran,
            'chartLabels' => $chartData['labels'],
            'chartHadir' => $chartData['hadir'],
            'chartIzin' => $chartData['izin'],
            'chartAlpha' => $chartData['alpha'],
            'recentAbsensi' => $recentAbsensi,
        ]);
    }

    private function getChartData()
    {
        $labels = [];
        $hadir = [];
        $izin = [];
        $alpha = [];

        // 5 hari terakhir
        for ($i = 4; $i >= 0; $i--) {

            $date = Carbon::today()->subDays($i);

            // Label hari
            $labels[] = $date->locale('id')->isoFormat('ddd');

            // Hadir
            $hadir[] = Absensi::whereDate('created_at', $date)
                ->where('status', 'hadir')
                ->count();

            // Izin
            $izin[] = Absensi::whereDate('created_at', $date)
                ->where('status', 'izin')
                ->count();

            // Alpha
            $sudahAbsen = Absensi::whereDate('created_at', $date)
                ->pluck('guru_id');

            $alpha[] = Guru::where('is_active', true)
                ->whereNotIn('id', $sudahAbsen)
                ->count();
        }

        return [
            'labels' => $labels,
            'hadir' => $hadir,
            'izin' => $izin,
            'alpha' => $alpha,
        ];
    }
}