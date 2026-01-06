@extends('layouts.admin')

@section('breadcrumb')
<li class="breadcrumb-item active text-primary fw-semibold">
    Dashboard Peminjaman Barang
</li>
@endsection

@section('content')

<div class="card card-flush shadow-sm rounded-4 mb-4">
    {{-- HEADER --}}
    <div class="card-header border-0 pt-6 pb-4">
        <h3 class="fw-bold mb-1">Dashboard Peminjaman Barang</h3>
        <p class="text-muted mb-0 fs-7">Monitoring ketersediaan barang BMN</p>
    </div>

    <div class="card-body pt-0">
        
        {{-- ================= STATISTIK CARD ================= --}}
        <div class="row g-4 mb-6">
            <div class="col-md-3">
                <div class="inventory-card">
                    <h6>Total Barang</h6>
                    <h2>{{ $totalBarang }}</h2>
                    <div class="progress">
                        <div class="progress-bar" style="width: 100%"></div>
                    </div>
                    <p class="text-muted fs-8 mt-2">Jumlah seluruh barang</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="inventory-card">
                    <h6>Tersedia</h6>
                    <h2>{{ $barangTersedia }}</h2>
                    <div class="progress">
                        <div class="progress-bar bg-success" style="width: {{ $persentaseTersedia }}%"></div>
                    </div>
                    <p class="text-muted fs-8 mt-2">{{ $persentaseTersedia }}% dari total</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="inventory-card">
                    <h6>Dipinjam</h6>
                    <h2>{{ $barangDipinjam }}</h2>
                    <div class="progress">
                        <div class="progress-bar bg-warning" style="width: {{ $persentaseDipinjam }}%"></div>
                    </div>
                    <p class="text-muted fs-8 mt-2">{{ $persentaseDipinjam }}% dari total</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="inventory-card">
                    <h6>Rusak</h6>
                    <h2>{{ $barangRusak }}</h2>
                    <div class="progress">
                        <div class="progress-bar bg-danger" style="width: {{ $persentaseRusak }}%"></div>
                    </div>
                    <p class="text-muted fs-8 mt-2">{{ $persentaseRusak }}% dari total</p>
                </div>
            </div>
        </div>

        {{-- ================= CHART BARANG PER JENIS ================= --}}
        @if(isset($barangPerJenis) && count($barangPerJenis) > 0)
        <div class="row mb-6">
            <div class="col-12">
                <div class="chart-card">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h5 class="fw-semibold mb-1">Distribusi Barang per Jenis</h5>
                            <p class="text-muted fs-8 mb-0">
                                <i class="fas fa-chart-bar me-1"></i>
                                Perbandingan jumlah tersedia vs dipinjam per jenis barang
                            </p>
                        </div>
                        <div class="chart-legend d-flex align-items-center">
                            <div class="legend-item me-3">
                                <span class="legend-color bg-success"></span>
                                <span class="fs-8">Tersedia</span>
                            </div>
                            <div class="legend-item">
                                <span class="legend-color bg-warning"></span>
                                <span class="fs-8">Dipinjam</span>
                            </div>
                        </div>
                    </div>
                    <div class="chart-container" style="position: relative; height: 300px;">
                        <canvas id="barangPerJenisChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- ================= SLIDESHOW PEMINJAMAN AKTIF ================= --}}
        <div class="row mb-6">
            <div class="col-12">
                <div class="slideshow-card">
                    <div class="d-flex justify-content-between align-items-center mb-5">
                        <div>
                            <h5 class="fw-semibold mb-1">Barang Sedang Dipinjam</h5>
                            <p class="text-muted fs-8 mb-0">
                                <i class="fas fa-info-circle me-1"></i>
                                Menampilkan {{ count($peminjamanAktif) }} barang yang sedang dipinjam
                            </p>
                        </div>
                        <div class="slideshow-controls d-flex align-items-center">
                            <button class="btn btn-light btn-sm me-2" id="pausePlayBtn" title="Pause/Play">
                                <i class="fas fa-pause" id="pausePlayIcon"></i>
                            </button>
                            <button class="btn btn-light btn-sm me-2" id="prevBtn" title="Sebelumnya">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <div class="mx-3 text-muted d-flex align-items-center">
                                <span class="fw-semibold" id="currentSlide">1</span>
                                <span class="mx-2">/</span>
                                <span class="fw-semibold" id="totalSlides">{{ count($peminjamanAktif) }}</span>
                            </div>
                            <button class="btn btn-light btn-sm ms-2" id="nextBtn" title="Berikutnya">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                            <button class="btn btn-light btn-sm ms-2" id="fullscreenBtn" title="Fullscreen">
    <i class="fas fa-expand" id="fullscreenIcon"></i>
