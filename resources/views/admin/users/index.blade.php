@extends('layouts.perpustakaan')

@section('judul', 'Kelola Pengguna')

@section('konten')

    <h2 class="judul-halaman">Kelola Pengguna dan Role</h2>
    <p class="sub-halaman">Tambah akun, tetapkan role, dan hapus akun pengguna.</p>

    <x-flash />

    @can('kelola data pengguna')
        <div class="kartu">
            <h3>Tambah Pengguna</h3>
            <form method="POST" action="{{ route('admin.users.store') }}"
                    data-konfirmasi="Tambahkan pengguna baru ini?">
                @csrf
                <div class="grid-form">
                    <div class="baris-form">
                        <label for="name">Nama</label>
                        <input id="name" name="name" value="{{ old('name') }}" required>
                    </div>
                    <div class="baris-form">
                        <label for="email">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required>
                    </div>
                    <div class="baris-form">
                        <label for="password">Password</label>
                        <input id="password" type="password" name="password" placeholder="Minimal 8 karakter" required>
                    </div>
                    <div class="baris-form">
                        <label for="role">Role</label>
                        <select id="role" name="role">
                            @foreach ($roles as $r)
                                <option value="{{ $r }}" @selected(old('role') === $r)>{{ ucfirst($r) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <button class="tombol">Tambah Pengguna</button>
            </form>
        </div>
    @endcan

    <div class="bungkus-tabel">
        <table class="tabel-data">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $u)
                    <tr>
                        <td>{{ $u->name }}</td>
                        <td>{{ $u->email }}</td>
                        <td>
                            @can('kelola role pengguna')
                                <form method="POST" action="{{ route('admin.users.role', $u) }}" class="sebaris"
                                        data-konfirmasi="Simpan perubahan role untuk {{ $u->name }}?">
                                    @csrf
                                    @method('PATCH')
                                    <select name="role" class="kontrol kontrol-kecil">
                                        @foreach ($roles as $r)
                                            <option value="{{ $r }}" @selected($u->hasRole($r))>{{ ucfirst($r) }}</option>
                                        @endforeach
                                    </select>
                                    <button class="tombol tombol-kecil">Simpan role</button>
                                </form>
                            @else
                                @foreach ($u->getRoleNames() as $nama)
                                    <span class="lencana lencana-{{ $nama }}">{{ ucfirst($nama) }}</span>
                                @endforeach
                            @endcan
                        </td>
                        <td>
                            @can('kelola data pengguna')
                                @if ($u->id !== auth()->id())
                                    <form method="POST" action="{{ route('admin.users.destroy', $u) }}" class="sebaris"
                                            data-konfirmasi="Hapus pengguna {{ $u->name }}? Tindakan ini tidak dapat dibatalkan.">
                                        @csrf
                                        @method('DELETE')
                                        <button class="tombol tombol-kecil tombol-merah">Hapus</button>
                                    </form>
                                @endif
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection