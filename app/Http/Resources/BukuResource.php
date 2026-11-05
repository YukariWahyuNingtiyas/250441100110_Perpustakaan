<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BukuResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                => $this->id,
            'judul'             => $this->judul,
            'penulis'           => $this->penulis,
            'tahun'             => $this->tahun_terbit,                             
            'kategori_id'       => $this->kategori_id,
            'kategori'          => $this->whenLoaded('kategori', fn () => $this->kategori->nama), 
            'jumlah_peminjaman' => $this->whenCounted('peminjamans'),                
            'peminjamans'       => $this->whenLoaded('peminjamans'),
        ];
    }
}