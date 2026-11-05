<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;

class PengembalianController extends Controller
{
    public function index()
    {
        return view('peminjaman.pengembalian', [
            'dipinjam' => Peminjaman::with(['anggota', 'buku'])->where('status', 'dipinjam')->latest('id')->get(),
            'selesai'  => Peminjaman::with(['anggota', 'buku'])->where('status', 'dikembalikan')->latest('id')->limit(10)->get(),
        ]);
    }

    public function kembalikan(Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'dipinjam') {
            return back()->withErrors(['status' => 'Hanya buku yang sedang dipinjam yang dapat dikembalikan.']);
        }

        $peminjaman->update([
            'status'          => 'dikembalikan',
            'tanggal_kembali' => now()->toDateString(),
        ]);

        return back()->with('status', 'Pengembalian buku berhasil dicatat.');
    }
}