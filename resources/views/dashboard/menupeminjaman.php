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
            <h3 class="fw-bold mb-1">Daftar Peminjam Barang</h3>
            <p class="text-muted mb-0 fs-7">Monitoring aktivitas peminjaman</p>
        </div>
        <button class="btn btn-primary px-4">
            <i class="bx bx-plus me-1"></i> Peminjaman Baru
        </button>
    </div>

    <div class="card-body pt-0">

        {{-- SUMMARY --}}
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="summary-card">
                    <span>Total Peminjaman</span>
                    <h3>12</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="summary-card">
                    <span>Sedang Dipinjam</span>
                    <h3>8</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="summary-card">
                    <span>Sudah Dikembalikan</span>
                    <h3>4</h3>
                </div>
            </div>
        </div>

        {{-- TABEL PEMINJAM --}}
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
                        <th width="10%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>
                            Ahmad Fauzi <br>
                            <small class="text-muted">XI RPL 1</small>
                        </td>
                        <td>Laptop</td>
                        <td>10 Sep 2025</td>
                        <td>15 Sep 2025</td>
                        <td>
                            <span class="badge bg-warning text-dark">Dipinjam</span>
                        </td>
                        <td>
                            <a href="#" class="btn btn-sm btn-outline-primary">Detail</a>
                        </td>
                    </tr>

                    <tr>
                        <td>2</td>
                        <td>
                            Siti Aisyah <br>
                            <small class="text-muted">X AKL 2</small>
                        </td>
                        <td>Proyektor</td>
                        <td>08 Sep 2025</td>
                        <td>-</td>
                        <td>
                            <span class="badge bg-warning text-dark">Dipinjam</span>
                        </td>
                        <td>
                            <a href="#" class="btn btn-sm btn-outline-primary">Detail</a>
                        </td>
                    </tr>

                    <tr>
                        <td>3</td>
                        <td>
                            Budi Santoso <br>
                            <small class="text-muted">Guru</small>
                        </td>
                        <td>Printer</td>
                        <td>01 Sep 2025</td>
                        <td>05 Sep 2025</td>
                        <td>
                            <span class="badge bg-success">Dikembalikan</span>
                        </td>
                        <td>
                            <a href="#" class="btn btn-sm btn-outline-primary">Detail</a>
                        </td>
                    </tr>
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
    padding:20px;
    box-shadow:0 6px 18px rgba(0,0,0,.06);
}
.summary-card span{
    font-size:13px;
    color:#8a94a6;
}
.summary-card h3{
    font-size:30px;
    font-weight:700;
    margin-top:4px;
    color:#1f2937;
}
</style>

@endsection
