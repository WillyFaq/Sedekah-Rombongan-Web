<?php

namespace App\Http\Controllers\Api;

use App\Models\Comment;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\MainResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CommentAddRequest;
use App\Http\Requests\CommentUpdateRequest;
use App\Http\Resources\CommentCollection;
use App\Http\Resources\CommentResource;
use Illuminate\Http\Exceptions\HttpResponseException;
use Throwable;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // showing comment by user
        $user = Auth::user();
        $data = Comment::with(['project'])->where("user_id", $user->id)->where("status", ">", "0")->latest()->simplePaginate(5);
        return new CommentResource($data);
    }

    public function byproject(Project $project)
    {
        $data = Comment::with(['user'])
            ->where("project_id", $project->id)
            ->where("status", ">", "0")
            ->latest()
            // ->simplePaginate(5);
            ->paginate(5);
        // $data = Comment::select(
        //     'comments.isi_komentar',
        //     'comments.anonim',
        //     'comments.created_at',
        //     DB::raw("IF (comments.anonim, 'Sedekaholic', users.nama) AS user")
        // )
        //     ->join('users', 'comments.user_id', '=', 'users.id')
        //     ->where('comments.status', '>', '0')
        //     ->where("project_id", $project->id)
        //     ->latest()
        //     ->simplePaginate(5);
        // return new MainResource(true, 'List Data Comment', $data);

        return new CommentCollection($data);
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
    public function store(CommentAddRequest $request): JsonResponse
    {
        $user = Auth::user();
        $data = $request->validated();
        $comment = new Comment($data);
        $comment->user_id = $user->id;
        try {
            $comment->save();
        } catch (Throwable $e) {
            throw new HttpResponseException(response([
                'errors' => [
                    'message' => [
                        'something went wrong'
                    ]
                ]
            ], 400));
        }
        return (new CommentResource($comment))->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        // 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CommentUpdateRequest $request, Comment $comment)
    {
        //
        $user = Auth::user();
        if ($user->id != $comment->user_id) {
            throw new HttpResponseException(response([
                'errors' => [
                    'message' => [
                        'unauthorized'
                    ]
                ]
            ], 401));
        }
        $data = $request->validated();
        $comment->isi_komentar = $data["isi_komentar"];
        if (isset($data['anonim'])) {
            $comment->anonim = $data["anonim"];
        }
        $comment->save();
        return new CommentResource($comment);
    }

    public function aminkan(Comment $comment)
    {
        $comment->increment("amin");
        $comment->save();
        return new CommentResource($comment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
