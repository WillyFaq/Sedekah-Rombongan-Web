<?php

namespace App\Http\Controllers\Api;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\MainResource;
use App\Http\Resources\ProjectListCollection;
use App\Http\Resources\ProjectListResource;
use App\Http\Resources\ProjectResource;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProjectController extends Controller
{

    /**
     * index
     *
     * @return void
     */
    public function index(Request $request)
    {
        //get all posts
        // $data = Project::select('judul', 'slug', 'gambar', 'lokasi', 'target_dana', 'tgl_mulai')
        //     ->withSum(["donations as donasi" => function ($query) {
        //         $query->where('status', '>', '0');
        //     }], 'jumlah')
        //     ->withCount(["donations as donasi" => function ($query) {
        //         $query->where('status', '>', '0');
        //     }], 'donatur')
        //     ->where("status", ">", "0")
        //     ->latest()
        //     ->simplePaginate(5);
        // $data = Project::where("status", ">", "0")->latest()->simplePaginate(5);
        $qry = Project::where("status", ">", "0");
        $search = $request->input('search');
        if ($search) {
            // dd($search);
            $qry->where('judul', 'like', "%$search%");
        }
        $data = $qry->orderBy("tgl_mulai", "desc")->paginate(5);
        // return new MainResource(true, 'List Data Category', $data);
        return new ProjectListCollection($data);
    }


    /**
     * show
     *
     * @param  mixed $id
     * @return void
     */
    public function show(Project $project)
    {
        // $data = Project::where("slug", $slug)
        //     ->where("status", ">", "0")
        //     ->get();
        // $data = Project::find($slug);
        // $data = $project;
        if (empty($project)) {
            throw new HttpResponseException(response([
                'errors' => [
                    'message' => [
                        'project not found'
                    ]
                ]
            ], 400));
        }

        //return single post as a resource
        // return new MainResource(true, 'Detail Data Proyek', $project);
        return new ProjectResource($project);
    }
}
