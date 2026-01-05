@extends('layouts.admin')

@section('breadcrumb')
<li class="breadcrumb-item">
    <a href="{{ route('barang.index') }}" class="text-muted text-decoration-none">
        Data Barang
    </a>
</li>
<li class="breadcrumb-item active text-primary fw-semibold">
    Edit Barang
</li>
@endsection

@section('content')

<div class="card card-flush shadow-sm rounded-4">

    {{-- HEADER --}}
    <div class="card-header border-0 pt-6 pb-4">
        <h3 class="fw-bold mb-1">Edit Data Barang</h3>
        <p class="text-muted mb-0 fs-7">Perbarui informasi barang inventaris</p>
    </div>

    <div class="card-body pt-0">

        {{-- FORM --}}
        <form action="{{ route('barang.update', $barang->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- NAMA BARANG --}}
            <div class="mb-4">
                <label class="form-label fw-semibold">Nama Barang</label>
                <input type="text"
                       name="nama_barang"
                       value="{{ old('nama_barang', $barang->nama_barang) }}"
                       class="form-control @error('nama_barang') is-invalid @enderror">

                @error('nama_barang')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- TYPE BARANG --}}
            <div class="mb-4">
                <label class="form-label fw-semibold">Type Barang</label>
                <select name="type"
                        class="form-select @error('type') is-invalid @enderror"
                        required>
                    <option value="">-- Pilih Type --</option>

                    <option value="Laptop"
                        {{ old('type', $barang->type) == 'Laptop' ? 'selected' : '' }}>
                        Laptop
                    </option>

                    <option value="Komputer"
                        {{ old('type', $barang->type) == 'Komputer' ? 'selected' : '' }}>
                        Komputer
                    </option>

                    <option value="Printer"
                        {{ old('type', $barang->type) == 'Printer' ? 'selected' : '' }}>
                        Printer
                    </option>

                    <option value="Scanner"
                        {{ old('type', $barang->type) == 'Scanner' ? 'selected' : '' }}>
                        Scanner
                    </option>
                </select>

                @error('type')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>


            {{-- KODE BARANG --}}
            <div class="mb-4">
                <label class="form-label fw-semibold">Kode Barang</label>
                <input type="text"
                       name="kode_barang"
                       value="{{ old('kode_barang', $barang->kode_barang) }}"
                       class="form-control @error('kode_barang') is-invalid @enderror">

                @error('kode_barang')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- KONDISI --}}
            <div class="mb-4">
                <label class="form-label fw-semibold">Kondisi</label>
                <select name="kondisi"
                        class="form-select @error('kondisi') is-invalid @enderror">
                    <option value="Baik" {{ old('kondisi', $barang->kondisi) == 'Baik' ? 'selected' : '' }}>
                        Baik
                    </option>
                    <option value="Perlu Servis" {{ old('kondisi', $barang->kondisi) == 'Perlu Servis' ? 'selected' : '' }}>
                        Perlu Servis
                    </option>
                </select>

                @error('kondisi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- FOTO BARANG --}}
            <div class="mb-4">
                <label class="form-label fw-semibold">
                    Foto Barang <span class="text-muted fw-normal">(opsional)</span>
                </label>

                {{-- FOTO SAAT INI --}}
                @if($barang->foto)
                    <div class="mb-3">
                        <p class="text-muted mb-1 fs-7">Foto saat ini:</p>
                        <img src="{{ asset('storage/' . $barang->foto) }}"
                            class="img-thumbnail"
                            style="max-height: 200px;">
                    </div>
                @else
                    <p class="text-muted fs-7 mb-2">Belum ada foto</p>
                @endif

                {{-- INPUT FILE --}}
                <input type="file"
                    name="foto"
                    class="form-control @error('foto') is-invalid @enderror"
                    accept="image/*"
                    onchange="previewFoto(this)">

                <small class="text-muted">
                    Kosongkan jika tidak ingin mengganti foto
                </small>

                @error('foto')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

                {{-- PREVIEW FOTO BARU --}}
                <div class="mt-3">
                    <img id="preview-image"
                        class="img-thumbnail d-none"
                        style="max-height: 200px;">
                </div>
            </div>

            {{-- STATUS (TIDAK BISA DIEDIT) --}}
            <div class="mb-4">
                <label class="form-label fw-semibold">Status</label>

                {{-- TAMPILAN --}}
                <div>
                    @if ($barang->status === 'tersedia')
                        <span class="badge bg-success px-3 py-2">Tersedia</span>
                    @elseif ($barang->status === 'dipinjam')
                        <span class="badge bg-warning text-dark px-3 py-2">Dipinjam</span>
                    @else
                        <span class="badge bg-danger px-3 py-2">Rusak</span>
                    @endif
                </div>

                {{-- KIRIM VALUE KE SERVER (TAPI TIDAK BISA DIUBAH USER) --}}
                <input type="hidden" name="status" value="{{ $barang->status }}">
            </div>


            {{-- BUTTON --}}
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('barang.index') }}"
                   class="btn btn-light px-4">
                    Batal
                </a>
                <button type="submit"
                        class="btn btn-primary px-4">
                    Simpan Perubahan
                </button>
            </div>

        </form>

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
            };

            reader.readAsDataURL(input.files[0]);
        } else {
            preview.src = '';
            preview.classList.add('d-none');
        }
    }
</script>
@endsection

