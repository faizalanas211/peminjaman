<?php

use Illuminate\Support\Facades\Route;

// =======================
// Auth Controller
// =======================
use App\Http\Controllers\AuthController;

// =======================
// App Controllers
// =======================
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KehadiranController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\FingerprintController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\BarangController;

/*
|--------------------------------------------------------------------------
| Guest Routes (BELUM LOGIN)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'loginAction'])->name('loginAction');

    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'registerAction'])->name('registerAction');
});

/*
|--------------------------------------------------------------------------
| Authenticated Dashboard Routes (SUDAH LOGIN)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->prefix('dashboard')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | 🔥 DASHBOARD UTAMA
    |--------------------------------------------------------------------------
    */
    Route::get('/', [DashboardController::class, 'index'])
        ->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Pegawai & Kehadiran
    |--------------------------------------------------------------------------
    */
    Route::resource('pegawai', PegawaiController::class);
    Route::resource('kehadiran', KehadiranController::class);

    Route::post('pegawai/import', [PegawaiController::class, 'import'])
        ->name('pegawai.import');
    Route::post('kehadiran/import', [KehadiranController::class, 'import'])
        ->name('kehadiran.import');

    /*
    |--------------------------------------------------------------------------
    | Pengajuan
    |--------------------------------------------------------------------------
    */
    Route::resource('pengajuan', PengajuanController::class);

    /*
    |--------------------------------------------------------------------------
    | Peminjaman
    |--------------------------------------------------------------------------
    */
    Route::resource('peminjaman', PeminjamanController::class);
    Route::put(
        'peminjaman/{peminjaman}/kembalikan',
        [PeminjamanController::class, 'kembalikan']
    )->name('peminjaman.kembalikan');

    /*
    |--------------------------------------------------------------------------
    | Barang
    |--------------------------------------------------------------------------
    */
    Route::resource('barang', BarangController::class);
    Route::post('barang/import', [BarangController::class, 'import'])
        ->name('barang.import');

    /*
    |--------------------------------------------------------------------------
    | Penilaian
    |--------------------------------------------------------------------------
    */
    Route::get('penilaian', [PenilaianController::class, 'index'])
        ->name('penilaian.index');

    Route::get('penilaian/create', [PenilaianController::class, 'create'])
        ->name('penilaian.create');

    Route::get('penilaian/create/{id}', [PenilaianController::class, 'createByPegawai'])
        ->name('penilaian.createByPegawai');

    Route::post('penilaian', [PenilaianController::class, 'store'])
        ->name('penilaian.store');

    Route::post('penilaian/import', [PenilaianController::class, 'import'])
        ->name('penilaian.import');

    Route::get('penilaian/{id}/edit', [PenilaianController::class, 'edit'])
        ->name('penilaian.edit');

    Route::put('penilaian/{id}', [PenilaianController::class, 'update'])
        ->name('penilaian.update');

    Route::delete('penilaian/{id}', [PenilaianController::class, 'destroy'])
        ->name('penilaian.destroy');

    /*
    |--------------------------------------------------------------------------
    | Fingerprint
    |--------------------------------------------------------------------------
    */
    Route::get('debug-fingerprint', [FingerprintController::class, 'debug'])
        ->name('debug-fingerprint');

    Route::get('test-fingerprint', [FingerprintController::class, 'testSimple'])
        ->name('test-fingerprint');

    Route::get('test-buffer', [FingerprintController::class, 'testBuffer'])
        ->name('test-buffer');

    Route::get('sync-kehadiran', [FingerprintController::class, 'sync'])
        ->name('sync-kehadiran');

    /*
    |--------------------------------------------------------------------------
    | Logout
    |--------------------------------------------------------------------------
    */
    Route::post('logout', [AuthController::class, 'logout'])
        ->name('logout');
});
