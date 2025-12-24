@extends('layouts.admin')
@section('content')
<div class="container py-1">


    <!-- Card -->
        <div class="card p-3">

    <!-- Judul -->
    <div class="card-body text-center">
        <h3>Halaman Pengajuan Cuti</h3>
        <p>Ini adalah halaman baru untuk menu Pengajuan Cuti.</p>
    </div>

    <!-- Show Entries + Search -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <!-- Show Entries -->
        <div>
            <select class="form-select form-select-sm" style="width: 80px;">
                <option>10</option>
                <option>25</option>
                <option>50</option>
            </select>
        </div>

        <!-- Search -->
        <div>
            <input type="text" class="form-control form-control-sm" placeholder="Search..."
                   style="width: 200px;">
        </div>
    </div>


        <!-- Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Cuti ID</th>
                        <th>Pemohon</th>
                        <th>Tgl. Pengajuan</th>
                        <th>Tgl. Mulai</th>
                        <th>Tgl. Selesai</th>
                        <th>Keterangan</th>
                        <th>Status</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data contoh -->
                    <tr>
                        <td>1</td>
                        <td>18052022152652</td>
                        <td><a href="#">Dede Fahrurrozi</a></td>
                        <td>18-05-2022</td>
                        <td>19-05-2022</td>
                        <td>20-05-2022</td>
                        <td>Mau healing dulu pak</td>
                        <td><span class="badge bg-success">Approved</span></td>
                        <td>
                            <button class="btn btn-sm btn-info text-white">
                                <i class="bx bx-show"></i>
                            </button>
                        </td>
                    </tr>

                    <tr>
                        <td>2</td>
                        <td>12052022191811</td>
                        <td><a href="#">Lia Umpam</a></td>
                        <td>12-05-2022</td>
                        <td>12-05-2022</td>
                        <td>18-05-2022</td>
                        <td>Mau ke Jepang</td>
                        <td><span class="badge bg-success">Approved</span></td>
                        <td>
                            <button class="btn btn-sm btn-info text-white">
                                <i class="bx bx-show"></i>
                            </button>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="9" class="text-center text-muted">Belum ada data lainnya</td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>

</div>



@endsection
