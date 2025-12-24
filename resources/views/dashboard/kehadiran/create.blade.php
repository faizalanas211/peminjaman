@extends('layouts.admin')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('kehadiran.index') }}">Data Kehadiran</a></li>
    <li class="breadcrumb-item active text-primary fw-semibold">Tambah Kehadiran</li>
@endsection
@section('content')
    <div class="row">
        <!-- Basic Layout -->
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Tambah Data Kehadiran</h5>
                    <button class="btn btn-primary mx-2" data-bs-toggle="modal" data-bs-target="#importModal">
                        Impor Excel
                    </button>
                </div>
                <div class="card-body">
                    <form action="{{ route('kehadiran.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="tanggal">Tanggal</label>
                            <div class="col-sm-10">
                                <input type="date"
                                    class="form-control @error('tanggal') is-invalid @enderror"
                                    id="tanggal"
                                    name="tanggal"
                                    value="{{ old('tanggal', now()->toDateString()) }}" />

                                @error('tanggal')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="nama">Nama Pegawai</label>
                            <div class="col-sm-10">
                                <select name="pegawai_id" class="form-control" required>
                                    <option value="">-- Pilih Pegawai --</option>
                                    @foreach ($pegawaiBelumHadir as $p)
                                        <option value="{{ $p->id }}">{{ $p->nama }}</option>
                                    @endforeach
                                </select>

                                @error('nama')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Status</label>
                            <div class="col-sm-10">
                                <select name="status" id="status" class="form-select">
                                    <option value="" disabled selected>-- Pilih Status --</option>
                                    <option value="hadir" {{ old('status') == 'hadir' ? 'selected' : '' }}>Hadir</option>
                                    <option value="dinas_luar" {{ old('status') == 'dinas_luar' ? 'selected' : '' }}>Dinas Luar</option>
                                    <option value="dinas_dalam" {{ old('status') == 'dinas_dalam' ? 'selected' : '' }}>Dinas Dalam</option>
                                    <option value="cuti" {{ old('status') == 'cuti' ? 'selected' : '' }}>Cuti</option>
                                    <option value="sakit" {{ old('status') == 'sakit' ? 'selected' : '' }}>Sakit</option>
                                </select>

                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3" id="jamMasukDiv" style="display: none;">
                            <label class="col-sm-2 col-form-label">Jam Masuk</label>
                            <div class="col-sm-10">
                                <input type="time" name="jam_masuk" class="form-control">
                                @error('jam_masuk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Keterangan</label>
                            <div class="col-sm-10">
                                <textarea
                                    class="form-control @error('keterangan') is-invalid @enderror"
                                    id="keterangan"
                                    name="keterangan"
                                    rows="3"
                                >{{ old('keterangan') }}</textarea>

                                @error('keterangan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Impor Excel -->
    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4">

                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">Impor Data Kehadiran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{ route('kehadiran.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="modal-body">

                        <label class="form-label fw-semibold">Pilih File Excel</label>
                        <input type="file" name="file" accept=".xlsx,.xls"
                            class="form-control @error('file') is-invalid @enderror">

                        <div class="form-text mt-1">
                            Hanya menerima file Excel (.xlsx/.xls). Maksimal 2 MB.
                        </div>

                        <!-- Link Download Template -->
                        <div class="mt-2">
                            <a href="{{ asset('template/template_data_kehadiran.xlsx') }}" 
                            class="text-primary fw-semibold" 
                            download>
                                📥 Download Template Excel
                            </a>
                        </div>

                        @error('file')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Impor</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <script>
    const statusSelect = document.getElementById('status');
    const jamMasukDiv = document.getElementById('jamMasukDiv');

    function toggleJamMasuk() {
        if (statusSelect.value === 'hadir') {
            jamMasukDiv.style.display = 'flex';
        } else {
            jamMasukDiv.style.display = 'none';
        }
    }

    // Jalankan saat halaman load (biar old() tetap kepake)
    toggleJamMasuk();

    // Jalankan setiap kali status berubah
    statusSelect.addEventListener('change', toggleJamMasuk);
</script>

@endsection
