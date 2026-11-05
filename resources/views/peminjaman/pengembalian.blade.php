@extends('layouts.perpustakaan')

@section('judul', 'Kelola Pengembalian')

@section('konten')

    <h2 class="judul-halaman">Kelola Pengembalian</h2>
    <p class="sub-halaman">Catat pengembalian buku yang sedang dipinjam.</p>

    <x-flash />

    <div class="kartu">
        <h3>Sedang Dipinjam</h3>
        <div class="bungkus-tabel">
            <table class="tabel-data">
                <thead>
                    <tr><th>ID</th><th>Peminjam</th><th>Buku</th><th>Tanggal pinjam</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    @forelse ($dipinjam as $p)
                        <tr>
                            <td>{{ $p->id }}</td>
                            <td>{{ $p->anggota->nama }}</td>
                            <td>{{ $p->buku->judul }}</td>
                            <td>{{ $p->tanggal_pinjam }}</td>
                            <td>
                                @can('mencatat pengembalian buku')
                                    <form method="POST" action="{{ route('kelola.pengembalian.kembalikan', $p) }}" class="sebaris"
                                            data-konfirmasi="Catat pengembalian buku {{ $p->buku->judul }} dari {{ $p->anggota->nama }}?">
                                        <button class="tombol tombol-kecil">Catat Pengembalian</button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="tabel-kosong">Tidak ada buku yang sedang dipinjam.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="kartu">
        <h3>Pengembalian Terbaru</h3>
        <div class="bungkus-tabel">
            <table class="tabel-data">
                <thead>
                    <tr><th>Peminjam</th><th>Buku</th><th>Tanggal kembali</th></tr>
                </thead>
                <tbody>
                    @forelse ($selesai as $p)
                        <tr>
                            <td>{{ $p->anggota->nama }}</td>
                            <td>{{ $p->buku->judul }}</td>
                            <td>{{ $p->tanggal_kembali }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="tabel-kosong">Belum ada pengembalian.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection