@extends('layouts.perpustakaan')

@section('judul', $buku->exists ? 'Ubah Buku' : 'Tambah Buku')

@section('konten')

    <h2 class="judul-halaman">{{ $buku->exists ? 'Ubah Buku' : 'Tambah Buku' }}</h2>
    <p class="sub-halaman">Isi data buku lalu simpan.</p>

    <form method="POST"
          action="{{ $buku->exists ? route('buku.update', $buku) : route('buku.store') }}"
          class="form-buku"
          data-konfirmasi="{{ $buku->exists ? 'Simpan perubahan pada buku ini?' : 'Tambahkan buku baru ini?' }}">
        @csrf
        @if ($buku->exists)
            @method('PUT')
        @endif

        <div class="grid-form">
            <div class="baris-form">
                <label for="kategori_id">ID Kategori</label>
                <input type="number" id="kategori_id" name="kategori_id" min="1"
                       value="{{ old('kategori_id', $buku->kategori_id) }}" placeholder="Contoh: 1">
                @error('kategori_id') <small class="error-field">{{ $message }}</small> @enderror
            </div>

            <div class="baris-form">
                <label for="judul">Judul</label>
                <input type="text" id="judul" name="judul"
                       value="{{ old('judul', $buku->judul) }}" placeholder="Judul buku">
                @error('judul') <small class="error-field">{{ $message }}</small> @enderror
            </div>

            <div class="baris-form">
                <label for="penulis">Penulis</label>
                <input type="text" id="penulis" name="penulis"
                       value="{{ old('penulis', $buku->penulis) }}" placeholder="Nama penulis">
                @error('penulis') <small class="error-field">{{ $message }}</small> @enderror
            </div>

            <div class="baris-form">
                <label for="tahun_terbit">Tahun Terbit</label>
                <input type="number" id="tahun_terbit" name="tahun_terbit"
                       value="{{ old('tahun_terbit', $buku->tahun_terbit) }}" placeholder="Contoh: 2015">
                @error('tahun_terbit') <small class="error-field">{{ $message }}</small> @enderror
            </div>
        </div>

        <div class="aksi-baris">
            <button type="submit" class="tombol">{{ $buku->exists ? 'Perbarui' : 'Simpan' }}</button>
            <a href="{{ route('buku.index') }}" class="tombol tombol-abu">Batal</a>
        </div>
    </form>

@endsection