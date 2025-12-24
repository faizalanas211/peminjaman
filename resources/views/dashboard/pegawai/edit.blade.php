@extends('layouts.admin')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('pegawai.index') }}">Data Pegawai</a></li>
    <li class="breadcrumb-item active text-primary fw-semibold">Edit Pegawai</li>
@endsection
@section('content')
    <div class="row">
        <!-- Basic Layout -->
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Edit Data Pegawai</h5>
                    <a href="{{ route('pegawai.index', ['page' => request('page')]) }}" class="btn btn-secondary btn-sm">
                        <i class="bx bx-arrow-back me-1"></i> Kembali
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('pegawai.update', ['pegawai' => $pegawai->id, 'page' => request('page')]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <input type="hidden" name="page" value="{{ request('page') }}">

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Nama Pegawai</label>
                            <div class="col-sm-10">
                                <input type="text"
                                    class="form-control @error('nama')
                                    is-invalid
                                @enderror"
                                    id="basic-default-name" name="nama" autocomplete="off"
                                    value="{{ $pegawai->nama }}" />
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
                                    value="{{ $pegawai->nip }}" />
                                @error('nip')
                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">Jenis Kelamin</label>
                        <div class="col-sm-10">
                            <select name="jenis_kelamin" 
                                    class="form-select @error('jenis_kelamin') is-invalid @enderror">
                                <option value="">-- Pilih Jenis Kelamin --</option>
                                <option value="Laki-laki" {{ $pegawai->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>
                                    Laki-laki
                                </option>
                                <option value="Perempuan" {{ $pegawai->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>
                                    Perempuan
                                </option>
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
                                    value="{{ $pegawai->tempat_lahir }}" />
                                @error('tempat_lahir')
                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Tanggal Lahir</label>
                            <div class="col-sm-10">
                                <input type="date"
                                    class="form-control @error('tanggal_lahir')
                                    is-invalid
                                @enderror"
                                    id="basic-default-name" name="tanggal_lahir" autocomplete="off"
                                    value="{{ $pegawai->tanggal_lahir }}" />
                                @error('tanggal_lahir')
                                    <div id="validationServer03Feedback" class="invalid-feedback">
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
                                    value="{{ $pegawai->jabatan }}" />
                                @error('jabatan')
                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Pangkat-Golongan</label>
                            <div class="col-sm-10">
                                <input type="text"
                                    class="form-control @error('pangkat_golongan')
                                    is-invalid
                                @enderror"
                                    id="basic-default-name" name="pangkat_golongan" autocomplete="off"
                                    value="{{ $pegawai->pangkat_golongan }}" />
                                @error('pangkat_golongan')
                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Foto</label>
                            <div class="col-sm-10">

                                {{-- Tampilkan foto lama jika ada --}}
                                @if ($pegawai->foto)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $pegawai->foto) }}"
                                            alt="Foto Pegawai"
                                            class="img-thumbnail"
                                            style="max-width: 150px;">
                                    </div>
                                @endif

                                {{-- Upload foto baru --}}
                                <input type="file"
                                    class="form-control @error('foto') is-invalid @enderror"
                                    name="foto">
                                <div class="form-text">
                                    Hanya menerima file bertipe <strong>JPG, JPEG, PNG</strong>.  
                                    Maksimal ukuran file: <strong>10 MB</strong>.
                                </div>

                                @error('foto')
                                    <div class="invalid-feedback">{{ $message }}</div>
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
@endsection
