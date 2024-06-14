<?php

namespace App\Http\Controllers\Api;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\MainResource;
use App\Http\Resources\ProjectResource;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProjectController extends Controller
{

    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get all posts
        $data = Project::select('judul', 'slug', 'gambar', 'lokasi', 'target_dana', 'tgl_mulai')
            ->withSum(["donations as donasi" => function ($query) {
                $query->where('status', '>', '0');
            }], 'jumlah')
            ->where("status", ">", "0")
            ->latest()
            ->simplePaginate(5);
        //return collection of posts as a resource
        return new MainResource(true, 'List Data Category', $data);
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
        return new MainResource(true, 'Detail Data Proyek', $project);
    }
}
