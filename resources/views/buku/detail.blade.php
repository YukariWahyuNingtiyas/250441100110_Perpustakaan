@extends('layouts.perpustakaan')

@section('judul', 'Detail Buku')

@section('konten')

    <div class="detail-buku">

        @if ($buku)

            <div class="detail-card">

                <p class="label-detail">DETAIL BUKU</p>

                <h2>{{ $buku['judul'] }}</h2>

                <div class="info-buku">
                    <p>
                        <strong>Penulis</strong>
                        <span>{{ $buku['penulis'] }}</span>
                    </p>

                    <p>
                        <strong>Tahun Terbit</strong>
                        <span>{{ $buku['tahun'] }}</span>
                    </p>

                    <p>
                        <strong>Kategori</strong>
                        <span>{{ $buku['kategori'] }}</span>
                    </p>
                </div>

                <a class="tombol-kembali" href="{{ route('buku.index') }}">
                    Kembali ke Daftar Buku
                </a>

            </div>

        @else

            <div class="detail-card">
                <h2>Buku Tidak Ditemukan</h2>

                <p>Data buku yang Anda cari tidak tersedia.</p>

                <a class="tombol-kembali" href="{{ route('buku.index') }}">
                    Kembali ke Daftar Buku
                </a>
            </div>

        @endif

    </div>

@endsection