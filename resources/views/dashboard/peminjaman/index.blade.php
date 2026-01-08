@extends('layouts.admin')

@section('breadcrumb')
<li class="breadcrumb-item active text-primary fw-semibold">
    Riwayat Penggunaan Barang
</li>
@endsection

@section('content')

<div class="card card-flush shadow-sm rounded-4">

    {{-- ================= HEADER ================= --}}
    <div class="card-header border-0 pt-6 pb-4 d-flex justify-content-between align-items-center">
        <div>
            <h3 class="fw-bold mb-1">Riwayat Penggunaan Barang</h3>
            <p class="text-muted mb-0 fs-7">
                Catatan penggunaan barang inventaris per bulan
            </p>
        </div>
        <a href="{{ route('peminjaman.create') }}" class="btn btn-primary px-4">
            <i class="bx bx-plus me-1"></i> Tambah Penggunaan
        </a>
    </div>

    <div class="card-body pt-0">

        {{-- ================= ALERT ================= --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3">
                {{ session('success') }}
                <button class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- ================= FILTER ================= --}}
        <form method="GET"
              action="{{ route('peminjaman.index') }}"
              class="mb-4 d-flex gap-2 align-items-center">

            <select name="bulan" class="form-select form-select-sm w-auto">
                @for($i=1;$i<=12;$i++)
                    <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                    </option>
                @endfor
            </select>

            <select name="tahun" class="form-select form-select-sm w-auto">
                @for($y=date('Y');$y>=2020;$y--)
                    <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>
                        {{ $y }}
                    </option>
                @endfor
            </select>

            <button class="btn btn-outline-primary btn-sm">
                <i class="bx bx-filter-alt me-1"></i> Tampilkan
            </button>
        </form>

        {{-- ================= SUMMARY ================= --}}
        <div class="row g-2 mb-4">
            <div class="col-md-4">
                <div class="summary-mini bg-primary-subtle shadow-sm">
                    <i class="bx bx-list-ul text-primary"></i>
                    <div>
                        <small>Total Riwayat Penggunaan</small>
                        <h5>{{ $total }}</h5>
                    </div>
                </div>
            </div>
        </div>

        {{-- ================= TABEL ================= --}}
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="5%" class="text-center align-middle">No</th>
                        <th class="align-middle">Pengguna</th>
                        <th class="align-middle">Barang</th>
                        <th class="align-middle">Tanggal Penggunaan</th>
                        <th width="15%" class="text-center align-middle">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($peminjamans as $p)
                    <tr>
                        <td class="text-center align-middle">
                            {{ ($peminjamans->currentPage() - 1) * $peminjamans->perPage() + $loop->iteration }}
                        </td>

                        <td class="align-middle">
                            {{ $p->nama_peminjam }} <br>
                            <small class="text-muted">{{ $p->kelas }}</small>
                        </td>

                        <td class="align-middle">
                            {{ $p->barang->nama_barang }}
                        </td>

                        <td class="align-middle">
                            {{ \Carbon\Carbon::parse($p->tanggal_pinjam)->translatedFormat('d M Y') }}
                        </td>

                        {{-- ===== AKSI (FIX CENTER) ===== --}}
                        <td class="text-center align-middle">
                            <a href="{{ route('peminjaman.show', $p->id) }}"
                               class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            Tidak ada data penggunaan barang
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{-- ================= PAGINATION ================= --}}
        <div class="d-flex justify-content-end mt-2">
            {{ $peminjamans->links('pagination::bootstrap-5') }}
        </div>

    </div>
</div>

{{-- ================= STYLE ================= --}}
<style>
/* KUNCI POSISI TABEL */
.table th,
.table td{
    vertical-align: middle !important;
}

/* SUMMARY */
.summary-mini{
    display:flex;
    align-items:center;
    gap:12px;
    padding:10px 14px;
    border-radius:12px;
    transition: transform 0.2s;
}
.summary-mini:hover{
    transform: translateY(-2px);
}
.summary-mini i{
    font-size:24px;
}
.summary-mini small{
    font-size:12px;
    color:#6b7280;
}
.summary-mini h5{
    margin:0;
    font-weight:700;
    color:#111827;
}
</style>

@endsection
