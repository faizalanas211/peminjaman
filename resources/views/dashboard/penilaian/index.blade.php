@extends('layouts.admin')

@section('breadcrumb')
<li class="breadcrumb-item active text-primary fw-semibold">
    Penilaian Pegawai Outsourcing
</li>
@endsection

@section('content')
<div class="container">

    {{-- HEADER --}}
    <div class="mb-4">
        <h3 class="fw-bold">Penilaian Alih Daya 2025</h3>
        <p class="text-muted mb-0">
            Balai Bahasa Provinsi Jawa Tengah
        </p>
    </div>

    <form action="{{ route('penilaian.store') }}" method="POST">
        @csrf

        {{-- IDENTITAS PENILAI --}}
        <div class="card p-3 mb-4 border-0 shadow-sm modern-card">
            <div class="row">
                <div class="col-md-6">
                    <label class="fw-semibold">Nama Penilai</label>
                    <input type="text" name="nama_penilai" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="fw-semibold">NIP Penilai</label>
                    <input type="text" name="nip_penilai" class="form-control" required>
                </div>
            </div>
        </div>

        {{-- PILIH PEGAWAI --}}
        <div class="card p-3 mb-4 border-0 shadow-sm modern-card">
            <h6 class="fw-bold mb-3">Nama dan Foto Pegawai Alih Daya</h6>

            <div class="row g-3">
                @foreach($pegawaiAlihdaya as $p)
                <div class="col-6 col-md-3">
                    <label class="pegawai-wrapper w-100">
                        <input type="checkbox"
                               name="pegawai_id[]"
                               value="{{ $p->id }}"
                               hidden>

                        <div class="pegawai-box text-center">
                            <div class="foto-wrapper">
                                <img src="{{ $p->foto ? asset('storage/'.$p->foto) : asset('img/default-user.png') }}"
                                     alt="{{ $p->nama }}">
                            </div>

                            <small class="fw-semibold d-block mt-2">
                                {{ $p->nama }}
                            </small>
                        </div>
                    </label>
                </div>
                @endforeach
            </div>
        </div>

        {{-- KRITERIA --}}
        <div class="card p-3 mb-4 border-0 shadow-sm modern-card">
            <h6 class="fw-bold">Kriteria Penilaian</h6>
            <ol class="mb-0">
                <li>Kualitas Kerja</li>
                <li>Kuantitas Kerja</li>
                <li>Kedisiplinan</li>
                <li>Tanggung Jawab</li>
                <li>Kerjasama</li>
                <li>Komunikasi</li>
                <li>Pengembangan Diri</li>
                <li>Loyalitas</li>
            </ol>
        </div>

        {{-- TABEL NILAI + KRITIK SARAN --}}
        <div class="card p-3 border-0 shadow-sm modern-card">
            <h6 class="fw-bold mb-3">Skor Penilaian & Kritik Saran</h6>

            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light text-center">
                        <tr>
                            <th style="min-width:200px">Nama Pegawai</th>
                            @for($i=1;$i<=5;$i++)
                                <th>{{ $i }}</th>
                            @endfor
                            <th style="min-width:300px">Kritik & Saran</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($pegawaiAlihdaya as $p)
                        <tr>
                            <td>{{ $p->nama }}</td>

                            @for($i=1;$i<=5;$i++)
                            <td class="text-center">
                                <input type="radio"
                                       name="nilai[{{ $p->id }}]"
                                       value="{{ $i }}"
                                       required>
                            </td>
                            @endfor

                            <td>
                                <textarea
                                    name="kritik_saran[{{ $p->id }}]"
                                    class="form-control"
                                    rows="2"
                                    placeholder="Tulis kritik & saran untuk {{ $p->nama }}"></textarea>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- SUBMIT --}}
        <div class="text-end mt-4">
            <button class="btn btn-primary modern-btn px-4">
                Simpan Penilaian
            </button>
        </div>

    </form>

</div>
@endsection

{{-- STYLE --}}
<style>
.modern-card{
    border-radius:16px;
}

/* KARTU PEGAWAI */
.pegawai-box{
    border:2px solid transparent;
    border-radius:14px;
    padding:10px;
    cursor:pointer;
    transition:.2s;
    height:100%;
}

/* WRAPPER FOTO */
.foto-wrapper{
    width:100%;
    height:180px;
    border-radius:12px;
    overflow:hidden;
    background:#f1f5f9;
    display:flex;
    align-items:center;
    justify-content:center;
}

.foto-wrapper img{
    width:100%;
    height:100%;
    object-fit:cover;
    object-position:top;
}

/* SAAT DIPILIH */
.pegawai-wrapper input:checked + .pegawai-box{
    border:2px solid #4f46e5;
    background:#eef2ff;
    box-shadow:0 0 0 3px rgba(79,70,229,.15);
}

.modern-btn{
    border-radius:10px;
    font-weight:600;
}
</style>
