@extends('layouts.admin')

@section('breadcrumb')
<li class="breadcrumb-item active text-primary fw-semibold">
    Dashboard Persediaan Barang
</li>
@endsection

@section('content')

<div class="card card-flush shadow-sm rounded-4 mb-4">

    {{-- ================= HEADER ================= --}}
    <div class="card-header border-0 pt-6 pb-4">
        <h3 class="fw-bold mb-1">Dashboard Persediaan Barang</h3>
        <p class="text-muted mb-0 fs-7">
            Monitoring jumlah stok barang inventaris
        </p>
    </div>

    <div class="card-body pt-0">

        {{-- ================= CHART ================= --}}
        <div class="row">
            <div class="col-12">
                <div class="chart-card">
                    <h5 class="fw-semibold mb-3">
                        Statistik Stok Barang
                    </h5>
                    <canvas id="persediaanChart" height="120"></canvas>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- ================= STYLE ================= --}}
<style>
.chart-card{
    background:#ffffff;
    border-radius:20px;
    padding:24px;
    box-shadow:0 8px 22px rgba(0,0,0,.06);
    border:1px solid #eef0f4;
}
</style>

{{-- ================= SCRIPT ================= --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx = document.getElementById('persediaanChart');

// Data dari Controller
const dataBarang = @json($dataBarang);

// Ambil label dan nilai stok
const labels = Object.keys(dataBarang);
const stok = labels.map(label => dataBarang[label].ready);

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [
            {
                label: 'Stok Tersedia',
                data: stok,
                backgroundColor: '#4f46e5',
                borderRadius: 8
            }
        ]
    },
    options: {
        indexAxis: 'y', // 👉 Horizontal
        responsive: true,
        plugins: {
            legend: {
                position: 'top'
            }
        },
        scales: {
            x: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Jumlah Barang'
                }
            },
            y: {
                title: {
                    display: true,
                    text: 'Jenis Barang'
                }
            }
        }
    }
});
</script>

@endsection
