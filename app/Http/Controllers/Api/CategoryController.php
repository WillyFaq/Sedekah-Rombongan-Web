<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MainResource;
use App\Models\Category;
use App\Models\Project;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get all posts
        $data = Category::latest()->get();
        //return collection of posts as a resource
        return new MainResource(true, 'List Data Category', $data);
    }

    /**
     * show
     *
     * @param  mixed $id
     * @return void
     */
    public function show($id)
    {
        //find post by ID
        // $post = Category::find($id);
        $data = Project::select('judul', 'slug', 'gambar', 'lokasi', 'target_dana', 'tgl_mulai')
            ->withSum(["donations as donasi" => function ($query) {
                $query->where('status', '>', '0');
            }], 'jumlah')
            ->where("status", ">", "0")
            ->where("category_id", $id)
            ->latest()
            ->simplePaginate(5);
        if (!$data) {
            throw new HttpResponseException(response([
                'errors' => [
                    'message' => [
                        'cotegory not found'
                    ]
                ]
            ], 400));
        }
        //return single post as a resource
        return new MainResource(true, 'List Data Proyek by Kategori!', $data);
    }
}
