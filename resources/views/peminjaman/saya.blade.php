@extends('layouts.perpustakaan')

@section('judul', 'Peminjaman Saya')

@section('konten')

    <h2 class="judul-halaman">Peminjaman Saya</h2>
    <p class="sub-halaman">Ajukan peminjaman dan pantau status serta riwayat peminjaman milik Anda.</p>

    <x-flash />

    @can('mengajukan peminjaman buku')
        <div class="kartu">
            <h3>Ajukan Peminjaman</h3>
            <form method="POST" action="{{ route('peminjaman-saya.store') }}" class="aksi-baris"
                    data-konfirmasi="Ajukan peminjaman untuk buku yang dipilih?">
                @csrf
                <select name="buku_id" class="kontrol kontrol-lebar" required>
                    <option value="">-- Pilih buku --</option>
                    @foreach ($bukus as $b)
                        <option value="{{ $b->id }}">{{ $b->judul }} ({{ $b->penulis }})</option>
                    @endforeach
                </select>
                <button class="tombol">Ajukan Peminjaman</button>
            </form>
        </div>
    @endcan

    @can('melihat status peminjaman sendiri')
        <div class="kartu">
            <h3>Status Peminjaman</h3>
            <div class="bungkus-tabel">
                <table class="tabel-data">
                    <thead>
                        <tr><th>Buku</th><th>Tanggal</th><th>Status</th><th>Detail</th></tr>
                    </thead>
                    <tbody>
                        @forelse ($aktif as $p)
                            <tr>
                                <td>{{ $p->buku->judul }}</td>
                                <td>{{ $p->tanggal_pinjam }}</td>
                                <td><span class="lencana lencana-{{ $p->status }}">{{ ucfirst($p->status) }}</span></td>
                                <td><a class="tombol tombol-kecil tombol-biru" href="{{ route('peminjaman-saya.show', $p) }}">Lihat</a></td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="tabel-kosong">Tidak ada peminjaman aktif.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endcan

    @can('melihat riwayat peminjaman sendiri')
        <div class="kartu">
            <h3>Riwayat Peminjaman</h3>
            <div class="bungkus-tabel">
                <table class="tabel-data">
                    <thead>
                        <tr><th>Buku</th><th>Dipinjam</th><th>Dikembalikan</th><th>Status</th><th>Detail</th></tr>
                    </thead>
                    <tbody>
                        @forelse ($riwayat as $p)
                            <tr>
                                <td>{{ $p->buku->judul }}</td>
                                <td>{{ $p->tanggal_pinjam }}</td>
                                <td>{{ $p->tanggal_kembali ?? '-' }}</td>
                                <td><span class="lencana lencana-{{ $p->status }}">{{ ucfirst($p->status) }}</span></td>
                                <td><a class="tombol tombol-kecil tombol-biru" href="{{ route('peminjaman-saya.show', $p) }}">Lihat</a></td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="tabel-kosong">Belum ada riwayat.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endcan

@endsection