@if (session('status'))
    <div class="pesan pesan-sukses">{{ session('status') }}</div>
@endif

@if ($errors->any())
    <div class="pesan pesan-gagal">
        <ul class="daftar-error">
            @foreach ($errors->all() as $pesan)
                <li>{{ $pesan }}</li>
            @endforeach
        </ul>
    </div>
@endif