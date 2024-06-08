<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->string('gambar');
            $table->string('lokasi');
            $table->text('deskripsi');
            $table->bigInteger('target_dana');
            $table->dateTime('tgl_mulai');
            $table->dateTime('tgl_selesai');
            $table->char('status', length: 1)->default('1');
            $table->foreignId('category_id')->constrained(
                table: 'categories',
                indexName: 'project_catagory_id'
            );
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
