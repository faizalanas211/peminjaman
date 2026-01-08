@extends('layouts.admin')

@section('breadcrumb')
<li class="breadcrumb-item">
    <a href="{{ route('peminjaman.index') }}" class="text-decoration-none">
        Riwayat Penggunaan Barang
    </a>
</li>
<li class="breadcrumb-item active text-primary fw-semibold">
    Detail Penggunaan
</li>
@endsection

@section('content')

<div class="card card-flush shadow-sm rounded-4">

    {{-- ================= HEADER ================= --}}
    <div class="card-header border-0 pt-6 pb-4 d-flex justify-content-between align-items-center">
        <div>
            <h3 class="fw-bold mb-1">Detail Penggunaan Barang</h3>
            <p class="text-muted mb-0 fs-7">
                Informasi lengkap penggunaan barang inventaris
            </p>
        </div>
        <a href="{{ route('peminjaman.index') }}" class="btn btn-light">
            <i class="bx bx-arrow-back me-1"></i> Kembali
        </a>
    </div>

    <div class="card-body pt-0">

        <div class="row g-4">

            {{-- DATA PENGGUNA + WAKTU --}}
            <div class="col-md-6">
                <div class="info-card">
                    <h6 class="section-title">Data Pengguna</h6>

                    <div class="info-row">
                        <span>Nama Pengguna</span>
                        <strong>{{ $peminjaman->nama_peminjam }}</strong>
                    </div>

                    <div class="info-row">
                        <span>Bagian / Unit</span>
                        <strong>{{ $peminjaman->kelas }}</strong>
                    </div>

                    <hr class="my-3">

                    <div class="info-row">
                        <span>Tanggal Penggunaan</span>
                        <strong>
                            {{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->translatedFormat('d F Y') }}
                        </strong>
                    </div>

                    <div class="info-row">
                        <span>Keterangan</span>
                        <strong>{{ $peminjaman->keterangan ?? '-' }}</strong>
                    </div>
                </div>
            </div>

            {{-- DATA BARANG --}}
            <div class="col-md-6">
                <div class="info-card">
                    <h6 class="section-title">Data Barang</h6>

                    <div class="info-row">
                        <span>Nama Barang</span>
                        <strong>{{ $peminjaman->barang->nama_barang }}</strong>
                    </div>

                    <div class="info-row">
                        <span>Jenis / Type</span>
                        <strong>{{ $peminjaman->barang->type }}</strong>
                    </div>

                    <div class="info-row">
                        <span>Kode Barang</span>
                        <strong>{{ $peminjaman->barang->kode_barang }}</strong>
                    </div>

                    <div class="info-row">
                        <span>Kondisi Barang</span>
                        <strong>{{ $peminjaman->barang->kondisi }}</strong>
                    </div>
                </div>
            </div>

        </div>

        {{-- AKSI --}}
        <div class="d-flex justify-content-end mt-4">
            <a href="{{ route('peminjaman.index') }}" class="btn btn-outline-secondary">
                Tutup
            </a>
        </div>

    </div>
</div>

{{-- ================= STYLE ================= --}}
<style>
.info-card{
    background:#ffffff;
    border-radius:18px;
    padding:20px;
    box-shadow:0 4px 12px rgba(0,0,0,.05);
    height:100%;
}
.section-title{
    font-weight:700;
    margin-bottom:15px;
    color:#1f2937;
}
.info-row{
    display:flex;
    justify-content:space-between;
    margin-bottom:10px;
    font-size:14px;
}
.info-row span{
    color:#6b7280;
}
</style>

@endsection
