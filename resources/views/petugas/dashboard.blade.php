@extends('layouts.perpustakaan')

@section('judul', 'Dashboard Petugas')

@section('konten')

    <h2 class="judul-halaman">Dashboard Petugas</h2>
    <p class="sub-halaman">Operasional peminjaman dan pengembalian buku.</p>

    <x-flash />

    <div class="kartu">
        <h3>Selamat datang, {{ auth()->user()->name }}</h3>

        @role('petugas')
            <p>Anda masuk sebagai <strong>Petugas</strong>: mengelola buku, peminjaman, dan pengembalian. Pengelolaan akun dan role tidak tersedia untuk Petugas.</p>
        @endrole
    </div>

    <div class="grid-ringkas">
        @foreach (['Total buku' => $totalBuku, 'Menunggu persetujuan' => $diajukan, 'Sedang dipinjam' => $dipinjam] as $label => $nilai)
            <div class="kartu-angka">
                <span class="label">{{ $label }}</span>
                <span class="nilai">{{ $nilai }}</span>
            </div>
        @endforeach
    </div>

    <div class="kartu">
        <h3>Menu Cepat</h3>
        <div class="aksi-baris">
            @can('kelola data buku')
                <a class="tombol" href="{{ route('buku.index') }}">Kelola Buku</a>
            @endcan
            @can('kelola peminjaman')
                <a class="tombol" href="{{ route('kelola.peminjaman.index') }}">Kelola Peminjaman</a>
            @endcan
            @can('kelola pengembalian')
                <a class="tombol" href="{{ route('kelola.pengembalian.index') }}">Kelola Pengembalian</a>
            @endcan
            @can('lihat laporan perpustakaan')
                <a class="tombol" href="{{ route('laporan.index') }}">Lihat Laporan</a>
            @endcan
        </div>
    </div>

@endsection