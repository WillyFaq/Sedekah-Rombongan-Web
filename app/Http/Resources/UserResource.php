<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        $donations = $this->donations->where("status", ">", "0");
        $jmlDonasi = $donations->count();
        $nominalDonasi = $donations->sum('jumlah');
        return [
            'id' => $this->id,
            'nama' => $this->nama,
            'email' => $this->email,
            'nomor_telepon' => $this->nomor_telepon,
            'alamat' => $this->alamat,
            'jumlah_donasi' => $jmlDonasi,
            'nominal_donasi' => $nominalDonasi,
            'idr_nominal_donasi' => "Rp. " . number_format($nominalDonasi),
            'remember_token' => $this->whenNotNull($this->remember_token)
        ];
    }
}
