@extends('layouts.perpustakaan')

@section('judul', '403 - Akses Ditolak')

@section('konten')
    <div style="text-align:center; padding: 60px 20px;">
        <h1 style="font-size: 32px; margin-bottom: 12px;">403 - AKSES DITOLAK</h1>
        <p style="font-size: 16px; opacity: .85;">
            Akun kamu tidak memiliki hak akses untuk membuka halaman atau data ini.
        </p>
        <a href="{{ route('buku.index') }}" class="tombol tombol-abu" style="margin-top:20px; display:inline-block;">
            Kembali ke Daftar Buku
        </a>
    </div>
@endsection