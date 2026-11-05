<div>
    @props([
    'judul',
    'penulis',
    'tahun'
])

<div class="kartu-buku">

    <h3>{{ $judul }}</h3>

    <p>Penulis: {{ $penulis }}</p>

    <p>Tahun Terbit: {{ $tahun }}</p>

    {{ $slot }}

</div>
</div>