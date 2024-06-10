<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Donation;
use App\Models\Project;
use Illuminate\Http\Request;
use Cviebrock\EloquentSluggable\Services\SlugService;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            "page_title" => "Proyek Donasi",
            "data" => Project::with(["category", "donations", "comments"])->orderBy('tgl_mulai', 'desc')->where("status", ">", "0")->get()
        ];
        return view("project.index", $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            "page_title" => "Tambah Proyek Donasi",
            "categories" => Category::all()
        ];
        return view("project.create", $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'judul' => 'required|max:255',
            'category_id' => 'required',
            'target_dana' => 'required|numeric',
            'lokasi' => 'required|max:255',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date|after:tgl_mulai',
            'deskripsi' => 'required',
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048'
        ]);
        //
        $filename = $request->file('image')->getClientOriginalName();
        // $request->file('image')->store('public/images');
        $request->image->move(public_path('images'), $filename);
        unset($validateData["image"]);
        $validateData["gambar"] = $filename;
        //
        $validateData["slug"] = $this->createSlug($validateData["judul"]);
        Project::create($validateData);
        return redirect('/project')->with('success', 'Data Berhasil Disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $data = [
            "page_title" => "Detail Proyek Donasi",
            "project" => $project
        ];
        return view("project.show", $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $data = [
            "page_title" => "Ubah Proyek Donasi",
            "project" => $project,
            "categories" => Category::all()
        ];
        return view("project.edit", $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $rules = [
            'judul' => 'required|max:255',
            'category_id' => 'required',
            'target_dana' => 'required|numeric',
            'lokasi' => 'required|max:255',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date|after:tgl_mulai',
            'deskripsi' => 'required',
        ];
        if ($request->image != $project->image) {
            $rules['image'] = 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048';
        }
        $validateData = $request->validate($rules);
        if ($request->image != $project->image) {
            $filename = $request->file('image')->getClientOriginalName();
            // $request->file('image')->store('public/images');
            $request->image->move(public_path('images'), $filename);
            $validateData["gambar"] = $filename;
            unset($validateData["image"]);
        }
        Project::where("id", $project->id)->update($validateData);
        return redirect('/project')->with('success', 'Data Berhasil Disimpan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $sts = $project->status == 0 ? 1 : 0;
        Project::where('id', $project->id)->update(['status' => $sts]);
        Donation::where('project_id', $project->id)->update(['status' => $sts]);
        Comment::where('project_id', $project->id)->update(['status' => $sts]);
        return redirect('/project')->with('success', 'Data Berhasil Dihapus');
    }

    public function createSlug($title)
    {
        return SlugService::createSlug(Project::class, 'slug', $title);
    }
}
