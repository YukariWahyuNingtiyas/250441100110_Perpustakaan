<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Support\Facades\Gate;

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

    // SOAL 4 (A4): DITAMBAL. Kepemilikan diperiksa oleh PeminjamanPolicy
    public function show($id)
    {
        $peminjaman = Peminjaman::with(['buku.kategori', 'anggota'])->findOrFail($id);

        Gate::authorize('view', $peminjaman);

        return view('peminjaman.detail', compact('peminjaman'));
    }
}