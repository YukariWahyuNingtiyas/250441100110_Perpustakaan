<?php

namespace Database\Factories;

use App\Models\Anggota;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Anggota>
 */
class AnggotaFactory extends Factory
{
    protected $model = Anggota::class;

    public function definition(): array
    {
        return [
            'nama' => fake()->firstName() . ' ' . fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'no_telepon' => '08' . fake()->numerify('##########'),
        ];
    }
}