<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            "page_title" => "Pengguna",
            "data" => User::orderBy('status', 'desc')->latest()->get()
        ];
        return view("user.index", $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            "page_title" => "Tambah Pengguna"
        ];
        return view("user.create", $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'nama' => 'required|max:255',
            'email' => 'required|email:dns|unique:users|max:255',
            'password' => 'required|min:8|max:255',
            'nomor_telepon' => 'required|max:255',
            'alamat' => 'required|max:255',
        ]);
        $validateData['password'] = Hash::make($validateData['password']);
        User::create($validateData);
        return redirect('/user')->with('success', 'Data Berhasil Disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $data = [
            "page_title" => "Ubah Pengguna",
            "user" => $user
        ];
        return view("user.edit", $data);
    }


    public function resetpassword(User $user)
    {
        $data = [
            "page_title" => "Reset Password Pengguna",
            "user" => $user
        ];
        return view("user.reset", $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        if ($request->type == "edit") {
            $rules = [
                'nama' => 'required|max:255',
                'nomor_telepon' => 'required|max:255',
                'alamat' => 'required|max:255',
            ];
            if ($request->email != $user->email) {
                $rules['email'] = 'required|email:dns|max:255';
            }
            $validateData = $request->validate($rules);
        } else {
            $vdata = $request->validate([
                'newpassword' => 'required|min:8|max:255',
                'repassword' => 'required|same:newpassword'
            ]);
            $validateData["password"] = Hash::make($vdata['newpassword']);
        }
        User::where("id", $user->id)->update($validateData);
        return redirect('/user')->with('success', 'Data Berhasil Disimpan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $sts = $user->status == 0 ? 1 : 0;
        User::where('id', $user->id)->update(['status' => $sts]);
        return redirect('/user')->with('success', 'Data Berhasil Diubah');
    }
}
