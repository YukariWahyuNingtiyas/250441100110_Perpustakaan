<?php

use App\Http\Controllers\Api\BukuController;
use Illuminate\Support\Facades\Route;

// Grup 'web' memberi session dan CSRF, 'auth' memastikan sudah login,
// lalu permission Spatie membatasi per aksi.
Route::middleware(['web', 'auth'])->group(function () {

    Route::apiResource('buku', BukuController::class)
        ->only(['index', 'show'])
        ->middleware('permission:lihat daftar buku')
        ->names('api.buku');

    Route::apiResource('buku', BukuController::class)
        ->only(['store', 'update', 'destroy'])
        ->middleware('permission:kelola data buku')
        ->names('api.buku');
});