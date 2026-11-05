<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::with(['anggota', 'buku'])->latest('id')->get();

        return view('peminjaman.kelola', compact('peminjamans'));
    }

    public function setujui(Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'diajukan') {
            return back()->withErrors(['status' => 'Hanya pengajuan yang dapat disetujui.']);
        }

        $peminjaman->update([
            'status'         => 'dipinjam',
            'tanggal_pinjam' => now()->toDateString(),
        ]);

        return back()->with('status', 'Peminjaman disetujui.');
    }

    public function tolak(Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'diajukan') {
            return back()->withErrors(['status' => 'Hanya pengajuan yang dapat ditolak.']);
        }

        $peminjaman->update(['status' => 'ditolak']);

        return back()->with('status', 'Peminjaman ditolak.');
    }

    // SOAL 1 (A4): RENTAN. Tanpa pemeriksaan pemilik
    public function show($id)
    {
        $peminjaman = Peminjaman::with(['buku.kategori', 'anggota'])->findOrFail($id);

        return view('peminjaman.detail', compact('peminjaman'));
    }
}