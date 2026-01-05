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
        <div class="row g-4 mb-5"> {{-- Reduced margin-bottom --}}
            <div class="col-md-3">
                <div class="inventory-card">
                    <h6>Total Barang</h6>
                    <h2>{{ $totalBarang }}</h2>
                    <div class="progress">
                        <div class="progress-bar" style="width: 100%"></div>
                    </div>
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

        {{-- ================= SLIDESHOW PEMINJAMAN AKTIF ================= --}}
        <div class="row mb-6">
            <div class="col-12">
                <div class="slideshow-card">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h5 class="fw-semibold mb-0">Barang Sedang Dipinjam</h5>
                            <p class="text-muted fs-8 mb-0">
                                <i class="fas fa-info-circle me-1"></i>
                                Menampilkan {{ count($peminjamanAktif) }} barang yang sedang dipinjam
                            </p>
                        </div>
                        <div class="slideshow-controls d-flex align-items-center">
                            <button class="btn btn-light btn-sm me-2" id="pausePlayBtn" title="Pause/Play">
                                <i class="fas fa-pause" id="pausePlayIcon"></i>
                            </button>
                            <button class="btn btn-light btn-sm me-2" id="prevBtn">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <div class="mx-2 text-muted d-flex align-items-center">
                                <span id="currentSlide">1</span>
                                <span class="mx-1">/</span>
                                <span id="totalSlides">{{ count($peminjamanAktif) }}</span>
                            </div>
                            <button class="btn btn-light btn-sm ms-2" id="nextBtn">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>
                    </div>

                    @if(count($peminjamanAktif) > 0)
                    <div class="slideshow-container" id="slideshowContainer">
                        @foreach($peminjamanAktif as $index => $peminjam)
                        <div class="slide-card @if($index === 0) active @endif" id="slide-{{ $index }}" data-index="{{ $index }}">
                            <div class="row g-4">
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
                                        <div class="kondisi-badge mt-3">
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
                                    <div class="item-details-wrapper">
                                        {{-- Header dengan status --}}
                                        <div class="d-flex justify-content-between align-items-start mb-4">
                                            <div>
                                                <span class="badge bg-warning-subtle text-warning fs-7 px-3 py-2 mb-2">
                                                    <i class="fas fa-clock me-1"></i>
                                                    SEDANG DIPINJAM
                                                </span>
                                                <h4 class="fw-bold mb-1">{{ $peminjam->barang->nama_barang ?? 'N/A' }}</h4>
                                                <p class="text-muted fs-7 mb-0">
                                                    <i class="fas fa-barcode me-1"></i>
                                                    {{ $peminjam->barang->kode_barang ?? 'N/A' }}
                                                </p>
                                            </div>
                                            <div class="text-end">
                                                <div class="bg-light rounded-circle p-3 d-inline-flex">
                                                    <i class="fas fa-cube fa-lg text-primary"></i>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Info Peminjaman Grid --}}
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="info-card">
                                                    <div class="info-icon">
                                                        <i class="fas fa-user text-primary"></i>
                                                    </div>
                                                    <div class="info-content">
                                                        <p class="text-muted fs-8 mb-1">PEMINJAM</p>
                                                        <p class="fw-semibold mb-0">{{ $peminjam->nama_peminjam }}</p>
                                                        @if($peminjam->kelas)
                                                        <p class="text-muted fs-8 mt-1">Bagian: {{ $peminjam->kelas }}</p>
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
                                                        <p class="fw-semibold mb-0">
                                                            {{ \Carbon\Carbon::parse($peminjam->tanggal_pinjam)->isoFormat('DD MMMM YYYY') }}
                                                        </p>
                                                        <p class="text-muted fs-8 mt-1">
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
                        @endforeach
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
    </div>
</div>

{{-- ================= STYLE ================= --}}
<style>
/* Pastikan FontAwesome terload */
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css');

.inventory-card {
    background: #ffffff;
    border-radius: 20px;
    padding: 22px;
    height: 100%;
    box-shadow: 0 8px 22px rgba(0,0,0,.06);
    border: 1px solid #eef0f4;
    transition: transform 0.2s;
    margin-bottom: 0; /* Remove bottom margin */
}

.inventory-card:hover {
    transform: translateY(-2px);
}

.inventory-card h6 {
    font-size: 14px;
    font-weight: 600;
    color: #6b7280;
    margin-bottom: 8px;
}

.inventory-card h2 {
    font-size: 36px;
    font-weight: 700;
    margin: 6px 0 10px;
    color: #111827;
    line-height: 1.2;
}

.progress {
    height: 8px;
    background: #e5e7eb;
    border-radius: 6px;
    margin-top: 15px;
}

.progress-bar {
    border-radius: 6px;
}

/* Slideshow Card dengan margin atas lebih besar */
.slideshow-card {
    background: #ffffff;
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 8px 22px rgba(0,0,0,.06);
    border: 1px solid #eef0f4;
    position: relative;
    margin-top: 30px; /* Tambahkan margin atas */
}

/* Perbaikan CSS untuk slideshow yang lebih smooth */
.slideshow-container {
    min-height: 400px;
    position: relative;
    overflow: hidden;
}

