<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PeminjamanSayaController extends Controller
{
    public function index(Request $request)
    {
        // Hanya data milik anggota yang terhubung ke akun yang sedang login
        $anggota = $request->user()->anggotaSaya();

        $dasar = Peminjaman::with('buku')->where('anggota_id', $anggota->id);

        return view('peminjaman.saya', [
            'aktif'   => (clone $dasar)->whereIn('status', ['diajukan', 'dipinjam'])->latest('id')->get(),
            'riwayat' => (clone $dasar)->whereIn('status', ['dikembalikan', 'ditolak'])->latest('id')->get(),
            'bukus'   => Buku::orderBy('judul')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'buku_id' => ['required', 'exists:bukus,id'],
        ], [
            'buku_id.required' => 'Pilih buku yang ingin dipinjam.',
            'buku_id.exists'   => 'Buku yang dipilih tidak valid.',
        ]);

        // anggota_id diambil dari akun yang login, bukan dari input formulir
        $anggota = $request->user()->anggotaSaya();

        $sudah = Peminjaman::where('anggota_id', $anggota->id)
            ->where('buku_id', $data['buku_id'])
            ->whereIn('status', ['diajukan', 'dipinjam'])
            ->exists();

        if ($sudah) {
            return back()->withErrors(['buku_id' => 'Anda sudah mengajukan atau sedang meminjam buku ini.']);
        }

        Peminjaman::create([
            'anggota_id'     => $anggota->id,
            'buku_id'        => $data['buku_id'],
            'tanggal_pinjam' => now()->toDateString(),
            'status'         => 'diajukan',
        ]);

        return back()->with('status', 'Pengajuan peminjaman berhasil dikirim.');
    }

    public function show(Request $request, Peminjaman $peminjaman)
    {
        $peminjaman->load(['buku.kategori', 'anggota']);

        $pemilik = $peminjaman->anggota?->user_id === $request->user()->id;

        // Boleh jika miliknya sendiri, atau petugas/admin yang berhak mengelola peminjaman
        abort_unless($pemilik || $request->user()->can('kelola peminjaman'), 403);

        return view('peminjaman.detail', compact('peminjaman'));
    }
}