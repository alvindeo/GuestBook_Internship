<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Kunjungan;
use App\Models\Pengunjung;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Jumlah tamu per hari (7 hari terakhir)
        $tamuPerHari = Kunjungan::select(DB::raw('DATE(tanggal_jam_masuk) as date'), DB::raw('count(*) as total'))
            ->groupBy('date')
            ->orderBy('date', 'asc') // Changed to asc for better chart flow
            ->take(7)
            ->get();

        // 2. Asal instansi terbanyak
        $instansiTerbanyak = Pengunjung::select('asal_institusi', DB::raw('count(*) as total'))
            ->groupBy('asal_institusi')
            ->orderBy('total', 'desc')
            ->take(5)
            ->get();

        // 3. Pengunjung lama yang hadir lagi
        $returningVisitorsCount = Kunjungan::whereIn('id_pengunjung', function($query) {
            $query->select('id_pengunjung')->from('data_kunjungan')->groupBy('id_pengunjung')->havingRaw('count(*) > 1');
        })->distinct('id_pengunjung')->count();
        
        $totalVisitors = Pengunjung::count();

        // 4. Rata-rata durasi kunjungan
        $avgWeek = Kunjungan::where('status', 'OUT')->where('tanggal_jam_masuk', '>=', now()->startOfWeek())->avg('durasi_kunjungan') ?? 0;
        $avgMonth = Kunjungan::where('status', 'OUT')->where('tanggal_jam_masuk', '>=', now()->startOfMonth())->avg('durasi_kunjungan') ?? 0;
        $avgYear = Kunjungan::where('status', 'OUT')->where('tanggal_jam_masuk', '>=', now()->startOfYear())->avg('durasi_kunjungan') ?? 0;

        // 5. Tamu yang masih di dalam
        $tamuDiDalam = Kunjungan::where('status', 'IN')->with('pengunjung')->get();

        return view('dashboard', compact(
            'tamuPerHari', 
            'instansiTerbanyak', 
            'returningVisitorsCount', 
            'totalVisitors',
            'avgWeek',
            'avgMonth',
            'avgYear',
            'tamuDiDalam'
        ));
    }

    public function report(Request $request)
    {
        $periode = $request->get('periode', 'week');
        $query = Kunjungan::with('pengunjung');

        if ($periode == 'week') {
            $query->where('tanggal_jam_masuk', '>=', now()->startOfWeek());
        } elseif ($periode == 'month') {
            $query->where('tanggal_jam_masuk', '>=', now()->startOfMonth());
        } elseif ($periode == 'year') {
            $query->where('tanggal_jam_masuk', '>=', now()->startOfYear());
        }

        $reports = $query->orderBy('tanggal_jam_masuk', 'desc')->get();

        return view('admin.reports', compact('reports', 'periode'));
    }

    public function updateStatus(Request $request, $id)
    {
        $kunjungan = Kunjungan::findOrFail($id);
        $newStatus = $request->status;
        
        if ($newStatus == 'OUT' && $kunjungan->status == 'IN') {
            $masuk = Carbon::parse($kunjungan->tanggal_jam_masuk);
            $keluar = now();
            $durasi = $masuk->diffInMinutes($keluar);
            
            $kunjungan->update([
                'status' => 'OUT',
                'tanggal_jam_keluar' => $keluar,
                'durasi_kunjungan' => $durasi
            ]);
        } elseif ($newStatus == 'IN' && $kunjungan->status == 'OUT') {
            $kunjungan->update([
                'status' => 'IN',
                'tanggal_jam_keluar' => null,
                'durasi_kunjungan' => 0
            ]);
        }
        
        return redirect()->back()->with('success', 'Status kunjungan berhasil diperbarui!');
    }
}
