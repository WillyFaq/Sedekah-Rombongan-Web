<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MainResource;
use App\Http\Resources\ProjectListCollection;
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
        $data = Category::oldest()->get();
        //return collection of posts as a resource
        return new MainResource(true, 'List Data Category', $data);
    }

    /**
     * show
     *
     * @param  mixed $id
     * @return void
     */
    public function show($id, Request $request)
    {
        //find post by ID
        // $post = Category::find($id);
        // $data = Project::select('judul', 'slug', 'gambar', 'lokasi', 'target_dana', 'tgl_mulai')
        //     ->withSum(["donations as donasi" => function ($query) {
        //         $query->where('status', '>', '0');
        //     }], 'jumlah')
        //     ->where("status", ">", "0")
        //     ->where("category_id", $id)
        //     ->latest()
        //     ->simplePaginate(5);
        $qry = Project::where("status", ">", "0")
            // ->where("category_id", $id)->latest()->simplePaginate(5);
            ->where("category_id", $id);
        $search = $request->input('search');
        if ($search) {
            $qry->where('judul', 'like', "%$search%");
        }
        $data = $qry->latest()->paginate(5);
        if (!$data) {
            throw new HttpResponseException(response([
                'errors' => [
                    'message' => [
                        'projects in cotegory not found'
                    ]
                ]
            ], 400));
        }
        //return single post as a resource
        // return new MainResource(true, 'List Data Proyek by Kategori!', $data);
        return new ProjectListCollection($data);
    }

    function carousel()
    {
        $data = Category::with('projects')
            ->latest()
            ->get()
            ->toArray();
        $project = [];
        foreach ($data as $k => $v) {
            $limit = 2;
            foreach ($v['projects'] as $a => $b) {
                if ($a >= $limit) {
                    break;
                }
                array_push($project, [
                    "id" => $b["id"],
                    "slug" => $b["slug"],
                    "gambar" => $b["gambar"],
                ]);
            }
        }
        // dd($project);
        //return collection of posts as a resource
        return new MainResource(true, 'List Data Carousel', $project);
        // return new ProjectListCollection($project);
    }
}
