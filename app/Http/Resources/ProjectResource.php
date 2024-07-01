<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $donations = $this->donations->where('status', '>', '0');
        $jumlah = $donations->sum('jumlah');
        return [
            'id' => $this->id,
            'judul' => $this->judul,
            'slug' => $this->slug,
            'gambar' => $this->gambar,
            'lokasi' => $this->lokasi,
            'target_dana' => $this->target_dana,
            'tgl_mulai' => $this->tgl_mulai,
            'kategori' => $this->category->nama_kategori,
            'donasi' => $donations->count(),
            'jumlah' => $jumlah,
            'idr_target' => "Rp. " . number_format($this->target_dana),
            'idr_jumlah' => "Rp. " . number_format($jumlah),
            'deskripsi' => $this->deskripsi,
            'donatur' => [],
        ];
    }
}
