<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $donations = $this->donations->where('status', '>', '0');
        //$a = ;
        $donatur = [];
        foreach (array_slice($donations->toArray(), 0, 3) as $k => $v) {
            $usr = User::select('nama')->where('id', $v["user_id"])->latest()->first()->toArray();
            array_push($donatur, $usr["nama"][0]);
            // $donatur += "";
        }
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
            'donatur' => $donatur,
        ];
    }
}
