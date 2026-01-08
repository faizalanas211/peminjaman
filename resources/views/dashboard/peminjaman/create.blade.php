@extends('layouts.admin')

@section('breadcrumb')
<li class="breadcrumb-item">
    <a href="{{ route('peminjaman.index') }}">Riwayat Penggunaan Barang</a>
</li>
<li class="breadcrumb-item active text-primary fw-semibold">
    Tambah Penggunaan
</li>
@endsection

@section('content')

<div class="card card-flush shadow-sm rounded-4">

    {{-- ================= HEADER ================= --}}
    <div class="card-header border-0 pt-6 pb-4">
        <h3 class="fw-bold mb-1">Form Penggunaan Barang</h3>
        <p class="text-muted mb-0 fs-7">
            Isi data penggunaan barang inventaris
        </p>
    </div>

    <div class="card-body">

        <form action="{{ route('peminjaman.store') }}" method="POST">
            @csrf

            <div class="row g-4">

                {{-- PENGGUNA --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Nama Pengguna</label>
                    <input type="text"
                           name="nama_peminjam"
                           class="form-control"
                           placeholder="Contoh: Ahmad Fauzi"
                           required>
                </div>

                {{-- BAGIAN / UNIT --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Bagian / Unit</label>
                    <input type="text"
                           name="kelas"
                           class="form-control"
                           placeholder="Kepegawaian / Humas / Umum"
                           required>
                </div>

                {{-- BARANG --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Barang</label>
                    <select name="barang_id" class="form-select" required>
                        <option value="">-- Pilih Barang --</option>
                        @foreach($barangs as $barang)
                            <option value="{{ $barang->id }}">
                                {{ $barang->nama_barang }} ({{ $barang->kode_barang }})
                            </option>
                        @endforeach
                    </select>
                    <small class="text-muted">
                        Pilih barang inventaris yang akan digunakan
                    </small>
                </div>

                {{-- TANGGAL PENGGUNAAN --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Tanggal Penggunaan</label>
                    <input type="date"
                           name="tanggal_pinjam"
                           class="form-control"
                           value="{{ date('Y-m-d') }}"
                           required>
                </div>

            </div>

            {{-- ================= ACTION ================= --}}
            <div class="d-flex justify-content-end mt-5">
                <a href="{{ route('peminjaman.index') }}"
                   class="btn btn-light me-2">
                    Batal
                </a>
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bx bx-save me-1"></i> Simpan Penggunaan
                </button>
            </div>

        </form>

    </div>
</div>

@endsection
