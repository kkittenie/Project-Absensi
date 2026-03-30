<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Absensi;
use App\Models\Izin;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today()->toDateString();

        $totalGuru = Guru::where('is_active', true)->count();

        $totalGuruBulanLalu = Guru::where('is_active', true)
            ->whereMonth('created_at', now()->subMonth()->month)
            ->count();

        $totalGuruChange = $totalGuru - $totalGuruBulanLalu;

        $hadirHariIni = Absensi::whereDate('created_at', $today)
            ->whereIn('status', ['tepat_waktu', 'terlambat'])
            ->count();

        $izinHariIni = Absensi::whereDate('created_at', $today)
            ->where('status', 'izin')
            ->count();

        $alphaHariIni = Absensi::whereDate('created_at', $today)
            ->where('status', 'alpha')
            ->count();

        $persenKehadiran = $totalGuru > 0
            ? round(($hadirHariIni / $totalGuru) * 100)
            : 0;

        $chartData = $this->getChartData();

        $recentAbsensi = Absensi::with('guru')
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

            $hadir[] = Absensi::whereDate('created_at', $date)
                ->whereIn('status', ['tepat_waktu', 'terlambat'])
                ->count();

            $izin[] = Absensi::whereDate('created_at', $date)
                ->where('status', 'izin')
                ->count();

            $alpha[] = Absensi::whereDate('created_at', $date)
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