</button>

                        </div>
                    </div>

                    @if(count($peminjamanAktif) > 0)
                    <div class="slideshow-wrapper">
                        <div class="slideshow-container" id="slideshowContainer">
                            @foreach($peminjamanAktif as $index => $peminjam)
                            <div class="slide-card @if($index === 0) active @endif" id="slide-{{ $index }}" data-index="{{ $index }}">
                                <div class="slide-content">
                                    <div class="row align-items-center">
                                        {{-- Foto Barang --}}
                                        <div class="col-lg-5">
                                            <div class="item-photo-wrapper">
                                                @if($peminjam->barang && $peminjam->barang->foto)
                                                    <img src="{{ asset('storage/' . $peminjam->barang->foto) }}" 
                                                         alt="{{ $peminjam->barang->nama_barang }}"
                                                         class="item-photo"
                                                         onerror="this.src='{{ asset('images/default-item.jpg') }}'">
                                                @else
                                                    <div class="no-photo-placeholder">
                                                        <div class="no-photo-icon">
                                                            <i class="fas fa-box-open fa-4x text-muted"></i>
                                                        </div>
                                                        <p class="text-muted mt-3 mb-0">{{ $peminjam->barang->nama_barang ?? 'Barang' }}</p>
                                                    </div>
                                                @endif
                                                
                                                {{-- Badge Kondisi --}}
                                                <div class="kondisi-badge mt-4">
                                                    @php
                                                        $kondisiColor = match($peminjam->barang->kondisi ?? 'baik') {
                                                            'baik' => 'success',
                                                            'sedang' => 'warning',
                                                            'rusak' => 'danger',
                                                            default => 'secondary'
                                                        };
                                                    @endphp
                                                    <span class="badge bg-{{ $kondisiColor }}-subtle text-{{ $kondisiColor }} px-3 py-2">
                                                        <i class="fas fa-thermometer-half me-1"></i>
                                                        Kondisi: {{ ucfirst($peminjam->barang->kondisi ?? 'baik') }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Detail Barang --}}
                                        <div class="col-lg-7">
                                            <div class="item-details-wrapper ps-lg-4">
                                                {{-- Header dengan status --}}
                                                <div class="mb-4">
                                                    <span class="badge bg-warning-subtle text-warning fs-7 px-3 py-2 mb-3">
                                                        <i class="fas fa-clock me-1"></i>
                                                        SEDANG DIPINJAM
                                                    </span>
                                                    <h4 class="fw-bold mb-2">{{ $peminjam->barang->nama_barang ?? 'N/A' }}</h4>
                                                    <p class="text-muted fs-7 mb-4">
                                                        <i class="fas fa-barcode me-1"></i>
                                                        Kode: {{ $peminjam->barang->kode_barang ?? 'N/A' }}
                                                    </p>
                                                </div>

                                                {{-- Info Peminjaman Grid --}}
                                                <div class="row g-4">
                                                    <div class="col-md-6">
                                                        <div class="info-card">
                                                            <div class="info-icon">
                                                                <i class="fas fa-user text-primary"></i>
                                                            </div>
                                                            <div class="info-content">
                                                                <p class="text-muted fs-8 mb-1">PEMINJAM</p>
                                                                <p class="fw-semibold mb-1">{{ $peminjam->nama_peminjam }}</p>
                                                                @if($peminjam->kelas)
                                                                <p class="text-muted fs-8 mt-1 mb-0">
                                                                    <i class="fas fa-building me-1"></i>
                                                                    {{ $peminjam->kelas }}
                                                                </p>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-6">
                                                        <div class="info-card">
                                                            <div class="info-icon">
                                                                <i class="fas fa-calendar-alt text-info"></i>
                                                            </div>
                                                            <div class="info-content">
                                                                <p class="text-muted fs-8 mb-1">TANGGAL PINJAM</p>
                                                                <p class="fw-semibold mb-1">
                                                                    {{ \Carbon\Carbon::parse($peminjam->tanggal_pinjam)->isoFormat('DD MMMM YYYY') }}
                                                                </p>
                                                                <p class="text-muted fs-8 mt-1 mb-0">
                                                                    <i class="fas fa-history me-1"></i>
                                                                    {{ \Carbon\Carbon::parse($peminjam->tanggal_pinjam)->diffForHumans() }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Dots Navigation --}}
                    @if(count($peminjamanAktif) > 1)
                    <div class="slideshow-dots mt-5 text-center">
                        @foreach($peminjamanAktif as $index => $peminjam)
                        <button type="button" 
                                class="dot-btn @if($index === 0) active @endif" 
                                data-index="{{ $index }}"
                                aria-label="Slide {{ $index + 1 }}">
                        </button>
                        @endforeach
                    </div>
                    @endif
                    
                    @else
                    {{-- Empty State --}}
                    <div class="empty-state text-center py-8">
                        <div class="empty-icon mb-4">
                            <i class="fas fa-check-circle fa-4x text-success opacity-25"></i>
                        </div>
                        <h5 class="text-muted mb-2">Tidak ada barang yang sedang dipinjam</h5>
                        <p class="text-muted fs-7 mb-0">Semua barang BMN tersedia di inventaris</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- ================= CHART BARANG PER TIPE ================= --}}
        <div class="row mb-6">
            <div class="col-12">
                <div class="slideshow-card">
                    <h5 class="fw-semibold mb-1">Ketersediaan Barang per Jenis</h5>
                    <p class="text-muted fs-8 mb-4">
                        Perbandingan barang tersedia dan dipinjam berdasarkan jenis
                    </p>

                    <div style="height: 320px;">
                        <canvas id="barangPerTypeChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ================= STYLE ================= --}}
