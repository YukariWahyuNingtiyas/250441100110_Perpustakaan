<?php

namespace Database\Seeders;

use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $this->buatUser('Administrator', 'admin@gmail.com', 'admin');
        $this->buatUser('Petugas Perpustakaan', 'petugas@gmail.com', 'petugas');
        $siswa1 = $this->buatUser('Siswa Satu', 'siswa@gmail.com', 'siswa');
        $siswa2 = $this->buatUser('Siswa Dua', 'siswa2@gmail.com', 'siswa');

        // Data peminjaman contoh untuk menguji riwayat milik sendiri
        $buku = Buku::orderBy('id')->get();

        if ($buku->count() >= 4) {
            $a1 = $siswa1->anggotaSaya();
            $a2 = $siswa2->anggotaSaya();

            Peminjaman::firstOrCreate(
                ['anggota_id' => $a1->id, 'buku_id' => $buku[0]->id],
                ['tanggal_pinjam' => '2026-10-01', 'tanggal_kembali' => '2026-10-08', 'status' => 'dikembalikan']
            );
            Peminjaman::firstOrCreate(
                ['anggota_id' => $a1->id, 'buku_id' => $buku[1]->id],
                ['tanggal_pinjam' => now()->toDateString(), 'status' => 'diajukan']
            );
            Peminjaman::firstOrCreate(
                ['anggota_id' => $a2->id, 'buku_id' => $buku[2]->id],
                ['tanggal_pinjam' => now()->toDateString(), 'status' => 'dipinjam']
            );
            Peminjaman::firstOrCreate(
                ['anggota_id' => $a2->id, 'buku_id' => $buku[3]->id],
                ['tanggal_pinjam' => '2026-09-20', 'tanggal_kembali' => '2026-09-27', 'status' => 'dikembalikan']
            );
        }
    }

    private function buatUser(string $nama, string $email, string $role): User
    {
        $user = User::firstOrCreate(
            ['email' => $email],
            ['name' => $nama, 'password' => Hash::make('password')]
        );
        $user->syncRoles([$role]);

        return $user;
    }
}