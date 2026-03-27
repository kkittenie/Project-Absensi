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
        $today = Carbon::today()->toDateString();

        // Total Guru Aktif
        $totalGuru = Guru::where('is_active', true)->count();

        // Perubahan dari bulan lalu
        $totalGuruBulanLalu = Guru::where('is_active', true)
            ->whereMonth('created_at', now()->subMonth()->month)
            ->count();

        $totalGuruChange = $totalGuru - $totalGuruBulanLalu;

        // Hadir = tepat_waktu + terlambat
        $hadirHariIni = Absensi::whereDate('tanggal', $today)
            ->whereIn('status', ['tepat_waktu', 'terlambat'])
            ->count();

        // Izin
        $izinHariIni = Absensi::whereDate('tanggal', $today)
            ->where('status', 'izin')
            ->count();

        // Alpha
        $alphaHariIni = Absensi::whereDate('tanggal', $today)
            ->where('status', 'alpha')
            ->count();

        // Persentase Kehadiran
        $persenKehadiran = $totalGuru > 0
            ? round(($hadirHariIni / $totalGuru) * 100)
            : 0;

        // Data Chart 5 Hari Terakhir
        $chartData = $this->getChartData();

        // Absensi Terbaru (5 terakhir)
        $recentAbsensi = Absensi::with('guru')
            ->orderBy('tanggal', 'desc')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', [
            'totalGuru'       => $totalGuru,
            'totalGuruChange' => $totalGuruChange,
            'hadirHariIni'    => $hadirHariIni,
            'izinHariIni'     => $izinHariIni,
            'alphaHariIni'    => $alphaHariIni,
            'persenKehadiran' => $persenKehadiran,
            'chartLabels'     => $chartData['labels'],
            'chartHadir'      => $chartData['hadir'],
            'chartIzin'       => $chartData['izin'],
            'chartAlpha'      => $chartData['alpha'],
            'recentAbsensi'   => $recentAbsensi,
        ]);
    }

    private function getChartData()
    {
        $labels = [];
        $hadir  = [];
        $izin   = [];
        $alpha  = [];

        for ($i = 4; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i)->toDateString();

            $labels[] = Carbon::parse($date)->locale('id')->isoFormat('ddd, D MMM');

            $hadir[] = Absensi::whereDate('tanggal', $date)
                ->whereIn('status', ['tepat_waktu', 'terlambat'])
                ->count();

            $izin[] = Absensi::whereDate('tanggal', $date)
                ->where('status', 'izin')
                ->count();

            $alpha[] = Absensi::whereDate('tanggal', $date)
                ->where('status', 'alpha')
                ->count();
        }

        return [
            'labels' => $labels,
            'hadir'  => $hadir,
            'izin'   => $izin,
            'alpha'  => $alpha,
        ];
    }
}