<button {{ $attributes->merge(['type' => 'submit', 'class' => 'tombol']) }}>
    {{ $slot }}
</button>