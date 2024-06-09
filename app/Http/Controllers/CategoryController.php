<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            "page_title" => "Kategori",
            "data" => Category::with(["projects"])->orderBy('status', 'desc')->latest()->get()
        ];
        return view("category.index", $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            "page_title" => "Tambah Kategori"
        ];
        return view("category.create", $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'nama_kategori' => 'required|max:255'
        ]);
        $validateData["slug"] = $this->createSlug($validateData["nama_kategori"]);

        Category::create($validateData);
        return redirect('/category')->with('success', 'Data Berhasil Disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $data = [
            "page_title" => "Ubah Kategori",
            "category" => $category
        ];
        return view("category.edit", $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validateData = $request->validate([
            'nama_kategori' => 'required|max:255'
        ]);
        $validateData["slug"] = $this->createSlug($validateData["nama_kategori"]);
        Category::where("id", $category->id)->update($validateData);
        return redirect('/category')->with('success', 'Data Berhasil Disimpan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $sts = $category->status == 0 ? 1 : 0;
        Category::where('slug', $category->slug)->update(['status' => $sts]);
        return redirect('/category')->with('success', 'Data Berhasil Diubah');
    }

    // public function recover(Category $category)
    // {
    //     $sts = $category->status == 0 ? 1 : 0;
    //     dd($sts);
    //     Category::where('slug', $category->slug)->update(['status' => $sts]);
    //     return redirect('/category')->with('success', 'Data Berhasil Diubah');
    // }

    public function createSlug($title)
    {
        return SlugService::createSlug(Category::class, 'slug', $title);
    }
}