<style>
/* FontAwesome */
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css');

/* Reset dan base styling */
body {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
}

/* Statistik Card */
.inventory-card {
    background: #ffffff;
    border-radius: 16px;
    padding: 24px;
    height: 100%;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    border: 1px solid #e5e7eb;
    transition: all 0.2s ease;
}

.inventory-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
}

.inventory-card h6 {
    font-size: 14px;
    font-weight: 600;
    color: #6b7280;
    margin-bottom: 8px;
    letter-spacing: 0.3px;
}

.inventory-card h2 {
    font-size: 32px;
    font-weight: 700;
    margin: 8px 0 12px;
    color: #111827;
    line-height: 1.2;
}

.progress {
    height: 6px;
    background: #f3f4f6;
    border-radius: 3px;
    margin-top: 16px;
    overflow: hidden;
}

.progress-bar {
    border-radius: 3px;
    transition: width 0.6s ease;
}

/* Chart Card */
.chart-card {
    background: #ffffff;
    border-radius: 20px;
    padding: 32px;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
    border: 1px solid #e5e7eb;
    margin-bottom: 24px;
}

.chart-legend {
    display: flex;
    align-items: center;
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 6px;
}

.legend-color {
    width: 12px;
    height: 12px;
    border-radius: 3px;
}

/* Slideshow Card */
.slideshow-card {
    background: #ffffff;
    border-radius: 20px;
    padding: 32px;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
    border: 1px solid #e5e7eb;
}

/* Slideshow Controls */
.slideshow-controls {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px;
    background: #f9fafb;
    border-radius: 12px;
    border: 1px solid #e5e7eb;
}

.slideshow-controls .btn-light {
    border: 1px solid #d1d5db;
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    background: white;
    color: #4b5563;
    transition: all 0.2s ease;
    padding: 0;
}

.slideshow-controls .btn-light:hover {
    background: #4f46e5;
    color: white;
    border-color: #4f46e5;
    transform: translateY(-1px);
}

