@extends('layouts.admin')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('penilaian.index') }}">Penilaian Pegawai Alih Daya</a></li>
    <li class="breadcrumb-item active text-primary fw-semibold">Tambah Pegawai Alih Daya</li>
@endsection

@section('content')
<div class="row">
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Tambah Pegawai Alih Daya</h5>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#importModal">
                    Impor Excel
                </button>
            </div>
            <div class="card-body">
                <form action="{{ route('penilaian.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Nama Pegawai --}}
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">Nama Pegawai</label>
                        <div class="col-sm-10">
                            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}">
                            @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    {{-- Jabatan --}}
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">Jabatan</label>
                        <div class="col-sm-10">
                            <input type="text" name="jabatan" class="form-control @error('jabatan') is-invalid @enderror" value="{{ old('jabatan') }}">
                            @error('jabatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    {{-- Foto Opsional --}}
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">Foto (Opsional)</label>
                        <div class="col-sm-10">
                            <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror" accept=".jpg,.jpeg,.png">
                            <div class="form-text">File JPG, JPEG, PNG. Maks 10 MB.</div>
                            @error('foto') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    {{-- Tombol Simpan --}}
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

{{-- Modal Impor Excel --}}
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4">
            <div class="modal-header">
                <h5 class="modal-title" id="importModalLabel">Impor Data Pegawai Alih Daya</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('penilaian.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <label class="form-label fw-semibold">Pilih File Excel</label>
                    <input type="file" name="file" accept=".xlsx,.xls" class="form-control @error('file') is-invalid @enderror">
                    <div class="form-text mt-1">Hanya file Excel (.xlsx/.xls). Maks 2 MB.</div>

                    <div class="mt-2">
                        <a href="{{ asset('template/template_data_pegawai.xlsx') }}" class="text-primary fw-semibold" download>
                            📥 Download Template Excel
                        </a>
                    </div>

                    @error('file') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Impor</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
