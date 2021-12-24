<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $CategoryQuery = Category::query();
        $categories = $CategoryQuery->get();
        return response()->json([
            'message' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $name = $request->input('name');

        Category::query()->create([
            'name' => $name,
        ]);
        return response()->json(['message' => 'successfully stored']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category, $id)
    {
        $CategoryQuery = Category::query();
        $category = $CategoryQuery->get();
        if($id > count($category) or $id == 0)//not sure of this one
            return response()->json([
                'message' => 'invalid id',
            ]);

        $CategoryQuery->where('id',$id);
        $category = $CategoryQuery->get();
        return response()->josn([
            'message' => $category,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Category $category, $id)
    {
        $category = Category::query()->get();
        $name = $request->input('name');
        if($name != null and $id != 0 and $id <= count($category))//not sure of this one
        {
            Category::query()->find($id)->update([
                'name' => $name,
            ]);
            return response()->json(['message' => 'successfully updated']);
        }
        return response()->json(['message' => 'it should not be empty or invalid id']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category, $id)
    {
        $CategoryQuery = Category::query();
        $category = $CategoryQuery->get();
        $size = count($category);
        if($id>$size or $size == 0 or $id == 0)//not sure of this one
            return response()->json(['message' => 'id not found']);

        $category = $CategoryQuery->find($id);
        $category->delete();
        return response()->json(['message' => 'successfully deleted']);
    }
}
