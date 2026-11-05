@extends('layouts.perpustakaan')

@section('judul', 'Beranda')

@section('konten')
<x-flash />

    <section class="hero">
        <h2>Selamat Datang di Perpustakaan Digital</h2>
        <p>Lihat koleksi buku, ajukan peminjaman, dan pantau riwayat peminjaman Anda dalam satu tempat.</p>

        <div class="aksi-baris pusat">
            @auth
                @can('lihat daftar buku')
                    <a class="tombol tombol-besar" href="{{ route('buku.index') }}">Lihat Daftar Buku</a>
                @endcan
                <a class="tombol tombol-garis tombol-besar" href="{{ route('dashboard') }}">Ke Dashboard</a>
            @else
                <a class="tombol tombol-besar" href="{{ route('login') }}">Masuk</a>
                <a class="tombol tombol-garis tombol-besar" href="{{ route('register') }}">Daftar</a>
            @endauth
        </div>
    </section>

    <div class="grid-ringkas">
        <div class="kartu-angka">
            <span class="label">Koleksi</span>
            <span class="nilai" style="font-size:1.2rem">Katalog buku lengkap</span>
        </div>
        <div class="kartu-angka">
            <span class="label">Peminjaman</span>
            <span class="nilai" style="font-size:1.2rem">Ajukan secara online</span>
        </div>
        <div class="kartu-angka">
            <span class="label">Riwayat</span>
            <span class="nilai" style="font-size:1.2rem">Pantau milik sendiri</span>
        </div>
    </div>

@endsection