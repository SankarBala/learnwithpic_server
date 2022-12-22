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
    public function store(Request $request)
    {
        // $request->validated();

        // $base64_str = substr($request->image->document3, strpos($request->image->document3, ",") + 1);

        // Log::debug($base64_str);
        //decode base64 string
        // $image = base64_decode($request->image);
        // Log::debug($image);

        // $safeName = Str::random(10) . '.' . 'png';

        // $file = Storage::disk('public')->put('eejaz/' . $safeName, $image);

        // Log::debug($file);

        // return;



        $post = Post::create([
            'title' => $request->title,
            'slug' => $request->slug,
            'content' => $request->content,
            'image' => $request->image
        ]);

        $post->categories()->sync($request->categories);


        $tags = [];
        foreach ($request->tags as $index => $tag) {
            $tag = Tag::firstOrCreate(["name" => $tag, "slug" => Str::slug($tag)]);
            array_push($tags, $tag->id);
        }
        $post->tags()->sync($tags);

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
