@extends('layouts.admin')

@section('breadcrumb')
    <li class="breadcrumb-item active text-primary fw-semibold">Data Kehadiran</li>
@endsection

@section('content')
<div class="card card-flush shadow-sm">
    <!-- Card Header -->
    <div class="card-header border-0 pt-6">
        <div class="card-title">
            <h3 class="fw-bold m-0">Data Kehadiran</h3>
            @if(request('tanggal'))
                <small class="text-muted fs-7">Tanggal: {{ \Carbon\Carbon::parse(request('tanggal'))->translatedFormat('d F Y') }}</small>
            @else
                <small class="text-muted fs-7">Hari ini: {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</small>
            @endif
        </div>
        <div class="card-toolbar">
            <a href="{{ route('kehadiran.create') }}" class="btn btn-primary">
                <i class="bx bx-plus me-2"></i>Tambah Data
            </a>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="card-body border-bottom py-4">
        <form method="GET" action="{{ route('kehadiran.index') }}" id="filterForm">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Filter Tanggal</label>
                    <div class="input-group">
                        <input type="date" name="tanggal" class="form-control" 
                               value="{{ request('tanggal') ?? date('Y-m-d') }}"
                               max="{{ date('Y-m-d') }}">
                        <button type="submit" class="btn btn-primary">
                            <i class="bx bx-filter-alt me-1"></i>Filter
                        </button>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="d-flex gap-2 justify-content-end">
                        @if(request('tanggal'))
                        <a href="{{ route('kehadiran.index') }}" class="btn btn-light">
                            <i class="bx bx-refresh me-1"></i>Reset
                        </a>
                        @endif
                        
                        <!-- Quick Date Filters -->
                        <div class="btn-group">
                            <button type="button" class="btn btn-outline-secondary" onclick="setToday()">
                                Hari Ini
                            </button>
                            <button type="button" class="btn btn-outline-secondary" onclick="setYesterday()">
                                Kemarin
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Table Section -->
    <div class="card-body pt-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle table-row-dashed fs-6 gy-3">
                <thead class="bg-light-primary">
                    <tr class="fw-bold fs-7 text-uppercase text-gray-700 border-bottom text-center">
                        <th class="ps-4">NO</th>
                        <th>NAMA PEGAWAI</th>
                        <th>STATUS</th>
                        <th>JAM MASUK</th>
                        <th class="text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody class="fw-semibold text-gray-600">
                    @forelse ($kehadiranHariIni as $index => $item)
                    <tr>
                        <!-- Nomor urut sesuai halaman -->
                        <td>{{ $kehadiranHariIni->firstItem() + $loop->index }}</td>

                        <!-- Nama Pegawai -->
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="d-flex flex-column">
                                    <span class="fw-bold text-dark">{{ $item->pegawai->nama }}</span>
                                    <span class="text-muted fs-8">{{ $item->pegawai->nip ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </td>

                        <!-- Status -->
                        @php
                            $colors = [
                                'dinas_luar' => '#A5D8FF',
                                'dinas_dalam' => '#e8b4fa',
                                'izin'       => '#FFCF9F',
                                'sakit'      => '#FFD6E0',
                                'cuti'       => '#f0f7b1',
                                'alpha'      => '#F9B5AC',
                            ];

                            $badgeColor = $colors[$item->status] ?? '#DCDCDC';
                            $statusText = ucwords(str_replace('_', ' ', $item->status));

                            if ($item->status === 'hadir' && $item->jam_masuk) {
                                $jamMasuk = \Carbon\Carbon::parse($item->jam_masuk);
                                $batas = \Carbon\Carbon::createFromTimeString('07:30');

                                if ($jamMasuk->greaterThan($batas)) {
                                    // Terlambat
                                    $badgeColor = '#F8AFA6';
                                    $statusText = 'Hadir (Terlambat)';
                                } else {
                                    // Tepat waktu
                                    $badgeColor = '#C8F7C5';
                                    $statusText = 'Hadir (Tepat Waktu)';
                                }
                            }
                        @endphp

                        <td class="text-center">
                            <span class="badge"
                                style="
                                    background-color: {{ $badgeColor }};
                                    color: #333;
                                    font-weight: 600;
                                    border-radius: 8px;
                                    padding: 6px 10px;
                                ">
                                {{ $statusText }}
                            </span>
                        </td>
                        
                         <!-- Jam Masuk -->
                        <td class="text-center">{{ $item->jam_masuk ? $item->jam_masuk : '-' }}</td>

                        <!-- Actions -->
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <!-- Edit -->
                                <a href="{{ route('kehadiran.edit', [$item->id, 'page' => request()->input('page', 1)]) }}" 
                                   class="btn btn-icon btn-light-primary btn-sm"
                                   title="Edit"
                                   data-bs-toggle="tooltip">
                                    <i class="bx bx-edit"></i>
                                </a>

                               <!-- Delete Button -->
                                <button type="button" 
                                        class="btn btn-icon btn-light-danger btn-sm"
                                        title="Hapus"
                                        data-bs-toggle="tooltip"
                                        onclick="confirmDelete({{ $item->id }})">
                                    <i class="bx bx-trash"></i>
                                </button>

                                <!-- Hidden Delete Form -->
                                <form id="delete-{{ $item->id }}"
                                    action="{{ route('kehadiran.destroy', $item->id) }}"
                                    method="POST"
                                    style="display:none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-10">
                            <div class="d-flex flex-column align-items-center">
                                <span class="text-muted fw-semibold fs-6">
                                    Tidak ada data kehadiran 
                                    @if(request('tanggal'))
                                        untuk tanggal {{ \Carbon\Carbon::parse(request('tanggal'))->translatedFormat('d F Y') }}
                                    @else
                                        hari ini
                                    @endif
                                </span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <!-- Pagination Improved -->
        @if($kehadiranHariIni->hasPages())
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-4 pt-3 border-top">
            <div class="mb-3 mb-md-0 text-muted">
                <span class="fw-medium">Menampilkan</span>
                <span class="fw-medium">{{ $kehadiranHariIni->firstItem() ?? 0 }}</span>
                <span class="fw-medium">sampai</span>
                <span class="fw-medium">{{ $kehadiranHariIni->lastItem() ?? 0 }}</span>
                <span class="fw-medium">dari</span>
                <span class="fw-medium">{{ $kehadiranHariIni->total() }}</span>
                <span class="fw-medium">data pegawai</span>
            </div>
            
            <nav aria-label="Page navigation">
                <ul class="pagination mb-0">
                    <!-- First Page Link -->
                    @if(!$kehadiranHariIni->onFirstPage())
                    <li class="page-item">
                        <a class="page-link" href="{{ $kehadiranHariIni->url(1) }}" aria-label="First">
                            <i class="bx bx-chevrons-left"></i>
                        </a>
                    </li>
                    @else
                    <li class="page-item disabled">
                        <span class="page-link"><i class="bx bx-chevrons-left"></i></span>
                    </li>
                    @endif

                    <!-- Previous Page Link -->
                    @if($kehadiranHariIni->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link"><i class="bx bx-chevron-left"></i></span>
                    </li>
                    @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $kehadiranHariIni->previousPageUrl() }}" aria-label="Previous">
                            <i class="bx bx-chevron-left"></i>
                        </a>
                    </li>
                    @endif

                    <!-- Page Numbers -->
                    @foreach($kehadiranHariIni->getUrlRange(max(1, $kehadiranHariIni->currentPage() - 2), min($kehadiranHariIni->lastPage(), $kehadiranHariIni->currentPage() + 2)) as $page => $url)
                    <li class="page-item {{ $page == $kehadiranHariIni->currentPage() ? 'active' : '' }}">
                        @if($page == $kehadiranHariIni->currentPage())
                        <span class="page-link">{{ $page }}</span>
                        @else
                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        @endif
                    </li>
                    @endforeach

                    <!-- Next Page Link -->
                    @if($kehadiranHariIni->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $kehadiranHariIni->nextPageUrl() }}" aria-label="Next">
                            <i class="bx bx-chevron-right"></i>
                        </a>
                    </li>
                    @else
                    <li class="page-item disabled">
                        <span class="page-link"><i class="bx bx-chevron-right"></i></span>
                    </li>
                    @endif

                    <!-- Last Page Link -->
                    @if($kehadiranHariIni->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $kehadiranHariIni->url($kehadiranHariIni->lastPage()) }}" aria-label="Last">
                            <i class="bx bx-chevrons-right"></i>
                        </a>
                    </li>
                    @else
                    <li class="page-item disabled">
                        <span class="page-link"><i class="bx bx-chevrons-right"></i></span>
                    </li>
                    @endif
                </ul>
            </nav>
        </div>
        @elseif($kehadiranHariIni->total() > 0)
        <div class="mt-4 pt-3 border-top">
            <div class="text-center text-muted">
                Menampilkan semua {{ $kehadiranHariIni->total() }} data pegawai
            </div>
        </div>
        @endif
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Function untuk quick date filter
function setToday() {
    document.querySelector('input[name="tanggal"]').value = '{{ date("Y-m-d") }}';
    document.getElementById('filterForm').submit();
}