.slide-card {
    position: absolute;
    width: 100%;
    top: 0;
    left: 0;
    opacity: 0;
    transform: translateX(100%);
    transition: opacity 0.5s ease, transform 0.5s ease;
    pointer-events: none;
    z-index: 1;
}

.slide-card.active {
    opacity: 1;
    transform: translateX(0);
    position: relative;
    pointer-events: all;
    z-index: 2;
}

/* Kontrol slideshow - perbaikan visibility */
.slideshow-controls {
    display: flex;
    align-items: center;
    gap: 10px;
    background: white;
    padding: 8px 12px;
    border-radius: 12px;
    border: 1px solid #eef0f4;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.slideshow-controls .btn-light {
    border: 1px solid #dee2e6;
    width: 36px;
    height: 36px;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    border-radius: 8px !important;
    transition: all 0.2s !important;
    background-color: white !important;
    color: #6b7280 !important;
    font-size: 14px !important;
}

.slideshow-controls .btn-light:hover {
    background: #4f46e5 !important;
    color: white !important;
    border-color: #4f46e5 !important;
    transform: translateY(-1px) !important;
}

.slideshow-controls .btn-light:active {
    transform: translateY(0) !important;
}

.slideshow-controls .btn-light i {
    font-size: 14px;
    display: block !important;
    line-height: 1;
}

/* Counter styles */
.slideshow-controls .text-muted {
    font-size: 14px;
    font-weight: 500;
    color: #6b7280;
    min-width: 40px;
    text-align: center;
}

/* Item photo */
.item-photo-wrapper {
    border-radius: 16px;
    overflow: hidden;
    background: #f8f9fa;
    padding: 15px;
    margin-bottom: 15px;
}

