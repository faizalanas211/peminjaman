<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\Barang;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    // public function index(): View
    // {
    //     $types = Barang::select('type')->distinct()->pluck('type');

    //     $dataBarang = [];

    //     foreach ($types as $type) {
    //         $total = Barang::where('type', $type)->count();

    //         $dipinjam = Peminjaman::whereHas('barang', function ($q) use ($type) {
    //             $q->where('type', $type);
    //         })
    //         ->whereNull('tanggal_kembali')
    //         ->count();

    //         $dataBarang[$type] = [
    //             'total'    => $total,
    //             'dipinjam' => $dipinjam,
    //             'ready'    => $total - $dipinjam,
    //         ];
    //     }

    //     return view('dashboard.main', compact('dataBarang'));
    // }

    // DashboardController.php
    public function index()
    {
        // Data statistik
        $totalBarang = Barang::count();
        $barangTersedia = Barang::where('status', 'tersedia')->count();
        $barangDipinjam = Barang::where('status', 'dipinjam')->count();
        $barangRusak = Barang::where('kondisi', 'perlu servis')->count();
        
        // Persentase
        $persentaseTersedia = $totalBarang > 0 ? round(($barangTersedia / $totalBarang) * 100) : 0;
        $persentaseDipinjam = $totalBarang > 0 ? round(($barangDipinjam / $totalBarang) * 100) : 0;
        $persentaseRusak = $totalBarang > 0 ? round(($barangRusak / $totalBarang) * 100) : 0;
        
        // Data slideshow peminjaman aktif
        $peminjamanAktif = Peminjaman::with('barang')
            ->where('status', 'dipinjam')
            ->whereHas('barang')
            ->orderBy('tanggal_pinjam', 'desc')
            ->take(10)
            ->get();
        
        // Data chart - grouping by kondisi
        $kondisiList = ['baik', 'sedang', 'rusak']; // Sesuaikan dengan data yang ada
        
        $dataBarang = [];
        foreach ($kondisiList as $kondisi) {
            $dataBarang[$kondisi] = [
                'tersedia' => Barang::where('kondisi', $kondisi)
                                ->where('status', 'tersedia')
                                ->count(),
                'dipinjam' => Barang::where('kondisi', $kondisi)
                                ->where('status', 'dipinjam')
                                ->count(),
                'rusak' => Barang::where('kondisi', $kondisi)
                            ->where('status', 'rusak')
                            ->count()
            ];
        }

        // Statistik per tipe barang
        $statPerType = Barang::select(
                'type',
                DB::raw("SUM(CASE WHEN status = 'tersedia' THEN 1 ELSE 0 END) as tersedia"),
                DB::raw("SUM(CASE WHEN status = 'dipinjam' THEN 1 ELSE 0 END) as dipinjam")
            )
            ->groupBy('type')
            ->get();
        
        return view('dashboard.main', compact(
            'totalBarang',
            'barangTersedia',
            'barangDipinjam',
            'barangRusak',
            'persentaseTersedia',
            'persentaseDipinjam',
            'persentaseRusak',
            'peminjamanAktif',
            'dataBarang',
            'statPerType'
        ));
    }
}
