<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BukuController extends Controller
{
    private function formatBuku(Buku $b): array
    {
        return [
            'id' => $b->id,
            'judul' => $b->judul,
            'penulis' => $b->penulis,
            'tahun' => $b->tahun_terbit,
            'kategori' => $b->kategori->nama,
        ];
    }

    // Daftar buku: tabel JavaScript (Modul 4) + daftar judul yang dirender Blade
    public function index()
    {
        return view('buku.index', [
            'kategori'    => Kategori::orderBy('nama')->get(),
            'bukuTerbaru' => Buku::latest('id')->limit(10)->get(),
        ]);
    }

    public function detail($id)
    {
        $data = Buku::with('kategori')->find($id);

        $buku = $data ? $this->formatBuku($data) : null;

        return view('buku.detail', compact('buku'));
    }

    public function create()
    {
        return view('buku.form', ['buku' => new Buku()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->aturan(), $this->pesan(), $this->atribut());

        Buku::create($data);

        return redirect()->route('buku.index')->with('status', 'Buku berhasil ditambahkan.');
    }

    public function edit(Buku $buku)
    {
        return view('buku.form', compact('buku'));
    }

    public function update(Request $request, Buku $buku)
    {
        $data = $request->validate($this->aturan($buku), $this->pesan(), $this->atribut());

        $buku->update($data);

        return redirect()->route('buku.index')->with('status', 'Buku berhasil diperbarui.');
    }

        // SOAL 2b (A2): DITAMBAL. Query binding, nilai dikirim terpisah dari perintah SQL
    public function cari(Request $request)
    {
        $judul = $request->query('judul');

        $hasil = DB::select(
            'SELECT id, judul, penulis FROM bukus WHERE judul = ?',
            [$judul]
        );

        return response()->json($hasil);
    }

    private function aturan(?Buku $buku = null): array
    {
        return [
            'kategori_id'  => ['required', 'exists:kategoris,id'],
            'judul'        => ['required', 'string', 'min:3', 'max:150',
                               Rule::unique('bukus', 'judul')->ignore($buku?->id)],
            'penulis'      => ['required', 'string', 'min:3', 'max:100'],
            'tahun_terbit' => ['required', 'integer', 'between:1900,' . date('Y')],
        ];
    }

    private function pesan(): array
    {
        return [
            'required'             => ':attribute wajib diisi.',
            'string'               => ':attribute harus berupa teks.',
            'integer'              => ':attribute harus berupa bilangan bulat.',
            'kategori_id.exists'   => 'Kategori yang dipilih tidak valid.',
            'judul.min'            => 'Judul buku minimal :min karakter',
            'judul.max'            => 'Judul buku maksimal :max karakter',
            'judul.unique'         => 'Judul buku ini sudah ada.',
            'penulis.min'          => 'Nama penulis minimal :min karakter',
            'penulis.max'          => 'Nama penulis maksimal :max karakter',
            'tahun_terbit.between' => 'Tahun terbit harus antara 1900 sampai ' . date('Y'),
        ];
    }

    private function atribut(): array
    {
        return [
            'kategori_id'  => 'kategori',
            'judul'        => 'judul buku',
            'penulis'      => 'penulis',
            'tahun_terbit' => 'tahun terbit',
        ];
    }
}