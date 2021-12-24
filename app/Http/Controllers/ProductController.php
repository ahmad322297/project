<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $ProductQuery = Product::query();
        $products = $ProductQuery->get();
        return response()->json([
            'message' => $products
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
        $img_url = $request->input('img_url');
        $exp_date = $request->input('exp_date');
        $category_id = $request->input('category_id');
        $quantity = $request->input('quantity');
        $price = $request->input('price');

        Product::query()->create([
            'name' => $name,
            'img_url' => $img_url,
            'exp_date' => $exp_date,
            'category_id' => $category_id,
            'quantity' => $quantity,
            'price' => $price,
            //'user_id' => $user_id,
        ]);
        return response()->json(['message' => 'successfully stored']);
    }

    /*
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Product $product, $id)
    {
        $ProductQuery = Product::query();//add $id > count
        $ProductQuery->where('id',$id);
        $product = $ProductQuery->get();
        return response()->json([
            'message' => $product
        ]);
    }

    /*
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Product $product, $id)
    {
        $name = $request->input('name');
        $img_url = $request->input('img_url');
        $category_id = $request->input('category_id');
        $quantity = $request->input('quantity');
        $price = $request->input('price');

        //if($name != null)

        Product::query()->find($id)->update([
           'name' => $name,
           'img_url' => $img_url,
           'category_id' => $category_id,
           'quantity' => $quantity,
           'price' => $price,
        ]);
        return response()->json(['message' => 'successfully updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Product $product, $id)
    {
        $ProductQuery = Product::query();
        $prodcuts = $ProductQuery->get();
        $size = count($prodcuts);
        if($id>$size or $size == 0 or $id == 0)//not sure of this one
            return response()->json(['message' => 'id not found']);

        $prodcuts = $ProductQuery->find($id);
        $prodcuts->delete();
        return response()->json(['message' => 'successfully deleted']);
    }
}
