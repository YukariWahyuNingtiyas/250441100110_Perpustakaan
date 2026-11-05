<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;

class LaporanController extends Controller
{
    public function index()
    {
        return view('laporan.index', [
            'ringkasan' => [
                'Total buku'           => Buku::count(),
                'Total anggota'        => Anggota::count(),
                'Total peminjaman'     => Peminjaman::count(),
                'Menunggu persetujuan' => Peminjaman::where('status', 'diajukan')->count(),
                'Sedang dipinjam'      => Peminjaman::where('status', 'dipinjam')->count(),
                'Sudah dikembalikan'   => Peminjaman::where('status', 'dikembalikan')->count(),
            ],
            'populer' => Buku::withCount('peminjamans')->orderByDesc('peminjamans_count')->limit(5)->get(),
            'terbaru' => Peminjaman::with(['anggota', 'buku'])->latest('id')->limit(10)->get(),
        ]);
    }
}