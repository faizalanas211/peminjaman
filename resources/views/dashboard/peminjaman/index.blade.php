@extends('layouts.admin')

@section('breadcrumb')
<li class="breadcrumb-item active text-primary fw-semibold">
    Daftar Peminjam Barang
</li>
@endsection

@section('content')

<div class="card card-flush shadow-sm rounded-4">

    {{-- HEADER --}}
    <div class="card-header border-0 pt-6 pb-4 d-flex justify-content-between align-items-center">
        <div>
            <h3 class="fw-bold mb-1">Peminjaman Bulanan</h3>
            <p class="text-muted mb-0 fs-7">Monitoring peminjaman per bulan</p>
        </div>
        <a href="{{ route('peminjaman.create') }}" class="btn btn-primary px-4">
            <i class="bx bx-plus me-1"></i> Peminjaman Baru
        </a>
    </div>

    <div class="card-body pt-0">

        {{-- ALERT --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3">
                {{ session('success') }}
                <button class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- FILTER SEDERHANA --}}
        <form method="GET" action="{{ route('peminjaman.index') }}" class="mb-3 d-flex gap-2">
            <select name="bulan" class="form-select w-auto">
                @for($i=1;$i<=12;$i++)
                    <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                    </option>
                @endfor
            </select>

            <select name="tahun" class="form-select w-auto">
                @for($y=date('Y');$y>=2020;$y--)
                    <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>
                        {{ $y }}
                    </option>
                @endfor
            </select>

            <button class="btn btn-outline-primary">
                <i class="bx bx-filter-alt me-1"></i> Tampilkan
            </button>
        </form>

        {{-- SUMMARY RINGKAS --}}
        <div class="d-flex gap-3 mb-4">
            <div class="summary-card flex-fill text-center">
                <span>Total Peminjaman</span>
                <h3>{{ $total }}</h3>
            </div>
            <div class="summary-card flex-fill text-center">
                <span>Sedang Dipinjam</span>
                <h3>{{ $dipinjam }}</h3>
            </div>
            <div class="summary-card flex-fill text-center">
                <span>Sudah Dikembalikan</span>
                <h3>{{ $dikembalikan }}</h3>
            </div>
        </div>

        {{-- TABEL --}}
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th>Nama Peminjam</th>
                        <th>Barang</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Status</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($peminjamans as $i => $p)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>
                            {{ $p->nama_peminjam }} <br>
                            <small class="text-muted">{{ $p->kelas }}</small>
                        </td>
                        <td>{{ $p->barang->nama_barang }}</td>
                        <td>{{ \Carbon\Carbon::parse($p->tanggal_pinjam)->translatedFormat('d M Y') }}</td>
                        <td>{{ $p->tanggal_kembali ? \Carbon\Carbon::parse($p->tanggal_kembali)->translatedFormat('d M Y') : '-' }}</td>
                        <td>
                            <span class="badge {{ $p->status === 'dipinjam' ? 'bg-warning text-dark' : 'bg-success' }}">
                                {{ ucfirst($p->status) }}
                            </span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('peminjaman.show', $p->id) }}" class="btn btn-sm btn-outline-primary mb-1">Detail</a>
                            @if($p->status === 'dipinjam')
                                <form action="{{ route('peminjaman.kembalikan', $p->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button class="btn btn-sm btn-success" onclick="return confirm('Yakin barang sudah dikembalikan?')">
                                        Kembalikan
                                    </button>
                                </form>
                            @else
                                <span class="badge bg-secondary">Selesai</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">Tidak ada data peminjaman</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

{{-- STYLE --}}
<style>
.summary-card{
    background:#fff;
    border-radius:18px;
    padding:15px 10px;
    box-shadow:0 4px 12px rgba(0,0,0,.05);
}
.summary-card span{
    font-size:13px;
    color:#8a94a6;
}
.summary-card h3{
    font-size:24px;
    font-weight:700;
    margin-top:4px;
    color:#1f2937;
}
</style>

@endsection
