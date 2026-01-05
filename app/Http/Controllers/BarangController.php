<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class BarangController extends Controller
{
    /**
     * Tampilkan data barang dengan pagination 5 per halaman
     */
    public function index()
    {
        $barangs = Barang::orderBy('nama_barang', 'asc')
            ->paginate(25); // paginate 5 data per halaman
        return view('dashboard.barang.index', compact('barangs'));
    }

    /**
     * Form tambah barang
     */
    public function create()
    {
        return view('dashboard.barang.create');
    }

    /**
     * Simpan barang manual
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required',
            'type'        => 'required',
            'kode_barang' => 'required|unique:barangs,kode_barang',
            'kondisi'     => 'required',
            'foto'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $fotoPath = null;

        // cek kalau user upload foto
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')
                                ->store('barangs', 'public');
        }

        Barang::create([
            'nama_barang' => $request->nama_barang,
            'type'        => $request->type,
            'kode_barang' => $request->kode_barang,
            'kondisi'     => $request->kondisi,
            'status'      => 'tersedia',
            'foto'        => $fotoPath, // nullable
        ]);

        return redirect()
            ->route('barang.index')
            ->with('success', 'Barang berhasil ditambahkan');
    }

    /**
     * IMPORT BARANG DARI EXCEL
     * Urutan Excel:
     * A = nama_barang
     * B = type
     * C = kode_barang
     * D = kondisi
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx',
        ]);

        $data = Excel::toArray([], $request->file('file'));

        if (empty($data) || empty($data[0])) {
            return back()->with('error', 'File Excel kosong');
        }

        foreach ($data[0] as $index => $row) {

            // skip header
            if ($index === 0) continue;

            // minimal valid
            if (empty($row[0]) || empty($row[2])) continue;

            Barang::updateOrCreate(
                ['kode_barang' => trim($row[2])],
                [
                    'nama_barang' => trim($row[0]),
                    'type'        => trim($row[1]) ?? null,
                    'kondisi'     => trim($row[3]) ?? 'Baik',
                    'status'      => 'tersedia',
                ]
            );
        }

        return redirect()
            ->route('barang.index')
            ->with('success', 'Import barang berhasil');
    }

    /**
     * Edit barang
     */
    public function edit(Barang $barang)
    {
        return view('dashboard.barang.edit', compact('barang'));
    }

    /**
     * Update barang
     */
    public function update(Request $request, Barang $barang)
    {
        $request->validate([
            'nama_barang' => 'required',
            'type'        => 'required',
            'kode_barang' => 'required|unique:barangs,kode_barang,' . $barang->id,
            'kondisi'     => 'required',
            'foto'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // update field utama
        $barang->update([
            'nama_barang' => $request->nama_barang,
            'type'        => $request->type,
            'kode_barang' => $request->kode_barang,
            'kondisi'     => $request->kondisi,
        ]);

        // kalau upload foto baru
        if ($request->hasFile('foto')) {

            // hapus foto lama (kalau ada)
            if ($barang->foto && Storage::disk('public')->exists($barang->foto)) {
                Storage::disk('public')->delete($barang->foto);
            }

            // simpan foto baru
            $barang->update([
                'foto' => $request->file('foto')->store('barangs', 'public'),
            ]);
        }

        return redirect()
            ->route('barang.index')
            ->with('success', 'Barang berhasil diperbarui');
    }

    /**
     * Hapus barang
     */
    public function destroy(Barang $barang)
    {
        // hapus foto dari storage
        if ($barang->foto && Storage::disk('public')->exists($barang->foto)) {
            Storage::disk('public')->delete($barang->foto);
        }

        $barang->delete();
        return back()->with('success', 'Barang berhasil dihapus');
    }
}
