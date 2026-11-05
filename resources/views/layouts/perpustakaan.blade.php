<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('judul', 'Perpustakaan') | Perpustakaan Digital</title>

    @vite(['resources/css/perpustakaan.css'])
</head>

<body>
    <div class="halaman">
        @include('layouts.partials.atas')

        <main>
            @yield('konten')
        </main>

        @include('layouts.partials.bawah')
    </div>
</body>
</html>