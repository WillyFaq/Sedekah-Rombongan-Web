<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'judul' => fake()->sentence(),
            'slug' => Str::slug(fake()->sentence()),
            'gambar' => fake()->imageUrl(),
            'lokasi' => fake()->city(),
            'deskripsi' => fake()->sentence(),
            'target_dana' => fake()->numberBetween(10000000, 999999999),
            'tgl_mulai' => fake()->dateTimeInInterval('-1 years', '+1 week'),
            'tgl_selesai' => fake()->dateTimeInInterval('-1 years', '+1 week'),
            'category_id' => Category::factory(),
            'status' => '1'
        ];
    }
}
