<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BukuResource;
use App\Models\Buku;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $buku = Buku::with('kategori')
            ->withCount('peminjamans')
            ->when($request->filled('cari'), function ($query) use ($request) {
                $cari = $request->cari;
                $query->where(function ($q) use ($cari) {
                    $q->where('judul', 'like', '%' . $cari . '%')
                      ->orWhere('penulis', 'like', '%' . $cari . '%');
                });
            })
            ->when($request->filled('kategori'), fn ($q) => $q->where('kategori_id', $request->kategori))
            ->when($request->filled('tahun'), fn ($q) => $q->where('tahun_terbit', $request->tahun))
            ->latest()
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return BukuResource::collection($buku);
    }

    public function store(Request $request)
    {
        $data = $request->validate(
            $this->aturan(),
            $this->pesan(),
            $this->atribut()
        );

        $buku = Buku::create($data);
        $buku->load('kategori');

        return (new BukuResource($buku))
            ->additional(['message' => 'Buku berhasil ditambahkan'])
            ->response()
            ->setStatusCode(201);
    }

    public function show(string $id)
    {
        $buku = Buku::with(['kategori', 'peminjamans'])->find($id);

        if (! $buku) {
            return response()->json(['message' => 'not found'], 404);
        }

        return new BukuResource($buku);
    }

    public function update(Request $request, string $id)
    {
        $buku = Buku::find($id);

        if (! $buku) {
            return response()->json(['message' => 'not found'], 404);
        }

        $data = $request->validate(
            $this->aturan(true),
            $this->pesan(),
            $this->atribut()
        );

        $buku->update($data);
        $buku->load('kategori');

        return (new BukuResource($buku))
            ->additional(['message' => 'Buku berhasil diperbarui']);
    }

    public function destroy(string $id): JsonResponse
    {
        $buku = Buku::find($id);

        if (! $buku) {
            return response()->json(['message' => 'not found'], 404);
        }

        if ($buku->peminjamans()->exists()) {
            return response()->json([
                'message' => 'Buku tidak bisa dihapus karena masih punya data peminjaman',
            ], 409);
        }

        $buku->delete();

        return response()->json(['message' => 'Buku berhasil dihapus'], 200);
    }

    private function aturan(bool $sebagian = false): array
    {
        $aturan = [
            'kategori_id'  => ['required', 'exists:kategoris,id'],
            'judul'        => ['required', 'string', 'min:3', 'max:150',
                               Rule::unique('bukus', 'judul')->ignore(request()->route('buku'))],
            'penulis'      => ['required', 'string', 'min:3', 'max:100'],
            'tahun_terbit' => ['required', 'integer', 'between:1900,' . date('Y')],
        ];

        if ($sebagian) {
            foreach ($aturan as $field => $rules) {
                array_unshift($aturan[$field], 'sometimes');
            }
        }

        return $aturan;
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