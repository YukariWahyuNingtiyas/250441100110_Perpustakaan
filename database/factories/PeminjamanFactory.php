<?php

namespace Database\Factories;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Peminjaman>
 */
class PeminjamanFactory extends Factory
{
    protected $model = Peminjaman::class;

    public function definition(): array
    {
        $kembali = fake()->boolean() ? fake()->date() : null;

        return [
            'anggota_id' => Anggota::inRandomOrder()->value('id'),
            'buku_id' => Buku::inRandomOrder()->value('id'),
            'tanggal_pinjam' => fake()->date(),
            'tanggal_kembali' => $kembali,
            'status' => $kembali ? 'dikembalikan' : 'dipinjam',
        ];
    }
}