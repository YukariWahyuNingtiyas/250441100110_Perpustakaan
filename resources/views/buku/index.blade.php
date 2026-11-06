@extends('layouts.perpustakaan')

@section('judul', 'Daftar Buku')

@section('konten')

    <h2 class="judul-halaman">Daftar Buku</h2>
    <p class="sub-halaman">Koleksi buku perpustakaan.</p>

    <x-flash />

    <div class="aksi-baris" style="margin-bottom:16px">
        @can('kelola-buku')
            <a href="{{ route('buku.create') }}" class="tombol">Tambah Buku</a>
        @endcan
        <a href="{{ route('buku.fetch') }}" class="tombol tombol-garis">Tampilan Fetch</a>
    </div>

    <div class="bungkus-tabel">
        <table class="tabel-buku">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kategori</th>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Tahun Terbit</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($bukus as $b)
                    <tr>
                        <td>{{ $bukus->firstItem() + $loop->index }}</td>
                        <td>{{ $b->kategori->nama ?? '-' }}</td>
                        <td>{{ $b->judul }}</td>
                        <td>{{ $b->penulis }}</td>
                        <td>{{ $b->tahun_terbit }}</td>
                        <td>
                            <div class="aksi-baris">
                                <a class="tombol tombol-kecil tombol-biru" href="{{ route('buku.detail', $b->id) }}">Detail</a>

                                @can('kelola-buku')
                                    <a class="tombol tombol-kecil" href="{{ route('buku.edit', $b) }}">Ubah</a>

                                    <form method="POST" action="{{ route('buku.destroy', $b) }}" class="sebaris"
                                          data-konfirmasi="Hapus buku {{ $b->judul }}?">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="tombol tombol-kecil tombol-merah">Hapus</button>
                                    </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="tabel-kosong">Belum ada buku.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="paginasi">
        @if ($bukus->onFirstPage())
            <span class="tombol tombol-abu" style="opacity:.5">Sebelumnya</span>
        @else
            <a class="tombol tombol-abu" href="{{ $bukus->previousPageUrl() }}">Sebelumnya</a>
        @endif

        <span>Halaman {{ $bukus->currentPage() }} dari {{ $bukus->lastPage() }}</span>

        @if ($bukus->hasMorePages())
            <a class="tombol tombol-abu" href="{{ $bukus->nextPageUrl() }}">Berikutnya</a>
        @else
            <span class="tombol tombol-abu" style="opacity:.5">Berikutnya</span>
        @endif
    </div>

@endsection