.slideshow-controls .btn-light:active {
    transform: translateY(0);
}

.slideshow-controls .btn-light i {
    font-size: 14px;
    line-height: 1;
}

.slideshow-controls .text-muted {
    font-size: 14px;
    font-weight: 500;
    color: #4b5563;
    min-width: 50px;
    text-align: center;
}

/* PERBAIKAN UTAMA: Slideshow Structure tanpa efek bayangan */
.slideshow-wrapper {
    position: relative;
    min-height: 380px;
    border-radius: 12px;
    background: #f9fafb;
    overflow: hidden; /* Sembunyikan slide yang keluar */
}

.slideshow-container {
    position: relative;
    width: 100%;
    height: 100%;
    padding: 24px;
}

/* PERBAIKAN UTAMA: Slide card dengan transisi yang lebih bersih */
.slide-card {
    position: absolute;
    width: calc(100% - 48px); /* Kurangi padding container */
    top: 24px;
    left: 24px;
    opacity: 0;
    visibility: hidden;
    transform: translateX(100%);
    transition: transform 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94), 
                opacity 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    pointer-events: none;
    z-index: 1;
    will-change: transform, opacity;
}

.slide-card.active {
    opacity: 1;
    visibility: visible;
    transform: translateX(0);
    pointer-events: all;
    z-index: 2;
    position: relative; /* Pastikan tidak overlap */
}

/* Item Photo */
.item-photo-wrapper {
    border-radius: 12px;
    overflow: hidden;
    background: #ffffff;
    padding: 20px;
    border: 1px solid #e5e7eb;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
}

.item-photo {
    width: 100%;
    height: 240px;
    object-fit: cover;
    border-radius: 8px;
}

.no-photo-placeholder {
    height: 240px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background: #f3f4f6;
    border-radius: 8px;
}

.no-photo-icon {
    color: #9ca3af;
}

.kondisi-badge {
    text-align: center;
    margin-top: 20px;
}

/* Item Details */
.item-details-wrapper {
    padding: 0;
}

.item-details-wrapper .badge {
    font-weight: 600;
    letter-spacing: 0.3px;
}

.item-details-wrapper h4 {
    font-size: 24px;
    font-weight: 700;
    color: #111827;
    margin-bottom: 8px;
}

/* Info Cards */
.info-card {
    background: #f9fafb;
    border-radius: 10px;
    padding: 20px;
    display: flex;
    align-items: flex-start;
    gap: 14px;
    height: 100%;
    border: 1px solid #e5e7eb;
    transition: all 0.2s ease;
}

.info-card:hover {
    background: #ffffff;
    border-color: #d1d5db;
    transform: translateY(-1px);
}

.info-icon {
    background: white;
    width: 44px;
    height: 44px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    border: 1px solid #e5e7eb;
    font-size: 18px;
}

.info-content {
    flex: 1;
}

.info-content p.text-muted {
    font-size: 13px;
    margin-bottom: 4px;
    color: #6b7280;
}

.info-content .fw-semibold {
    font-size: 16px;
    color: #111827;
    margin-bottom: 6px;
}

/* Dots Navigation */
.slideshow-dots {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-top: 32px;
    padding-top: 24px;
    border-top: 1px solid #e5e7eb;
}

.dot-btn {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    border: none;
    background: #d1d5db;
    padding: 0;
    cursor: pointer;
    transition: all 0.2s ease;
}

.dot-btn.active {
    background: #4f46e5;
    transform: scale(1.2);
}

.dot-btn:hover:not(.active) {
    background: #9ca3af;
}

/* Empty State */
.empty-state {
    min-height: 300px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 40px 20px;
    background: #f9fafb;
    border-radius: 12px;
    border: 1px solid #e5e7eb;
}

.empty-icon {
    color: #10b981;
    opacity: 0.3;
    margin-bottom: 20px;
}

/* PERBAIKAN UTAMA: Animation classes untuk mencegah bayangan */
.fade-transition {
    transition: opacity 0.5s ease !important;
}

/* Autoplay Status */
.autoplay-active .btn-light#pausePlayBtn {
    background: #4f46e5 !important;
    color: white !important;
    border-color: #4f46e5 !important;
}

