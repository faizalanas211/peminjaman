@extends('layouts.admin')

@section('breadcrumb')
<li class="breadcrumb-item active text-primary fw-semibold">
    Dashboard Peminjaman Barang
</li>
@endsection

@section('content')

<div class="card card-flush shadow-sm rounded-4">

    {{-- HEADER --}}
    <div class="card-header border-0 pt-6 pb-4">
        <h3 class="fw-bold mb-1">Dashboard Peminjaman Barang</h3>
        <p class="text-muted mb-0 fs-7">Monitoring ketersediaan barang</p>
    </div>

    <div class="card-body pt-0">

        {{-- DAFTAR BARANG --}}
        <div class="row g-4">

            @forelse($dataBarang as $type => $item)
                @php
                    $progress = $item['total'] > 0
                        ? ($item['ready'] / $item['total']) * 100
                        : 0;
                @endphp

                <div class="col-xl-3 col-md-4 col-sm-6">
                    <div class="inventory-card">

                        {{-- NAMA TYPE --}}
                        <h6>{{ ucfirst($type) }}</h6>

                        {{-- JUMLAH READY --}}
                        <h2>{{ $item['ready'] }}</h2>

                        {{-- PROGRESS --}}
                        <div class="progress mb-2">
                            <div
                                class="progress-bar"
                                role="progressbar"
                                style="width: {{ $progress }}%"
                                aria-valuenow="{{ $progress }}"
                                aria-valuemin="0"
                                aria-valuemax="100"
                            ></div>
                        </div>

                        {{-- INFO --}}
                        <small class="text-muted">
                            {{ $item['dipinjam'] }} dipinjam dari {{ $item['total'] }}
                        </small>

                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-warning text-center">
                        Belum ada data barang
                    </div>
                </div>
            @endforelse

        </div>
    </div>
</div>

{{-- STYLE --}}
<style>
.inventory-card{
    background:#ffffff;
    border-radius:20px;
    padding:22px;
    height:100%;
    box-shadow:0 8px 22px rgba(0,0,0,.06);
    border:1px solid #eef0f4;
}
.inventory-card h6{
    font-size:14px;
    font-weight:600;
    color:#6b7280;
    margin-bottom:4px;
}
.inventory-card h2{
    font-size:36px;
    font-weight:700;
    margin:6px 0 14px;
    color:#111827;
}
.progress{
    height:8px;
    background:#e5e7eb;
    border-radius:6px;
    overflow:hidden;
}
.progress-bar{
    background:#4f46e5;
}
</style>

@endsection
