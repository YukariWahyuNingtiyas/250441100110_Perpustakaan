<?php

namespace Database\Seeders;

use App\Models\Buku;
use Illuminate\Database\Seeder;

class BukuSeeder extends Seeder
{
    public function run(): void
    {
        Buku::factory()->create(['judul' => 'Pulang', 'penulis' => 'Tere Liye', 'tahun_terbit' => 2015, 'kategori_id' => 1]);
        Buku::factory()->create(['judul' => 'Hujan', 'penulis' => 'Tere Liye', 'tahun_terbit' => 2016, 'kategori_id' => 1]);
        Buku::factory()->create(['judul' => 'Atomic Habits', 'penulis' => 'James Clear', 'tahun_terbit' => 2018, 'kategori_id' => 2]);
        Buku::factory()->create(['judul' => 'Filosofi Teras', 'penulis' => 'Henry Manampiring', 'tahun_terbit' => 2019, 'kategori_id' => 2]);
        Buku::factory()->create(['judul' => 'Laskar Pelangi', 'penulis' => 'Andrea Hirata', 'tahun_terbit' => 2005, 'kategori_id' => 1]);
    }
}