/* Responsive */
@media (max-width: 992px) {
    .inventory-card {
        padding: 20px;
        margin-bottom: 16px;
    }
    
    .inventory-card h2 {
        font-size: 28px;
    }
    
    .chart-card, .slideshow-card {
        padding: 24px;
    }
    
    .slideshow-container {
        padding: 20px;
    }
    
    .slide-card {
        width: calc(100% - 40px);
        top: 20px;
        left: 20px;
    }
    
    .item-photo-wrapper {
        margin-bottom: 20px;
    }
    
    .item-details-wrapper {
        padding-left: 0 !important;
    }
}

@media (max-width: 768px) {
    .slideshow-controls {
        padding: 6px;
    }
    
    .slideshow-controls .btn-light {
        width: 32px;
        height: 32px;
    }
    
    .info-card {
        padding: 16px;
    }
    
    .info-icon {
        width: 40px;
        height: 40px;
        font-size: 16px;
    }
    
    .chart-legend {
        flex-wrap: wrap;
        justify-content: flex-start;
        margin-top: 10px;
    }
}

/* Spacing Utilities */
.mb-1 { margin-bottom: 0.25rem !important; }
.mb-2 { margin-bottom: 0.5rem !important; }
.mb-3 { margin-bottom: 0.75rem !important; }
.mb-4 { margin-bottom: 1rem !important; }
.mb-5 { margin-bottom: 1.25rem !important; }
.mb-6 { margin-bottom: 1.5rem !important; }

.mt-1 { margin-top: 0.25rem !important; }
.mt-2 { margin-top: 0.5rem !important; }
.mt-3 { margin-top: 0.75rem !important; }
.mt-4 { margin-top: 1rem !important; }
.mt-5 { margin-top: 1.25rem !important; }

.pt-4 { padding-top: 1rem !important; }
.pt-5 { padding-top: 1.25rem !important; }

/* Text Sizes */
.fs-7 { font-size: 0.875rem !important; }
.fs-8 { font-size: 0.75rem !important; }
</style>

{{-- ================= SCRIPT ================= --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    initSlideshow();
    initChart();
});

