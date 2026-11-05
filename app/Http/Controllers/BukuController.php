<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;

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

    public function index()
    {
        $kategori = Kategori::orderBy('nama')->get();

        return view('buku.index', compact('kategori'));
    }

    public function detail($id)
    {
        $data = Buku::with('kategori')->find($id);

        $buku = $data ? $this->formatBuku($data) : null;

        return view('buku.detail', compact('buku'));
    }
}