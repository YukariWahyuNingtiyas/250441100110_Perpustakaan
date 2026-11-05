<footer class="kaki-situs">
    <p>&copy; {{ date('Y') }} Perpustakaan Digital</p>
</footer>

<script>
    // Alert konfirmasi: berlaku untuk semua form yang punya atribut data-konfirmasi
    document.addEventListener('submit', function (event) {
        const pesan = event.target.dataset ? event.target.dataset.konfirmasi : null;

        if (pesan && !window.confirm(pesan)) {
            event.preventDefault();   // dibatalkan, form tidak dikirim
        }
    });
</script>