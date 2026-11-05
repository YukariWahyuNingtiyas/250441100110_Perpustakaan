<?php

use App\Http\Controllers\Api\BukuController;
use Illuminate\Support\Facades\Route;

// Grup 'web' memberi session dan CSRF, 'auth' memastikan sudah login.
// Membaca: permission Spatie. Menulis (tambah, ubah, hapus): Gate kelola-buku.
Route::middleware(['web', 'auth'])->group(function () {

    Route::apiResource('buku', BukuController::class)
        ->only(['index', 'show'])
        ->middleware('permission:lihat daftar buku')
        ->names('api.buku');

    Route::apiResource('buku', BukuController::class)
        ->only(['store', 'update', 'destroy'])
        ->middleware('can:kelola-buku')
        ->names('api.buku');
});