<?php

namespace App\Http\Controllers;

use App\Http\Requests\Tag\TagCreateRequest;
use App\Http\Requests\Tag\TagUpdateRequest;
use App\Models\Tag;
use Illuminate\Support\Str;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tag::with("posts")->get();
        return response()->json($tags, 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function just_tags()
    {
        $tags = Tag::get(['id', 'name', 'slug']);
        return response()->json($tags, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TagCreateRequest $request)
    {
        $tag = new Tag();
        $tag->name = $request->name;
        $tag->slug = $request->slug ?? Str::slug($request->name);
        $tag->save();

        return response()->json(['message' => 'Tag created successfully'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        return response()->json($tag, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(TagUpdateRequest $request, Tag $tag)
    {

        $request->validated();

        $tag->name = $request->name;
        $tag->slug = $request->slug ?? $tag->slug;
        $tag->save();

        return response()->json(['message' => trans('Tag updated successfully')], 202);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        $tag->posts()->detach();
        $tag->delete();

        return response()->json(['message' => trans('Tag deleted successfully')], 200);
    }
}