.item-photo {
    width: 100%;
    height: 250px;
    object-fit: cover;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.no-photo-placeholder {
    height: 250px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 12px;
    padding: 20px;
}

.no-photo-icon {
    color: #adb5bd;
}

.item-details-wrapper {
    padding: 10px 0;
}

.info-card {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 16px;
    display: flex;
    align-items: flex-start;
    gap: 12px;
    height: 100%;
    margin-bottom: 12px;
}

.info-icon {
    background: white;
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.info-content {
    flex: 1;
}

.slideshow-dots {
    display: flex;
    justify-content: center;
    gap: 8px;
    margin-top: 20px;
    padding-top: 20px;
    border-top: 1px solid #eef0f4;
}

.dot-btn {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    border: none;
    background: #dee2e6;
    padding: 0;
    cursor: pointer;
    transition: all 0.3s;
}

.dot-btn.active {
    background: #4f46e5;
    transform: scale(1.2);
}

.dot-btn:hover:not(.active) {
    background: #adb5bd;
}

.empty-state {
    min-height: 300px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 40px 20px;
}

.kondisi-badge {
    text-align: center;
}

/* Chart card */
.chart-card {
    background: #ffffff;
    border-radius: 20px;
    padding: 24px;
    box-shadow: 0 8px 22px rgba(0,0,0,.06);
    border: 1px solid #eef0f4;
    margin-top: 30px;
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

.badge {
    font-weight: 500;
    display: inline-flex;
    align-items: center;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .inventory-card {
        padding: 18px;
        margin-bottom: 15px;
    }
    
    .inventory-card h2 {
        font-size: 28px;
    }
    
    .slideshow-card {
        padding: 20px;
        margin-top: 20px;
    }
    
    .slideshow-controls {
        padding: 6px 10px;
    }
    
    .slideshow-controls .btn-light {
        width: 32px;
        height: 32px;
    }
}

/* Animation for slideshow */
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideInFromRight {
    from { transform: translateX(100%); opacity: 0; }
    to { transform: translateX(0); opacity: 1; }
}

@keyframes slideInFromLeft {
    from { transform: translateX(-100%); opacity: 0; }
    to { transform: translateX(0); opacity: 1; }
}

.slide-in-right {
    animation: slideInFromRight 0.5s ease forwards;
}

.slide-in-left {
    animation: slideInFromLeft 0.5s ease forwards;
}

.fade-in {
    animation: fadeIn 0.5s ease forwards;
}

/* Status autoplay */
.autoplay-active .btn-light#pausePlayBtn {
    background: #4f46e5 !important;
    color: white !important;
    border-color: #4f46e5 !important;
}
</style>

{{-- ================= SCRIPT ================= --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// Pastikan DOM sudah sepenuhnya loaded
document.addEventListener('DOMContentLoaded', function() {
    // Inisialisasi slideshow
    initSlideshow();
    
    // Inisialisasi chart jika ada
    initChart();
});

// Slideshow Functionality
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
    let autoPlayInterval;
    const slideDuration = 8000; // 8 seconds
    
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
            prevSlide();
            // Reset autoplay
            resetAutoPlay();
        });
    }
    
    if (nextBtn) {
        nextBtn.addEventListener('click', () => {
            nextSlide();
            // Reset autoplay
            resetAutoPlay();
        });
    }
    
    if (pausePlayBtn && pausePlayIcon) {
        pausePlayBtn.addEventListener('click', togglePlayPause);
    }
    
    // Dot navigation
    dots.forEach(dot => {
        dot.addEventListener('click', (e) => {
            const index = parseInt(e.currentTarget.dataset.index);
            if (index !== currentIndex) {
                goToSlide(index);
                // Reset autoplay
                resetAutoPlay();
            }
        });
    });
    
    // Keyboard navigation
    document.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowLeft') {
            e.preventDefault();
            prevSlide();
            resetAutoPlay();
        }
        if (e.key === 'ArrowRight') {
            e.preventDefault();
            nextSlide();
            resetAutoPlay();
        }
        if (e.key === ' ' || e.key === 'Spacebar') {
            e.preventDefault();
            togglePlayPause();
        }
    });
    
    function showSlide(index, direction = 'next') {
        // Remove active classes from all slides
        slides.forEach(slide => {
            slide.classList.remove('active', 'prev', 'next', 'slide-in-right', 'slide-in-left', 'fade-in');
        });
        
        // Update dots
        dots.forEach(dot => dot.classList.remove('active'));
        
        // Update current index
        currentIndex = index;
        
        // Add active class to current slide with animation
        const currentSlide = slides[currentIndex];
        if (currentSlide) {
            currentSlide.classList.add('active');
            
            // Add animation class based on direction
            if (direction === 'next') {
                currentSlide.classList.add('slide-in-right');
            } else if (direction === 'prev') {
                currentSlide.classList.add('slide-in-left');
            } else {
                currentSlide.classList.add('fade-in');
            }
            
            // Remove animation class after animation completes
            setTimeout(() => {
                currentSlide.classList.remove('slide-in-right', 'slide-in-left', 'fade-in');
            }, 500);
        }
        
        // Update current dot
        if (dots[currentIndex]) {
            dots[currentIndex].classList.add('active');
        }
        
        // Update counter
        if (currentSlideEl) {
            currentSlideEl.textContent = currentIndex + 1;
        }
    }
    
    function nextSlide() {
        const nextIndex = (currentIndex + 1) % slides.length;
        const direction = 'next';
        showSlide(nextIndex, direction);
    }
    
    function prevSlide() {
        const prevIndex = (currentIndex - 1 + slides.length) % slides.length;
        const direction = 'prev';
        showSlide(prevIndex, direction);
    }
    
    function goToSlide(index) {
        if (index === currentIndex) return;
        
        const direction = index > currentIndex ? 'next' : 'prev';
        showSlide(index, direction);
    }
    
    function startAutoPlay() {
        if (slides.length <= 1) return;
        
        autoPlayInterval = setInterval(() => {
            nextSlide();
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
    
    // Update button states for single slide
    function updateButtonStates() {
        const hasMultipleSlides = slides.length > 1;
        
        if (prevBtn) prevBtn.disabled = !hasMultipleSlides;
        if (nextBtn) nextBtn.disabled = !hasMultipleSlides;
        if (pausePlayBtn) pausePlayBtn.disabled = !hasMultipleSlides;
        
        // Visual feedback for disabled state
        if (!hasMultipleSlides) {
            [prevBtn, nextBtn, pausePlayBtn].forEach(btn => {
                if (btn) {
                    btn.style.opacity = '0.5';
                    btn.style.cursor = 'not-allowed';
                }
            });
        }
    }
    
    updateButtonStates();
}

// Chart initialization
function initChart() {
    const ctx = document.getElementById('barangChart');
    if (!ctx) return;
    
    try {
        // Pastikan dataBarang ada
        const dataBarang = @json($dataBarang ?? []);
        
        // Jika dataBarang adalah object, konversi ke array
        let labels = [];
        let tersediaData = [];
        let dipinjamData = [];
        let rusakData = [];
        
        if (typeof dataBarang === 'object' && dataBarang !== null) {
            labels = Object.keys(dataBarang);
            tersediaData = labels.map(label => dataBarang[label]?.tersedia || 0);
            dipinjamData = labels.map(label => dataBarang[label]?.dipinjam || 0);
            rusakData = labels.map(label => dataBarang[label]?.rusak || 0);
        }
        
        // Hanya buat chart jika ada data
        if (labels.length > 0) {
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Tersedia',
                            data: tersediaData,
                            backgroundColor: '#10b981',
                            borderRadius: 6
                        },
                        {
                            label: 'Dipinjam',
                            data: dipinjamData,
                            backgroundColor: '#f59e0b',
                            borderRadius: 6
                        },
                        {
                            label: 'Rusak',
                            data: rusakData,
                            backgroundColor: '#ef4444',
                            borderRadius: 6
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    label += context.parsed.y + ' barang';
                                    return label;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                                callback: function(value) {
                                    return Number.isInteger(value) ? value : '';
                                }
                            },
                            grid: {
                                drawBorder: false
                            },
                            title: {
                                display: true,
                                text: 'Jumlah Barang'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            title: {
                                display: true,
                                text: 'Kondisi Barang'
                            }
                        }
                    }
                }
            });
        }
    } catch (error) {
        console.error('Error initializing chart:', error);
    }
}
</script>

@endsection