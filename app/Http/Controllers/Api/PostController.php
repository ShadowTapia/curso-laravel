<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\PutRequest;
use App\Http\Requests\Post\StoreRequest;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Post::with('category')->paginate(10));
    }

    /**
     * Devuelve todos los post
     */
    public function all()
    {
        return response()->json(Post::get());
    }

    public function slug(Post $post) //$slug
    {
        //$post = Post::with('category')->where('slug', $slug)->firstorFail();
        $post->category();
        return response()->json($post);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        return response()->json(Post::create($request->validated()));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return response()->json($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(PutRequest $request, Post $post)
    {
        $post->update($request->validated());
        return response()->json($post);
    }

    public function upload(Request $request, Post $post)
    {
        $request->validate([
            'image' => "required|mimes:png,jpg,gif|max:10240"
        ]);

        Storage::disk('public_upload')->delete('image/otro/' . $post->image);

        $data['image'] = $filename = time() . "." . $request['image']->extension();
        $request->image->move(public_path('image/otro'), $filename);

        $post->update($data);
        return response()->json($post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return response()->json('OK');
    }
}
