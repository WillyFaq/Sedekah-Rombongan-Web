<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory, Sluggable;
    protected $fillable = ["judul", "slug", "gambar", "lokasi", "deskripsi", "target_dana", "tgl_mulai", "tgl_selesai", "status", "category_id"];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class)->latest();
    }

    public function donations(): HasMany
    {
        return $this->hasMany(Donation::class)->latest();
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'judul'
            ]
        ];
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * gambar
     *
     * @return Attribute
     */
    protected function gambar(): Attribute
    {
        return Attribute::make(
            get: fn ($gambar) =>  Str::substr($gambar, 0, 5) != 'https' ? url('/storage/' . $gambar) : $gambar,
            // get: fn ($gambar) =>  url('/storage/' . $gambar),
        );
    }
}
