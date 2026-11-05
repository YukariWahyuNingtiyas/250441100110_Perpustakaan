@extends('layouts.perpustakaan')

@section('judul', 'Detail Peminjaman')

@section('konten')

    <div class="detail-buku">
        <div class="detail-card">
            <p class="label-detail">DETAIL PEMINJAMAN #{{ $peminjaman->id }}</p>
            <h2>{{ $peminjaman->buku->judul }}</h2>

            <div class="info-buku">
                <p><strong>Peminjam</strong><span>{{ $peminjaman->anggota->nama }}</span></p>
                <p><strong>Kategori</strong><span>{{ $peminjaman->buku->kategori->nama }}</span></p>
                <p><strong>Tanggal pinjam</strong><span>{{ $peminjaman->tanggal_pinjam }}</span></p>
                <p><strong>Tanggal kembali</strong><span>{{ $peminjaman->tanggal_kembali ?? '-' }}</span></p>
                <p><strong>Status</strong><span class="lencana lencana-{{ $peminjaman->status }}">{{ ucfirst($peminjaman->status) }}</span></p>
            </div>

            @can('kelola peminjaman')
                <a class="tombol-kembali" href="{{ route('kelola.peminjaman.index') }}">Kembali</a>
            @else
                <a class="tombol-kembali" href="{{ route('peminjaman-saya.index') }}">Kembali</a>
            @endcan
        </div>
    </div>

@endsection