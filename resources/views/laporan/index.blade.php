@extends('layouts.perpustakaan')

@section('judul', 'Laporan Perpustakaan')

@section('konten')

    <h2 class="judul-halaman">Laporan Perpustakaan</h2>
    <p class="sub-halaman">Ringkasan koleksi, anggota, dan peminjaman.</p>

    <div class="grid-ringkas">
        @foreach ($ringkasan as $label => $nilai)
            <div class="kartu-angka">
                <span class="label">{{ $label }}</span>
                <span class="nilai">{{ $nilai }}</span>
            </div>
        @endforeach
    </div>

    <div class="kartu">
        <h3>Buku Paling Sering Dipinjam</h3>
        <div class="bungkus-tabel">
            <table class="tabel-data">
                <thead><tr><th>Peringkat</th><th>Judul</th><th>Jumlah dipinjam</th></tr></thead>
                <tbody>
                    @foreach ($populer as $i => $b)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $b->judul }}</td>
                            <td>{{ $b->peminjamans_count }} kali</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="kartu">
        <h3>10 Peminjaman Terbaru</h3>
        <div class="bungkus-tabel">
            <table class="tabel-data">
                <thead><tr><th>Peminjam</th><th>Buku</th><th>Tanggal</th><th>Status</th></tr></thead>
                <tbody>
                    @foreach ($terbaru as $p)
                        <tr>
                            <td>{{ $p->anggota->nama }}</td>
                            <td>{{ $p->buku->judul }}</td>
                            <td>{{ $p->tanggal_pinjam }}</td>
                            <td><span class="lencana lencana-{{ $p->status }}">{{ ucfirst($p->status) }}</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection