@extends('layouts.admin')

@section('breadcrumb')
<li class="breadcrumb-item">
    <a href="{{ route('barang.index') }}" class="text-muted text-decoration-none">
        Data Barang
    </a>
</li>
<li class="breadcrumb-item active text-primary fw-semibold">
    Tambah Barang
</li>
@endsection

@section('content')

<div class="row">
    <div class="col-md-12 mx-auto">

        {{-- ================= MANUAL INPUT + IMPORT ================= --}}
        <div class="card card-flush shadow-sm rounded-4">
            <div class="card-header border-0 pt-6 pb-4 d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="fw-bold mb-1">Tambah Barang</h3>
                    <p class="text-muted mb-0 fs-7">Input manual atau impor dari Excel</p>
                </div>

                {{-- TOMBOL IMPORT KECIL --}}
                <button class="btn btn-outline-success btn-sm"
                        data-bs-toggle="modal"
                        data-bs-target="#modalImportBarang">
                    <i class="bx bx-upload me-1"></i> Import Excel
                </button>
            </div>

            <div class="card-body pt-0">
                <form action="{{ route('barang.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- NAMA BARANG --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Barang</label>
                        <input type="text"
                               name="nama_barang"
                               class="form-control @error('nama_barang') is-invalid @enderror"
                               value="{{ old('nama_barang') }}"
                               placeholder="Contoh: Laptop Acer Aspire 5">
                        @error('nama_barang')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- TYPE BARANG --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Type Barang</label>
                        <select name="type"
                                class="form-select @error('type') is-invalid @enderror">
                            <option value="">-- Pilih Type --</option>
                            <option value="Laptop" {{ old('type') == 'Laptop' ? 'selected' : '' }}>Laptop</option>
                            <option value="Komputer" {{ old('type') == 'Komputer' ? 'selected' : '' }}>Komputer</option>
                            <option value="Printer" {{ old('type') == 'Printer' ? 'selected' : '' }}>Printer</option>
                            <option value="Scanner" {{ old('type') == 'Scanner' ? 'selected' : '' }}>Scanner</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- KODE BARANG --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kode Barang</label>
                        <input type="text"
                               name="kode_barang"
                               class="form-control @error('kode_barang') is-invalid @enderror"
                               value="{{ old('kode_barang') }}"
                               placeholder="Contoh: BRG-001">
                        @error('kode_barang')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- FOTO BARANG (OPTIONAL) --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Foto Barang <span class="text-muted fw-normal">(opsional)</span>
                        </label>

                        <input type="file"
                            name="foto"
                            class="form-control @error('foto') is-invalid @enderror"
                            accept="image/*"
                            onchange="previewFoto(this)">

                        <small class="text-muted">
                            Format JPG/PNG • Maks 2 MB
                        </small>

                        @error('foto')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        {{-- PREVIEW --}}
                        <div class="mt-3">
                            <img id="preview-image"
                                src=""
                                class="img-thumbnail d-none"
                                style="max-height: 200px;">
                        </div>
                    </div>

                    {{-- KONDISI --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kondisi</label>
                        <select name="kondisi"
                                class="form-select @error('kondisi') is-invalid @enderror">
                            <option value="Baik" {{ old('kondisi') == 'Baik' ? 'selected' : '' }}>Baik</option>
                            <option value="Perlu Servis" {{ old('kondisi') == 'Perlu Servis' ? 'selected' : '' }}>
                                Perlu Servis
                            </option>
                        </select>
                        @error('kondisi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- ACTION --}}
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('barang.index') }}" class="btn btn-light">
                            Batal
                        </a>
                        <button class="btn btn-primary px-4">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- ================= MODAL IMPORT EXCEL ================= --}}
<div class="modal fade" id="modalImportBarang" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 shadow">

            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">Impor Data Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('barang.import') }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">File Excel</label>
                        <input type="file"
                               name="file"
                               class="form-control"
                               accept=".xls,.xlsx">
                        <small class="text-muted">
                            Format .xls / .xlsx • Maks 2 MB
                        </small>
                    </div>

                    <a href="{{ asset('template/template_import_barang.xlsx') }}"
                       class="text-primary fw-semibold text-decoration-none">
                        <i class="bx bx-download me-1"></i> Download Template Excel
                    </a>
                </div>

                <div class="modal-footer border-0">
                    <button type="button"
                            class="btn btn-light"
                            data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button class="btn btn-success">
                        Import
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
    function previewFoto(input) {
        const preview = document.getElementById('preview-image');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.classList.remove('d-none');
            }

            reader.readAsDataURL(input.files[0]);
        } else {
            preview.src = '';
            preview.classList.add('d-none');
        }
    }
</script>

@endsection
