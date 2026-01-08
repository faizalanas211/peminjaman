@extends('layouts.admin')

@section('breadcrumb')
<li class="breadcrumb-item active text-primary fw-semibold">
    Data Barang
</li>
@endsection

@section('content')

<div class="card card-flush shadow-sm rounded-4">

    {{-- ================= HEADER ================= --}}
    <div class="card-header border-0 pt-6 pb-4 d-flex justify-content-between align-items-center">
        <div>
            <h3 class="fw-bold mb-1">Data Barang</h3>
            <p class="text-muted mb-0 fs-7">Daftar seluruh barang inventaris</p>
        </div>
        <a href="{{ route('barang.create') }}"
           class="btn btn-primary px-4 rounded-pill">
            <i class="bx bx-plus me-1"></i> Tambah Data
        </a>
    </div>

    <div class="card-body pt-0">

        {{-- ================= ALERT ================= --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- ================= TABLE ================= --}}
        <div class="table-responsive">
            <table class="table table-borderless align-middle table-hover">
                <thead class="border-bottom">
                    <tr class="text-uppercase text-muted fs-7">
                        <th width="5%">#</th>
                        <th>Nama Barang</th>
                        <th>Type</th>
                        <th>Kode Barang</th>
                        <th>Kondisi</th>
                        <th width="12%" class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="border-top">
                    @forelse ($barangs as $barang)
                        <tr>
                            <td>{{ $barangs->firstItem() + $loop->index }}</td>

                            <td class="fw-semibold">{{ $barang->nama_barang }}</td>
                            <td>{{ $barang->type ?? '-' }}</td>
                            <td>{{ $barang->kode_barang }}</td>
                            <td>{{ $barang->kondisi }}</td>

                            {{-- ===== AKSI ===== --}}
                            <td class="text-center">
                                <div class="d-inline-flex align-items-center gap-1">

                                    {{-- EDIT --}}
                                    <a href="{{ route('barang.edit', $barang->id) }}"
                                       class="btn btn-sm btn-light-primary rounded-pill px-0"
                                       title="Edit Barang">
                                        <i class="bx bx-edit"></i>
                                    </a>

                                    {{-- DELETE --}}
                                    <form action="{{ route('barang.destroy', $barang->id) }}"
                                          method="POST"
                                          class="m-0 p-0"
                                          onsubmit="return confirm('Yakin ingin menghapus barang ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-sm btn-light-danger rounded-pill px-3"
                                                title="Hapus Barang">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                Belum ada data barang
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ================= FOOTER + PAGINATION ================= --}}
        <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap gap-2">
            <div class="text-muted fs-7">
                Menampilkan {{ $barangs->count() }} dari {{ $barangs->total() }} data barang
            </div>

            <div>
                @if ($barangs->hasPages())
                <nav>
                    <ul class="pagination mb-0">

                        {{-- Previous --}}
                        @if ($barangs->onFirstPage())
                            <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $barangs->previousPageUrl() }}">&laquo;</a>
                            </li>
                        @endif

                        {{-- Page ±1 --}}
                        @foreach ($barangs->getUrlRange(
                            max($barangs->currentPage()-1,1),
                            min($barangs->currentPage()+1, $barangs->lastPage())
                        ) as $page => $url)
                            @if ($page == $barangs->currentPage())
                                <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                            @else
                                <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @endforeach

                        {{-- Next --}}
                        @if ($barangs->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $barangs->nextPageUrl() }}">&raquo;</a>
                            </li>
                        @else
                            <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
                        @endif

                    </ul>
                </nav>
                @endif
            </div>
        </div>

    </div>
</div>

@endsection
