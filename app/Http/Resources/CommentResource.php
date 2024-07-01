<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            'isi_komentar' => $this->isi_komentar,
            'user' => $this->anonim ? 'Sedekaholic' : $this->user->nama,
            'amin' => $this->amin == null ? 0 : $this->amin,
            'created_at' => $this->created_at,
            'waktu' => $this->created_at->diffForHumans(),
        ];
    }
}