function initSlideshow() {
    const slides = document.querySelectorAll('.slide-card');
    const dots = document.querySelectorAll('.dot-btn');
    const currentSlideEl = document.getElementById('currentSlide');
    const totalSlidesEl = document.getElementById('totalSlides');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const pausePlayBtn = document.getElementById('pausePlayBtn');
    const pausePlayIcon = document.getElementById('pausePlayIcon');
    
    if (slides.length === 0) return;
    
    let currentIndex = 0;
    let isPlaying = true;
    let isTransitioning = false;
    let autoPlayInterval;
    const slideDuration = 8000;
    const transitionDuration = 500;
    
    // Update total slides
    if (totalSlidesEl) {
        totalSlidesEl.textContent = slides.length;
    }
    
    // Initialize first slide
    showSlide(currentIndex);
    
    // Start autoplay
    startAutoPlay();
    
    // Event listeners
    if (prevBtn) {
        prevBtn.addEventListener('click', () => {
            if (!isTransitioning) prevSlide();
        });
    }
    
    if (nextBtn) {
        nextBtn.addEventListener('click', () => {
            if (!isTransitioning) nextSlide();
        });
    }
    
    if (pausePlayBtn && pausePlayIcon) {
        pausePlayBtn.addEventListener('click', togglePlayPause);
    }
    
    // Dot navigation
    dots.forEach(dot => {
        dot.addEventListener('click', (e) => {
            if (isTransitioning) return;
            const index = parseInt(e.currentTarget.dataset.index);
            if (index !== currentIndex) {
                goToSlide(index);
            }
        });
    });
    
    // Keyboard navigation
    document.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowLeft') {
            e.preventDefault();
            if (!isTransitioning) prevSlide();
        }
        if (e.key === 'ArrowRight') {
            e.preventDefault();
            if (!isTransitioning) nextSlide();
        }
        if (e.key === ' ' || e.key === 'Spacebar') {
            e.preventDefault();
            togglePlayPause();
        }
    });
    
    function showSlide(index, direction = 'next') {
        if (isTransitioning) return;
        isTransitioning = true;
        
        const prevIndex = currentIndex;
        currentIndex = index;
        
        // Update dots
        dots.forEach(dot => dot.classList.remove('active'));
        
        // Add active class to current dot
        if (dots[currentIndex]) {
            dots[currentIndex].classList.add('active');
        }
        
        // Update counter
        if (currentSlideEl) {
            currentSlideEl.textContent = currentIndex + 1;
        }
        
        // Reset all slides to default state
        slides.forEach(slide => {
            slide.classList.remove('active');
            slide.style.opacity = '0';
            slide.style.visibility = 'hidden';
            slide.style.transform = 'translateX(100%)';
            slide.style.transition = 'none'; // Disable transition for reset
        });
        
        // Immediate reset for smooth transition
        setTimeout(() => {
            // Set transition for animation
            slides.forEach(slide => {
                slide.style.transition = `transform ${transitionDuration}ms cubic-bezier(0.25, 0.46, 0.45, 0.94), 
                                         opacity ${transitionDuration}ms cubic-bezier(0.25, 0.46, 0.45, 0.94)`;
            });
            
            // Handle previous slide (slide out)
            if (slides[prevIndex]) {
                if (direction === 'next') {
                    slides[prevIndex].style.transform = 'translateX(-100%)';
                } else if (direction === 'prev') {
                    slides[prevIndex].style.transform = 'translateX(100%)';
                }
                slides[prevIndex].style.opacity = '0';
                slides[prevIndex].style.visibility = 'hidden';
            }
            
            // Handle current slide (slide in)
            if (slides[currentIndex]) {
                slides[currentIndex].style.transform = 'translateX(0)';
                slides[currentIndex].style.opacity = '1';
                slides[currentIndex].style.visibility = 'visible';
                slides[currentIndex].classList.add('active');
            }
            
            // Reset transition flag after animation completes
            setTimeout(() => {
                isTransitioning = false;
                // Clean up: hide all non-active slides completely
                slides.forEach((slide, i) => {
                    if (i !== currentIndex) {
                        slide.style.opacity = '0';
                        slide.style.visibility = 'hidden';
                        slide.style.transform = 'translateX(100%)';
                    }
                });
            }, transitionDuration);
        }, 10);
    }
    
    function nextSlide() {
        const nextIndex = (currentIndex + 1) % slides.length;
        showSlide(nextIndex, 'next');
        resetAutoPlay();
    }
    
    function prevSlide() {
        const prevIndex = (currentIndex - 1 + slides.length) % slides.length;
        showSlide(prevIndex, 'prev');
        resetAutoPlay();
    }
    
    function goToSlide(index) {
        if (index === currentIndex) return;
        const direction = index > currentIndex ? 'next' : 'prev';
        showSlide(index, direction);
        resetAutoPlay();
    }
    
    function startAutoPlay() {
        if (slides.length <= 1) return;
        
        autoPlayInterval = setInterval(() => {
            if (!isTransitioning) {
                const nextIndex = (currentIndex + 1) % slides.length;
                showSlide(nextIndex, 'next');
            }
        }, slideDuration);
        
        isPlaying = true;
        updatePlayPauseButton();
    }
    
    function stopAutoPlay() {
        if (autoPlayInterval) {
            clearInterval(autoPlayInterval);
            autoPlayInterval = null;
        }
        
        isPlaying = false;
        updatePlayPauseButton();
    }
    
    function resetAutoPlay() {
        if (isPlaying) {
            stopAutoPlay();
            startAutoPlay();
        }
    }
    
    function togglePlayPause() {
        if (isPlaying) {
            stopAutoPlay();
        } else {
            startAutoPlay();
        }
    }
    
    function updatePlayPauseButton() {
        if (!pausePlayBtn || !pausePlayIcon) return;
        
        if (isPlaying) {
            pausePlayIcon.className = 'fas fa-pause';
            pausePlayBtn.title = 'Pause slideshow';
            pausePlayBtn.classList.add('autoplay-active');
        } else {
            pausePlayIcon.className = 'fas fa-play';
            pausePlayBtn.title = 'Play slideshow';
            pausePlayBtn.classList.remove('autoplay-active');
        }
    }
    
    // Update button states
    function updateButtonStates() {
        const hasMultipleSlides = slides.length > 1;
        
        if (!hasMultipleSlides) {
            [prevBtn, nextBtn, pausePlayBtn].forEach(btn => {
                if (btn) {
                    btn.style.opacity = '0.5';
                    btn.style.cursor = 'not-allowed';
                    btn.disabled = true;
                }
            });
        }
    }
    
    updateButtonStates();
}

