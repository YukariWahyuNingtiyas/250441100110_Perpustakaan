<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PeminjamanSayaController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Halaman publik (Modul 1)
Route::get('/', function () {
    return view('home');
})->name('home');

// Semua rute di bawah ini wajib login (middleware auth)
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])
        ->middleware('permission:akses dashboard admin')
        ->name('admin.dashboard');

    Route::get('/petugas/dashboard', [DashboardController::class, 'petugas'])
        ->middleware('permission:akses dashboard petugas')
        ->name('petugas.dashboard');

    // Buku: daftar
    Route::get('/buku', [BukuController::class, 'index'])
        ->middleware('permission:lihat daftar buku')
        ->name('buku.index');

    // Buku: tambah, ubah, hapus (Gate kelola-buku), HARUS di atas /buku/{id}
    Route::middleware('can:kelola-buku')->group(function () {
        Route::get('/buku/create', [BukuController::class, 'create'])->name('buku.create');
        Route::post('/buku', [BukuController::class, 'store'])->name('buku.store');
        Route::get('/buku/{buku}/edit', [BukuController::class, 'edit'])->name('buku.edit');
        Route::put('/buku/{buku}', [BukuController::class, 'update'])->name('buku.update');
        Route::delete('/buku/{buku}', [BukuController::class, 'destroy'])->name('buku.destroy');
    });

    // Buku: detail
    Route::get('/buku/{id}', [BukuController::class, 'detail'])
        ->middleware('permission:lihat daftar buku')
        ->name('buku.detail');

    // Pencarian buku (query binding) dan detail peminjaman (Policy, Soal 4)
    Route::get('/buku-cari', [BukuController::class, 'cari']);
    Route::get('/peminjaman/{id}', [PeminjamanController::class, 'show']);

    // Profil milik sendiri (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->middleware('permission:lihat profil sendiri')->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->middleware('permission:ubah profil sendiri')->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->middleware('permission:ubah profil sendiri')->name('profile.destroy');

    // Peminjaman milik sendiri (semua role)
    Route::get('/peminjaman-saya', [PeminjamanSayaController::class, 'index'])
        ->middleware('permission:melihat status peminjaman sendiri|melihat riwayat peminjaman sendiri')
        ->name('peminjaman-saya.index');
    Route::post('/peminjaman-saya', [PeminjamanSayaController::class, 'store'])
        ->middleware('permission:mengajukan peminjaman buku')
        ->name('peminjaman-saya.store');
    Route::get('/peminjaman-saya/{peminjaman}', [PeminjamanSayaController::class, 'show'])
        ->middleware('permission:melihat riwayat peminjaman sendiri')
        ->name('peminjaman-saya.show');

    // Operasional perpustakaan (admin dan petugas)
    Route::get('/kelola/peminjaman', [PeminjamanController::class, 'index'])
        ->middleware('permission:kelola peminjaman')->name('kelola.peminjaman.index');
    Route::patch('/kelola/peminjaman/{peminjaman}/setujui', [PeminjamanController::class, 'setujui'])
        ->middleware('permission:memproses persetujuan peminjaman')->name('kelola.peminjaman.setujui');
    Route::patch('/kelola/peminjaman/{peminjaman}/tolak', [PeminjamanController::class, 'tolak'])
        ->middleware('permission:memproses persetujuan peminjaman')->name('kelola.peminjaman.tolak');

    Route::get('/kelola/pengembalian', [PengembalianController::class, 'index'])
        ->middleware('permission:kelola pengembalian')->name('kelola.pengembalian.index');
    Route::patch('/kelola/pengembalian/{peminjaman}', [PengembalianController::class, 'kembalikan'])
        ->middleware('permission:mencatat pengembalian buku')->name('kelola.pengembalian.kembalikan');

    Route::get('/laporan', [LaporanController::class, 'index'])
        ->middleware('permission:lihat laporan perpustakaan')->name('laporan.index');

    // Pengelolaan akun dan role (khusus admin)
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/users', [UserController::class, 'index'])
            ->middleware('permission:kelola data pengguna')->name('users.index');
        Route::post('/users', [UserController::class, 'store'])
            ->middleware('permission:kelola data pengguna')->name('users.store');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])
            ->middleware('permission:kelola data pengguna')->name('users.destroy');
        Route::patch('/users/{user}/role', [UserController::class, 'updateRole'])
            ->middleware('permission:kelola role pengguna')->name('users.role');
    });
});

// Rute login, register, logout (middleware guest dan auth dari Breeze)
require __DIR__.'/auth.php';