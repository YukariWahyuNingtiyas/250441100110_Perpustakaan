<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // /dashboard: arahkan sesuai hak akses pengguna
    public function index(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->can('akses dashboard admin')) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->can('akses dashboard petugas')) {
            return redirect()->route('petugas.dashboard');
        }

        return redirect()->route('buku.index');   // siswa
    }

    public function admin()
    {
        return view('admin.dashboard', [
            'totalBuku'    => Buku::count(),
            'totalAdmin'   => User::role('admin')->count(),
            'totalPetugas' => User::role('petugas')->count(),
            'totalSiswa'   => User::role('siswa')->count(),
            'diajukan'     => Peminjaman::where('status', 'diajukan')->count(),
            'dipinjam'     => Peminjaman::where('status', 'dipinjam')->count(),
        ]);
    }

    public function petugas()
    {
        return view('petugas.dashboard', [
            'totalBuku' => Buku::count(),
            'diajukan'  => Peminjaman::where('status', 'diajukan')->count(),
            'dipinjam'  => Peminjaman::where('status', 'dipinjam')->count(),
        ]);
    }
}