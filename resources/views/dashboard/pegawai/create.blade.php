@extends('layouts.admin')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('pegawai.index') }}">Data Pegawai</a></li>
    <li class="breadcrumb-item active text-primary fw-semibold">Tambah Pegawai</li>
@endsection
@section('content')
    <div class="row">
        <!-- Basic Layout -->
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Tambah Data Pegawai</h5>
                    <button class="btn btn-primary mx-2" data-bs-toggle="modal" data-bs-target="#importModal">
                        Impor Excel
                    </button>
                </div>
                <div class="card-body">
                    <form action="{{ route('pegawai.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Nama</label>
                            <div class="col-sm-10">
                                <input type="text"
                                    class="form-control @error('nama')
                                    is-invalid
                                @enderror"
                                    id="basic-default-name" name="nama" autocomplete="off"
                                    value="{{ old('nama') }}" />

                                @error('nama')
                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="status">Status</label>
                            <div class="col-sm-10">
                                <select name="status" class="form-select">
                                    <option value="aktif" {{ old('status', $pegawai->status ?? '') == 'aktif' ? 'selected' : '' }}>
                                        Aktif
                                    </option>
                                    <option value="nonaktif" {{ old('status', $pegawai->status ?? '') == 'nonaktif' ? 'selected' : '' }}>
                                        Nonaktif
                                    </option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">NIP</label>
                            <div class="col-sm-10">
                                <input type="text"
                                    class="form-control @error('nip')
                                    is-invalid
                                @enderror"
                                    id="basic-default-name" name="nip" autocomplete="off"
                                    value="{{ old('nip') }}" />

                                @error('nip')
                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="jenis_kelamin">Jenis Kelamin</label>
                            <div class="col-sm-10">
                                <select name="jenis_kelamin" class="form-select">
                                    <option value="" disabled selected>Pilih Jenis Kelamin</option>
                                    <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>

                                @error('jenis_kelamin')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Tempat Lahir</label>
                            <div class="col-sm-10">
                                <input type="text"
                                    class="form-control @error('tempat_lahir')
                                    is-invalid
                                @enderror"
                                    id="basic-default-name" name="tempat_lahir" autocomplete="off"
                                    value="{{ old('tempat_lahir') }}" />

                                @error('tempat_lahir')
                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="tanggal_lahir">Tanggal Lahir</label>
                            <div class="col-sm-10">
                                <input type="date"
                                    class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                    id="tanggal_lahir"
                                    name="tanggal_lahir"
                                    value="{{ old('tanggal_lahir') }}" />

                                @error('tanggal_lahir')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Jabatan</label>
                            <div class="col-sm-10">
                                <input type="text"
                                    class="form-control @error('jabatan')
                                    is-invalid
                                @enderror"
                                    id="basic-default-name" name="jabatan" autocomplete="off"
                                    value="{{ old('jabatan') }}" />

                                @error('jabatan')
                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Pangkat, Golongan</label>
                            <div class="col-sm-10">
                                <input type="text"
                                    class="form-control @error('pangkat_golongan')
                                    is-invalid
                                @enderror"
                                    id="basic-default-name" name="pangkat_golongan" autocomplete="off"
                                    value="{{ old('pangkat_golongan') }}" />

                                @error('pangkat_golongan')
                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="foto">Foto</label>
                            <div class="col-sm-10">
                                <input type="file"
                                    class="form-control @error('foto') is-invalid @enderror"
                                    id="foto"
                                    name="foto"
                                    accept=".jpg,.jpeg,.png" />

                                <div class="form-text">
                                    Hanya menerima file bertipe <strong>JPG, JPEG, PNG</strong>.  
                                    Maksimal ukuran file: <strong>10 MB</strong>.
                                </div>

                                @error('foto')
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
                    <h5 class="modal-title" id="importModalLabel">Impor Data Pegawai</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{ route('pegawai.import') }}" method="POST" enctype="multipart/form-data">
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
                            <a href="{{ asset('template/template_data_pegawai.xlsx') }}" 
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
@endsection
