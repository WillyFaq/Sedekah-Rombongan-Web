<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DonationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'project' => $this->project->judul,
            'project_slug' => $this->project->slug,
            'user' => $this->anonim ? 'Sedekaholic' : $this->user->nama,
            'jumlah' => $this->jumlah,
            'idr_jumlah' => 'Rp. ' . number_format($this->jumlah),
            'created_at' => $this->created_at,
            'waktu' => $this->created_at->diffForHumans(),
        ];
    }
}