function setYesterday() {
    const yesterday = new Date();
    yesterday.setDate(yesterday.getDate() - 1);
    const formatted = yesterday.toISOString().split('T')[0];
    document.querySelector('input[name="tanggal"]').value = formatted;
    document.getElementById('filterForm').submit();
}

// Confirm Delete dengan sweetalert
function confirmDelete(id) {
    Swal.fire({
        title: 'Hapus data kehadiran?',
        html: `
            <span style="font-size:14px; color:#555;">
                Data yang dihapus <strong>tidak dapat dipulihkan.</strong>
            </span>
        `,
        icon: 'warning',
        iconColor: '#f0ad4e',

        showCancelButton: true,
        reverseButtons: true,

        // Tombol
        confirmButtonText: 'Hapus',
        cancelButtonText: 'Batal',

        // Warna tombol
        confirmButtonColor: '#e55353',
        cancelButtonColor: '#6c757d',

        // Styling popup
        customClass: {
            popup: 'rounded-4 shadow-lg',
            confirmButton: 'px-4 py-2',
            cancelButton: 'px-4 py-2'
        },

        // Animation
        showClass: {
            popup: 'animate__animated animate__fadeInDown'
        },
        hideClass: {
            popup: 'animate__animated animate__fadeOutUp'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-' + id).submit();
        }
    });
}

// Initialize tooltips
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>

<style>
.badge {
    border-radius: 8px;
    font-weight: 600;
    min-width: 120px;
    justify-content: center;
}
.table-row-dashed td {
    border-bottom-style: dashed !important;
}
.symbol-circle {
    border-radius: 50%;
}
</style>
@endsection