function initChart() {
    const ctx = document.getElementById('barangPerJenisChart');
    if (!ctx) return;
    
    // Data dari controller
    const chartData = @json($barangPerJenis ?? []);
    
    if (Object.keys(chartData).length === 0) return;
    
    // Format data untuk chart
    const labels = Object.keys(chartData);
    const tersediaData = labels.map(label => chartData[label].tersedia || 0);
    const dipinjamData = labels.map(label => chartData[label].dipinjam || 0);
    
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Tersedia',
                    data: tersediaData,
                    backgroundColor: '#10b981',
                    borderRadius: 6,
                    borderSkipped: false,
                    barPercentage: 0.6,
                    categoryPercentage: 0.8
                },
                {
                    label: 'Dipinjam',
                    data: dipinjamData,
                    backgroundColor: '#f59e0b',
                    borderRadius: 6,
                    borderSkipped: false,
                    barPercentage: 0.6,
                    categoryPercentage: 0.8
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        padding: 20,
                        font: {
                            size: 12
                        }
                    }
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            label += context.parsed.y + ' barang';
                            return label;
                        },
                        afterLabel: function(context) {
                            const total = tersediaData[context.dataIndex] + dipinjamData[context.dataIndex];
                            const percentage = total > 0 ? Math.round((context.parsed.y / total) * 100) : 0;
                            return `${percentage}% dari total ${labels[context.dataIndex]}`;
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        font: {
                            size: 11
                        },
                        maxRotation: 45,
                        minRotation: 0
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        drawBorder: false,
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    ticks: {
                        font: {
                            size: 11
                        },
                        stepSize: 1,
                        callback: function(value) {
                            return Number.isInteger(value) ? value : '';
                        }
                    },
                    title: {
                        display: true,
                        text: 'Jumlah Barang',
                        font: {
                            size: 12,
                            weight: 'normal'
                        }
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            },
            animation: {
                duration: 750,
                easing: 'easeInOutQuart'
            }
        }
    });
}
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('barangPerTypeChart');
    if (!ctx) return;

    const chartData = @json($statPerType);

    const labels = chartData.map(item => item.type);
    const tersediaData = chartData.map(item => item.tersedia);
    const dipinjamData = chartData.map(item => item.dipinjam);

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Tersedia',
                    data: tersediaData,
                    backgroundColor: '#10b981'
                },
                {
                    label: 'Dipinjam',
                    data: dipinjamData,
                    backgroundColor: '#f59e0b'
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        boxWidth: 14,
                        font: {
                            size: 13
                        }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `${context.dataset.label}: ${context.parsed.y} barang`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    },
                    title: {
                        display: true,
                        text: 'Jumlah Barang'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Jenis Barang'
                    }
                }
            }
        }
    });
});
</script>
<script>
    const fullscreenBtn = document.getElementById('fullscreenBtn');
    const fullscreenIcon = document.getElementById('fullscreenIcon');
    const slideshowCard = document.querySelector('.slideshow-card');

    fullscreenBtn.addEventListener('click', () => {
        if (!document.fullscreenElement) {
            slideshowCard.requestFullscreen();
        } else {
            document.exitFullscreen();
        }
    });

    document.addEventListener('fullscreenchange', () => {
        if (document.fullscreenElement) {
            fullscreenIcon.classList.remove('fa-expand');
            fullscreenIcon.classList.add('fa-compress');
        } else {
            fullscreenIcon.classList.remove('fa-compress');
            fullscreenIcon.classList.add('fa-expand');
        }
    });
</script>

@endsection