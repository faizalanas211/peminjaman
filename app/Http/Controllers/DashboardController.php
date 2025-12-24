<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\Barang;
use App\Models\Peminjaman;

class DashboardController extends Controller
{
    public function index(): View
    {
        $types = Barang::select('type')->distinct()->pluck('type');

        $dataBarang = [];

        foreach ($types as $type) {
            $total = Barang::where('type', $type)->count();

            $dipinjam = Peminjaman::whereHas('barang', function ($q) use ($type) {
                $q->where('type', $type);
            })
            ->whereNull('tanggal_kembali')
            ->count();

            $dataBarang[$type] = [
                'total'    => $total,
                'dipinjam' => $dipinjam,
                'ready'    => $total - $dipinjam,
            ];
        }

        return view('dashboard.main', compact('dataBarang'));
    }
}
