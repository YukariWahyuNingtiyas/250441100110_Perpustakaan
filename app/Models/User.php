<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',   // kata sandi otomatis di-hash
        ];
    }

    public function anggota()
    {
        return $this->hasOne(Anggota::class, 'user_id');
    }

    // Ambil data anggota milik user ini; dibuat otomatis jika belum ada
    public function anggotaSaya(): Anggota
    {
        return $this->anggota()->firstOrCreate([], [
            'nama' => $this->name,
            'email' => $this->email,
            'no_telepon' => '-',
        ]);
    }
}