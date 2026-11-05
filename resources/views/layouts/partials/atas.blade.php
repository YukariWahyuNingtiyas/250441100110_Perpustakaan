<header class="kepala-situs">
    <h1>Perpustakaan Digital</h1>
    <p>Sistem Informasi Perpustakaan</p>
</header>

<nav class="menu-utama">
    <div class="menu-dalam">

        <div class="menu-kiri">
            <a href="{{ route('home') }}" @class(['aktif' => request()->routeIs('home')])>Beranda</a>

            @auth
                @can('lihat daftar buku')
                    <a href="{{ route('buku.index') }}" @class(['aktif' => request()->routeIs('buku.*')])>Daftar Buku</a>
                @endcan

                @can('akses dashboard admin')
                    <a href="{{ route('admin.dashboard') }}" @class(['aktif' => request()->routeIs('admin.dashboard')])>Dashboard Admin</a>
                @endcan

                @can('akses dashboard petugas')
                    <a href="{{ route('petugas.dashboard') }}" @class(['aktif' => request()->routeIs('petugas.dashboard')])>Dashboard Petugas</a>
                @endcan

                @can('kelola data pengguna')
                    <a href="{{ route('admin.users.index') }}" @class(['aktif' => request()->routeIs('admin.users.*')])>Pengguna</a>
                @endcan

                @can('kelola peminjaman')
                    <a href="{{ route('kelola.peminjaman.index') }}" @class(['aktif' => request()->routeIs('kelola.peminjaman.*')])>Peminjaman</a>
                @endcan

                @can('kelola pengembalian')
                    <a href="{{ route('kelola.pengembalian.index') }}" @class(['aktif' => request()->routeIs('kelola.pengembalian.*')])>Pengembalian</a>
                @endcan

                @can('lihat laporan perpustakaan')
                    <a href="{{ route('laporan.index') }}" @class(['aktif' => request()->routeIs('laporan.*')])>Laporan</a>
                @endcan

                @can('melihat status peminjaman sendiri')
                    <a href="{{ route('peminjaman-saya.index') }}" @class(['aktif' => request()->routeIs('peminjaman-saya.*')])>Peminjaman Saya</a>
                @endcan
            @endauth
        </div>

        <div class="menu-kanan">
            @auth
                @php($peran = auth()->user()->getRoleNames()->first() ?? 'pengguna')
                <span class="info-pengguna">
                    {{ auth()->user()->name }}
                    <span class="lencana lencana-{{ $peran }}">{{ ucfirst($peran) }}</span>
                </span>

                @can('lihat profil sendiri')
                    <a href="{{ route('profile.edit') }}" @class(['aktif' => request()->routeIs('profile.*')])>Profil</a>
                @endcan

                <form method="POST" action="{{ route('logout') }}" class="form-keluar"
                    data-konfirmasi="Yakin ingin keluar dari akun?">
                    @csrf
                    <button type="submit" class="tautan-keluar">Keluar</button>
                </form>
            @else
                <a href="{{ route('login') }}" @class(['aktif' => request()->routeIs('login')])>Masuk</a>
                <a href="{{ route('register') }}" @class(['aktif' => request()->routeIs('register')])>Daftar</a>
            @endauth
        </div>

    </div>
</nav>