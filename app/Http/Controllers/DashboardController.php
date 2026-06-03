<?php

namespace App\Http\Controllers;

use App\Models\Queue;
use App\Models\Mechanic;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Stats cards
        $totalAntrian  = Queue::count();
        $mekanikAktif  = Mechanic::count();
        $selesaiHariIni = Queue::where('status', 'completed')
            ->whereDate('updated_at', Carbon::today())
            ->count();
        $menunggu = Queue::where('status', 'waiting')->count();

        // Grafik 7 hari terakhir
        $labels = [];
        $totals = [];
        for ($i = 6; $i >= 0; $i--) {
            $date     = Carbon::today()->subDays($i);
            $labels[] = $date->format('d M');
            $totals[] = Queue::where('status', 'completed')
                ->whereDate('end_time', $date)
                ->sum('total_price');
        }

        // Log aktivitas terbaru
        $logs = Queue::with('mechanic')
            ->orderBy('updated_at', 'desc')
            ->limit(5)
            ->get();

        // Antrian berikutnya
        $nextQueues = Queue::with('service')
            ->where('status', 'waiting')
            ->orderBy('created_at', 'asc')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'totalAntrian', 'mekanikAktif', 'selesaiHariIni',
            'menunggu', 'labels', 'totals', 'logs', 'nextQueues'
        ));
    }
}