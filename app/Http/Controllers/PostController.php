<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\PostCreateRequest;
use App\Http\Requests\Post\PostUpdateRequest;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::paginate(10);
        return response()->json($posts, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostCreateRequest $request)
    {
        $request->validated();

        $post = Post::create([
            "title" => $request->title,
            "slug" => $request->slug
        ]);

        $post->categories()->sync($request->categories);

        $tags = [];
        foreach ($request->tags as $index => $tag) {
            $tag = Tag::firstOrCreate(["name" => $tag, "slug" => Str::slug($tag)]);
            array_push($tags, $tag->id);
        }
        $post->tags()->sync($tags);

        if ($data = $request->image) {
            // $data = $request->image;
            list($type, $data) = explode(';', $data);
            list($element, $mime) = explode(':', $type);
            list($variant, $ext) = explode('/', $mime);
            list($encoder, $data)      = explode(',', $data);

            $file = "posts/featured_images/" . time() . ".$ext";
            Storage::disk('public')->put($file, base64_decode($data));

            $post->image = Storage::url($file);
        }

        $post->save();

        return $post;

        return response()->json(['message' => trans('Post created succesfully')], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return response()->json($post, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(PostUpdateRequest $request, Post $post)
    {
        $request->validated();

        $post->title = $request->title;
        $post->slug = $request->slug;
        $post->content = $request->content;
        $post->image = $request->image;
        $post->save();

        return response()->json($post, 202);
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
        return response()->json(['message' => trans('Post deleted succesfully')], 200);
    }
}
