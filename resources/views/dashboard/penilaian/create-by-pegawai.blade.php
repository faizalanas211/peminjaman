@extends('layouts.admin')

@section('breadcrumb')
    <li class="breadcrumb-item active text-primary fw-semibold">Penilaian Pegawai Outsourcing</li>
@endsection

@section('content')

<div class="container py-4">

    <h3 class="fw-bold mb-4">Form Penilaian Pegawai Outsourcing</h3>

    <form action="{{ route('penilaian.storeByPegawai', $alihdaya->id) }}" method="POST">
        @csrf

        {{-- A. IDENTITAS PENILAIAN --}}
        <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
            <h5 class="fw-semibold mb-3">A. Identitas Penilaian</h5>

            <div class="row mt-2 g-3">

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Nama Pegawai</label>
                    <input type="text" class="form-control form-control-lg rounded-3"
                           value="{{ $alihdaya->nama }}" readonly>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Jabatan / Layanan</label>
                    <input type="text" class="form-control form-control-lg rounded-3"
                           value="{{ $alihdaya->jabatan }}" readonly>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Periode (Bulan)</label>
                    <input type="text" name="periode_bulan" class="form-control form-control-lg rounded-3"
                           placeholder="Contoh: Januari" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Tahun</label>
                    <input type="number" name="periode_tahun" class="form-control form-control-lg rounded-3"
                           value="{{ date('Y') }}" required>
                </div>

            </div>
        </div>

        @php
            $aspek = [
                'kedisiplinan' => ['judul' => 'Kedisiplinan', 'field' => 'kedisiplinan', 'catatan' => 'catatan_kedisiplinan'],
                'tanggung_jawab' => ['judul' => 'Tanggung Jawab & Etos Kerja', 'field' => 'tanggung_jawab', 'catatan' => 'catatan_tanggung_jawab'],
                'sikap' => ['judul' => 'Sikap dan Perilaku', 'field' => 'sikap_perilaku', 'catatan' => 'catatan_sikap'],
                'kompetensi' => ['judul' => 'Kompetensi Teknis', 'field' => 'kompetensi_teknis', 'catatan' => 'catatan_teknis'],
                'penampilan' => ['judul' => 'Kerapian & Penampilan', 'field' => 'penampilan', 'catatan' => 'catatan_penampilan'],
                'komunikasi' => ['judul' => 'Komunikasi & Kerja Sama', 'field' => 'komunikasi_kerjasama', 'catatan' => 'catatan_komunikasi'],
                'kepatuhan_vendor' => ['judul' => 'Kepatuhan Kontrak & Administrasi Vendor', 'field' => 'kepatuhan_vendor', 'catatan' => 'catatan_vendor'],
            ];
        @endphp

        {{-- B. ASPEK PENILAIAN --}}
        @foreach($aspek as $key => $item)
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                <h5 class="fw-semibold">{{ $item['judul'] }} <span class="text-muted">(Skor 1–5)</span></h5>

                <div class="row mt-3 g-3">

                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Skor</label>
                        <select name="{{ $item['field'] }}" class="form-select form-select-lg rounded-3" required>
                            <option value="">Pilih</option>
                            @for($i=1; $i<=5; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>

                    <div class="col-md-9">
                        <label class="form-label fw-semibold">Catatan / Temuan</label>
                        <textarea name="{{ $item['catatan'] }}" class="form-control rounded-3" rows="3"
                                  placeholder="Tulis catatan jika ada..."></textarea>
                    </div>

                </div>

            </div>
        @endforeach


        {{-- REKOMENDASI --}}
        <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
            <h5 class="fw-semibold">D. Rekomendasi</h5>

            @php
                $opsi = [
                    'Dilanjutkan',
                    'Perlu pembinaan',
                    'Penggantian tenaga',
                    'Evaluasi kontrak dengan vendor',
                ];
            @endphp

            <div class="mt-3">
                @foreach($opsi as $o)
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="rekomendasi" value="{{ $o }}" required>
                        <label class="form-check-label">{{ $o }}</label>
                    </div>
                @endforeach
            </div>

            <textarea name="rekomendasi_lain" class="form-control rounded-3 mt-2"
                      placeholder="Rekomendasi lain (opsional)"></textarea>
        </div>


        {{-- E. PENILAI --}}
        <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
            <h5 class="fw-semibold">E. Penilai</h5>

            <div class="row mt-3 g-3">

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Nama Penilai</label>
                    <input type="text" name="penilai_nama" class="form-control form-control-lg rounded-3" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Jabatan Penilai</label>
                    <input type="text" name="penilai_jabatan" class="form-control form-control-lg rounded-3" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Tanggal Penilaian</label>
                    <input type="date" name="tanggal_penilaian" class="form-control form-control-lg rounded-3"
                           value="{{ date('Y-m-d') }}" required>
                </div>

            </div>
        </div>


        {{-- SUBMIT --}}
        <div class="text-end mb-5">
            <button class="btn btn-primary btn-lg px-4 py-2 fw-semibold rounded-3">
                Kirim Penilaian
            </button>
        </div>

    </form>

</div>

@endsection
