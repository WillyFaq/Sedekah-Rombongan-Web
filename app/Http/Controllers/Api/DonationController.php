<?php

namespace App\Http\Controllers\Api;

use Throwable;
use App\Models\Project;
use App\Models\Donation;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\MainResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\DonationRequest;
use App\Http\Resources\DonationCollection;
use App\Http\Resources\DonationResource;
use Illuminate\Http\Exceptions\HttpResponseException;

class DonationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // showing comment by user
        // $data = Donation::with(['project'])->where("user_id", 1)->where("status", ">", "0")->latest()->simplePaginate(5);
        // return new MainResource(true, 'List Data Donation', $data);
        $user = Auth::user();
        $data = Donation::where("user_id", $user->id)->where("status", ">", "0")->latest()->paginate(5);
        return new DonationCollection($data);
    }
    public function byproject(Project $project)
    {
        //$data = Comment::with(['user'])->where("project_id", $project->id)->where("status", ">", "0")->latest()->paginate(5);
        // $data = Donation::select(
        //     'donations.jumlah',
        //     'donations.anonim',
        //     'donations.created_at',
        //     DB::raw("IF (donations.anonim, 'Sedekaholic', users.nama) AS user")
        // )
        //     ->join('users', 'donations.user_id', '=', 'users.id')
        //     ->where("project_id", $project->id)
        //     ->where('donations.status', '>', '0')
        //     ->latest()
        //     ->simplePaginate(5);
        $data = Donation::where("project_id", $project->id)
            ->where('donations.status', '>', '0')
            ->latest()
            // ->simplePaginate(5);
            ->paginate(5);
        // return new MainResource(true, 'List Data Donation', $data);
        return new DonationCollection($data);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DonationRequest $request)
    {
        $user = Auth::user();
        $data = $request->validated();
        $project = new Donation($data);
        $inv = date('ymd');
        $strr = strtoupper(Str::random(5));
        $project->no_invoice = "INV-$inv" . $strr;
        $project->user_id = $user->id;
        try {
            $project->save();
        } catch (Throwable $e) {
            throw new HttpResponseException(response([
                'errors' => [
                    'message' => [
                        'something went wrong'
                    ]
                ]
            ], 400));
        }
        return (new DonationResource($project))->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Donation $donation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Donation $donation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Donation $donation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Donation $donation)
    {
        //
    }
}
