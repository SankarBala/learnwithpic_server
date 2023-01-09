<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\CategoryCreateRequest;
use App\Http\Requests\Category\CategoryUpdateRequest;
use App\Models\Category;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CategoryController extends Controller
{

    public function __construct()
    {
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::with(['parents', 'children', 'posts'])->get();
        return response()->json($categories, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryCreateRequest $request)
    {
        $request->validated();

        $category = new Category();
        $category->name = $request->name;
        $category->slug = $request->slug ?? Str::slug($request->name);
        $category->save();

        return response()->json($category, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return response()->json($category, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryUpdateRequest $request, Category $category)
    {
        $request->validated();


        if (array_key_exists("parents", $request->all())) {
            $category->parents()->sync($request->parents);
        }
        if (array_key_exists("children", $request->all())) {
            $category->children()->sync($request->children);
        }

        $category->name = $request->name ?? $category->name;
        $category->slug = $request->slug ?? $category->slug;
        $category->save();


        return response()->json(['message' => trans('Category Updated Successfully')], 202);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->parents()->detach();
        $category->children()->detach();

        $category->delete();

        return response()->json(['message' => trans('Category deleted successfully')], 200);
    }

    /**
     * Make relationship between categories.
     * 
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\Response
     */

    public function makeRelationship(Category $category, $parents, $children)
    {
        return response()->json([$category, $parents, $children]);
    }
}
