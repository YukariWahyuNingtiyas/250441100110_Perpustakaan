@extends('layouts.perpustakaan')

@section('judul', 'Dashboard Admin')

@section('konten')

    <h2 class="judul-halaman">Dashboard Admin</h2>
    <p class="sub-halaman">Ringkasan data perpustakaan dan akses pengelolaan.</p>

    <x-flash />

    <div class="kartu">
        <h3>Selamat datang, {{ auth()->user()->name }}</h3>

        @role('admin')
            <p>Anda masuk sebagai <strong>Admin</strong> dan dapat mengelola seluruh kebutuhan administrasi perpustakaan.</p>
        @endrole

        @can('kelola data pengguna')
            <div class="pesan pesan-sukses">Anda memiliki hak akses untuk <strong>kelola data pengguna</strong>.</div>
        @endcan
    </div>

    <div class="grid-ringkas">
        @foreach ([
            'Total buku' => $totalBuku,
            'Admin' => $totalAdmin,
            'Petugas' => $totalPetugas,
            'Siswa' => $totalSiswa,
            'Menunggu persetujuan' => $diajukan,
            'Sedang dipinjam' => $dipinjam,
        ] as $label => $nilai)
            <div class="kartu-angka">
                <span class="label">{{ $label }}</span>
                <span class="nilai">{{ $nilai }}</span>
            </div>
        @endforeach
    </div>

    <div class="kartu">
        <h3>Menu Cepat</h3>
        <div class="aksi-baris">
            @can('kelola data pengguna')
                <a class="tombol" href="{{ route('admin.users.index') }}">Kelola Pengguna</a>
            @endcan
            @can('kelola data buku')
                <a class="tombol" href="{{ route('buku.index') }}">Kelola Buku</a>
            @endcan
            @can('kelola peminjaman')
                <a class="tombol" href="{{ route('kelola.peminjaman.index') }}">Peminjaman</a>
            @endcan
            @can('kelola pengembalian')
                <a class="tombol" href="{{ route('kelola.pengembalian.index') }}">Pengembalian</a>
            @endcan
            @can('lihat laporan perpustakaan')
                <a class="tombol" href="{{ route('laporan.index') }}">Laporan</a>
            @endcan
        </div>
    </div>

@endsection