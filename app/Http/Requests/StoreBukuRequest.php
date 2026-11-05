<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBukuRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'kategori_id'  => ['required', 'exists:kategoris,id'],
            'judul'        => ['required', 'string', 'min:3', 'max:150'],
            'penulis'      => ['required', 'string', 'min:3', 'max:100'],
            'tahun_terbit' => ['required', 'integer', 'between:1900,' . date('Y')],
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute wajib diisi.',
            'string'   => ':attribute harus berupa teks.',
            'integer'  => ':attribute harus berupa bilangan bulat.',

            'kategori_id.exists' => 'Kategori yang dipilih tidak valid.',

            'judul.string' => 'Judul buku harus berupa teks.',
            'judul.min'    => 'Judul buku minimal :min karakter',
            'judul.max'    => 'Judul buku maksimal :max karakter',

            'penulis.min' => 'Nama penulis minimal :min karakter',
            'penulis.max' => 'Nama penulis maksimal :max karakter',

            'tahun_terbit.between' => 'Tahun terbit harus antara 1900 sampai ' . date('Y'),
        ];
    }

    public function attributes(): array
    {
        return [
            'kategori_id'  => 'kategori',
            'judul'        => 'judul buku',
            'penulis'      => 'penulis',
            'tahun_terbit' => 'tahun terbit',
        ];
    }
}