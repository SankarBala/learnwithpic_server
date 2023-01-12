<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\PostCreateRequest;
use App\Http\Requests\Post\PostUpdateRequest;
use App\Models\Post;
use App\Models\Step;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
    public function index(Request $request)
    {
        $filters = $request->all();
        $posts = Post::filter($filters)->with(['author', 'categories', 'tags', 'comments'])->paginate();

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

        foreach ($request->steps as $step) {
            // Step::create([...$step, 'post_id' => $post->id]);
            $post->steps()->save(Step::create($step));
        }

        return response()->json(['message' => trans('Post saved succesfully')], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $post->load(['categories',  'tags', 'steps']);
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


    /**
     * Execute the specified action as required.
     *
     * @return \Illuminate\Http\Response
     */

    public function execute(Request $request)
    {
        $action = $request->action;
        $items = $request->items;


        if ($action == "publish") {
            foreach ($items as $item) {
                $post = Post::find($item);
                $post->status = 'published';
                $post->save();
            }
        } elseif ($action == "draft") {
            foreach ($items as $item) {
                $post = Post::find($item);
                $post->status = 'draft';
                $post->save();
            }
        } elseif ($action == "delete") {
            foreach ($items as $item) {
                $post = Post::find($item);
                $post->delete();
            }
        } else {
            return abort(400);
            // return response()->json(['message'=>'Sorry command didn\'t executed'], 500);
        }

        return response()->json(['message' => 'Command successfully executed'], 202);
    }



    public function created_months()
    {
        $months = Post::selectRaw('DATE_FORMAT(created_at, "%M %Y") as month')
            ->groupBy('month')
            ->get()
            ->pluck('month')
            ->toArray();

        return response()->json(['months' => $months], 200);
    }
}
