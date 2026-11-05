@extends('layouts.perpustakaan')

@section('judul', 'Kelola Peminjaman')

@section('konten')

    <h2 class="judul-halaman">Kelola Peminjaman</h2>
    <p class="sub-halaman">Setujui atau tolak pengajuan peminjaman buku.</p>

    <x-flash />

    <div class="bungkus-tabel">
        <table class="tabel-data">
            <thead>
                <tr>
                    <th>ID</th><th>Peminjam</th><th>Buku</th><th>Tanggal</th><th>Status</th><th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($peminjamans as $p)
                    <tr>
                        <td>{{ $p->id }}</td>
                        <td>{{ $p->anggota->nama }}</td>
                        <td>{{ $p->buku->judul }}</td>
                        <td>{{ $p->tanggal_pinjam }}</td>
                        <td><span class="lencana lencana-{{ $p->status }}">{{ ucfirst($p->status) }}</span></td>
                        <td>
                            <div class="aksi-baris">
                                @can('memproses persetujuan peminjaman')
                                    @if ($p->status === 'diajukan')
                                        <form method="POST" action="{{ route('kelola.peminjaman.setujui', $p) }}" class="sebaris"
                                                data-konfirmasi="Setujui peminjaman buku {{ $p->buku->judul }} oleh {{ $p->anggota->nama }}?">
                                            @csrf @method('PATCH')
                                            <button class="tombol tombol-kecil tombol-hijau">Setujui</button>
                                        </form>
                                        <form method="POST" action="{{ route('kelola.peminjaman.tolak', $p) }}" class="sebaris"
                                                data-konfirmasi="Tolak pengajuan buku {{ $p->buku->judul }} oleh {{ $p->anggota->nama }}?">
                                            @csrf @method('PATCH')
                                            <button class="tombol tombol-kecil tombol-merah">Tolak</button>
                                        </form>
                                    @endif
                                @endcan
                                <a class="tombol tombol-kecil tombol-biru" href="{{ route('peminjaman-saya.show', $p) }}">Detail</a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="tabel-kosong">Belum ada data peminjaman.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection