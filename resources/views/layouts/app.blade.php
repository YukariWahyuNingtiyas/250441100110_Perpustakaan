<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Perpustakaan Digital</title>

    @vite(['resources/css/app.css', 'resources/css/perpustakaan.css', 'resources/js/app.js'])
</head>

<body>
    <div class="halaman">
        @include('layouts.partials.atas')

        <main>
            @isset($header)
                <div class="kepala-halaman">{{ $header }}</div>
            @endisset

            {{ $slot }}
        </main>

        @include('layouts.partials.bawah')
    </div>
</body>
</html>