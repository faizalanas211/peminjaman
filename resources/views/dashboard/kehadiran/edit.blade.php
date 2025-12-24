@extends('layouts.admin')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('kehadiran.index') }}">Data Kehadiran</a></li>
    <li class="breadcrumb-item active text-primary fw-semibold">Edit Kehadiran</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Edit Data Kehadiran</h5>
                    <a href="{{ route('kehadiran.index', ['page' => request('page')]) }}" class="btn btn-secondary btn-sm">
                        <i class="bx bx-arrow-back me-1"></i> Kembali
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('kehadiran.update', [$kehadiran->id, 'page' => request('page')]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <input type="hidden" name="page" value="{{ request('page') }}">
                        
                        <!-- Nama Pegawai (Readonly) -->
                        <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">Nama Pegawai</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" value="{{ $kehadiran->pegawai->nama }}" readonly disabled>
                        </div>
                    </div>

                        <!-- Status -->
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Status</label>
                            <div class="col-sm-10">
                                <select name="status" 
                                        id="statusSelect"
                                        class="form-select @error('status') is-invalid @enderror">
                                    <option value="">-- Pilih Status --</option>
                                    <option value="hadir" {{ old('status', $kehadiran->status) == 'hadir' ? 'selected' : '' }}>
                                        Hadir
                                    </option>
                                    <option value="dinas_luar" {{ old('status', $kehadiran->status) == 'dinas_luar' ? 'selected' : '' }}>
                                        Dinas Luar
                                    </option>
                                    <option value="dinas_dalam" {{ old('status', $kehadiran->status) == 'dinas_dalam' ? 'selected' : '' }}>
                                        Dinas Dalam
                                    </option>
                                    <option value="cuti" {{ old('status', $kehadiran->status) == 'cuti' ? 'selected' : '' }}>
                                        Cuti
                                    </option>
                                    <option value="sakit" {{ old('status', $kehadiran->status) == 'sakit' ? 'selected' : '' }}>
                                        Sakit
                                    </option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Jam Masuk (Conditional) -->
                        <div class="row mb-3" id="jamMasukContainer">
                            <label class="col-sm-2 col-form-label">Jam Masuk</label>
                            <div class="col-sm-10">
                                @if($kehadiran->status == 'hadir' && $kehadiran->jam_masuk)
                                    <!-- Tampilkan jika status awal adalah hadir dan sudah ada jam masuk -->
                                    <input type="time" 
                                           name="jam_masuk" 
                                           class="form-control @error('jam_masuk') is-invalid @enderror"
                                           value="{{ old('jam_masuk', $kehadiran->jam_masuk ? \Carbon\Carbon::parse($kehadiran->jam_masuk)->format('H:i') : '') }}"
                                           id="jamMasukInput">
                                @else
                                    <!-- Tampilkan kosong jika status bukan hadir atau tidak ada jam masuk -->
                                    <input type="time" 
                                           name="jam_masuk" 
                                           class="form-control @error('jam_masuk') is-invalid @enderror"
                                           value="{{ old('jam_masuk') }}"
                                           id="jamMasukInput"
                                           style="display: none;">
                                    <div id="jamMasukInfo" class="text-muted" style="display: none;">
                                        <small>
                                            <i class="bx bx-info-circle me-1"></i>
                                            Isi jam masuk untuk status hadir
                                        </small>
                                    </div>
                                @endif
                                @error('jam_masuk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Keterangan -->
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="keterangan">Keterangan</label>
                            <div class="col-sm-10">
                                <textarea
                                    class="form-control @error('keterangan') is-invalid @enderror"
                                    id="keterangan"
                                    name="keterangan"
                                    rows="3"
                                    placeholder="Masukkan keterangan (opsional)"
                                >{{ old('keterangan', $kehadiran->keterangan) }}</textarea>
                                @error('keterangan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Tanggal -->
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="tanggal">Tanggal</label>
                            <div class="col-sm-10">
                                <input type="date" 
                                       name="tanggal" 
                                       class="form-control @error('tanggal') is-invalid @enderror"
                                       value="{{ old('tanggal', $kehadiran->tanggal) }}"
                                       max="{{ date('Y-m-d') }}">
                                @error('tanggal')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                          <div class="row justify-content-end">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bx bx-save me-1"></i> Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


<script>
document.addEventListener('DOMContentLoaded', function() {
    const statusSelect = document.getElementById('statusSelect');
    const jamMasukInput = document.getElementById('jamMasukInput');
    const jamMasukInfo = document.getElementById('jamMasukInfo');
    
    // Fungsi untuk menampilkan/menyembunyikan jam masuk
    function toggleJamMasuk() {
        const isHadir = statusSelect.value === 'hadir';
        const hasExistingJam = "{{ $kehadiran->jam_masuk ? 'true' : 'false' }}" === 'true';
        
        if (jamMasukInput) {
            if (isHadir) {
                // Jika status adalah hadir
                if (hasExistingJam) {
                    // Jika sudah ada jam masuk sebelumnya, tampilkan input
                    jamMasukInput.style.display = 'block';
                    jamMasukInput.required = true;
                    if (jamMasukInfo) jamMasukInfo.style.display = 'none';
                } else {
                    // Jika tidak ada jam masuk sebelumnya, tampilkan input baru
                    jamMasukInput.style.display = 'block';
                    jamMasukInput.required = true;
                    jamMasukInput.value = ''; // Kosongkan nilai
                    if (jamMasukInfo) {
                        jamMasukInfo.style.display = 'block';
                        jamMasukInfo.innerHTML = `
                            <small>
                                <i class="bx bx-info-circle me-1"></i>
                                Status diubah menjadi "Hadir", silakan isi jam masuk
                            </small>
                        `;
                    }
                }
            } else {
                // Jika status bukan hadir
                jamMasukInput.style.display = 'none';
                jamMasukInput.required = false;
                jamMasukInput.value = ''; // Kosongkan nilai
                if (jamMasukInfo) {
                    jamMasukInfo.style.display = 'block';
                    jamMasukInfo.innerHTML = `
                        <small>
                            <i class="bx bx-info-circle me-1"></i>
                            Jam masuk hanya diperlukan untuk status "Hadir"
                        </small>
                    `;
                }
            }
        }
    }
    
    // Inisialisasi saat halaman dimuat
    toggleJamMasuk();
    
    // Event listener untuk perubahan status
    statusSelect.addEventListener('change', toggleJamMasuk);
    
    // Validasi sebelum submit
    document.querySelector('form').addEventListener('submit', function(e) {
        const isHadir = statusSelect.value === 'hadir';
        const jamMasukValue = jamMasukInput ? jamMasukInput.value : '';
        
        if (isHadir && (!jamMasukValue || jamMasukValue.trim() === '')) {
            e.preventDefault();
            Swal.fire({
                title: 'Perhatian',
                text: 'Jam masuk wajib diisi untuk status "Hadir"',
                icon: 'warning',
                confirmButtonText: 'OK'
            });
        }
    });
});
</script>

<style>
.bg-light {
    background-color: #f8f9fa !important;
    cursor: not-allowed;
}
</style>
