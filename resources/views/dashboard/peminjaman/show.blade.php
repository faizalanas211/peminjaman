@extends('layouts.admin')

@section('breadcrumb')
<li class="breadcrumb-item">
    <a href="{{ route('peminjaman.index') }}" class="text-decoration-none">Peminjaman</a>
</li>
<li class="breadcrumb-item active text-primary fw-semibold">
    Detail Peminjaman
</li>
@endsection

@section('content')

<div class="card card-flush shadow-sm rounded-4">

    {{-- HEADER --}}
    <div class="card-header border-0 pt-6 pb-4 d-flex justify-content-between align-items-center">
        <div>
            <h3 class="fw-bold mb-1">Detail Peminjaman</h3>
            <p class="text-muted mb-0 fs-7">Informasi lengkap peminjaman barang</p>
        </div>
        <a href="{{ route('peminjaman.index') }}" class="btn btn-light">
            <i class="bx bx-arrow-back me-1"></i> Kembali
        </a>
    </div>

    <div class="card-body pt-0">

        <div class="row g-4">

            {{-- DATA PEMINJAM --}}
            <div class="col-md-6">
                <div class="info-card">
                    <h6 class="section-title">Data Peminjam</h6>

                    <div class="info-row">
                        <span>Nama Peminjam</span>
                        <strong>{{ $peminjaman->nama_peminjam }}</strong>
                    </div>

                    <div class="info-row">
                        <span>Bagian</span>
                        <strong>{{ $peminjaman->kelas }}</strong>
                    </div>

                    <div class="info-row">
                        <span>Status</span>
                        <span class="badge {{ $peminjaman->status == 'dipinjam' ? 'bg-warning text-dark' : 'bg-success' }}">
                            {{ ucfirst($peminjaman->status) }}
                        </span>
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
                        <span>Type</span>
                        <strong>{{ $peminjaman->barang->type }}</strong>
                    </div>

                    <div class="info-row">
                        <span>Kode Barang</span>
                        <strong>{{ $peminjaman->barang->kode_barang }}</strong>
                    </div>

                    <div class="info-row">
                        <span>Kondisi</span>
                        <strong>{{ $peminjaman->barang->kondisi }}</strong>
                    </div>
                </div>
            </div>

            {{-- WAKTU PEMINJAMAN --}}
            <div class="col-md-12">
                <div class="info-card">
                    <h6 class="section-title">Waktu Peminjaman</h6>

                    <div class="row">
                        <div class="col-md-4 info-row">
                            <span>Tanggal Pinjam</span>
                            <strong>
                                {{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->translatedFormat('d F Y') }}
                            </strong>
                        </div>

                        <div class="col-md-4 info-row">
                            <span>Tanggal Kembali</span>
                            <strong>
                                {{ $peminjaman->tanggal_kembali
                                    ? \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->translatedFormat('d F Y')
                                    : '-' }}
                            </strong>
                        </div>

                        <div class="col-md-4 info-row">
                            <span>Keterangan</span>
                            <strong>{{ $peminjaman->keterangan ?? '-' }}</strong>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- AKSI --}}
        <div class="d-flex justify-content-end mt-4 gap-2">
            @if($peminjaman->status === 'dipinjam')
                <form action="{{ route('peminjaman.kembalikan', $peminjaman->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <button class="btn btn-success"
                        onclick="return confirm('Yakin barang sudah dikembalikan?')">
                        <i class="bx bx-check me-1"></i> Tandai Dikembalikan
                    </button>
                </form>
            @endif
            <a href="{{ route('peminjaman.index') }}" class="btn btn-outline-secondary">
                Tutup
            </a>
        </div>

    </div>
</div>

{{-- STYLE --}}
<style>
.info-card{
    background:#fff;
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
