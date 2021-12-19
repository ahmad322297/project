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
        $exp_date = $request->input('exp_date');
        $img_url = $request->input('img_url');
        $quantity = $request->input('quantity');
        $price = $request->input('price');
        $category_id = $request->input('category_id');

        Product::query()->create([
            'name' => $name,
            'exp_date' => $exp_date,
            //'img_url' => $img_url,
            'quantity' => $quantity,
            'price' => $price,
            //'category_id' => $category_id,
            //'user_id' => $user_id,
        ]);
        return response()->json(['message' => 'successfully stored']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Product $product, $id)
    {
        $ProductQuery = Product::query();
        $ProductQuery->where('id',$id);
        $product = $ProductQuery->get();
        return response()->json([
            'message' => $product
        ]);
    }

    /**
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
        $quantity = $request->input('quantity');
        $price = $request->input('price');
        $category_id = $request->input('category_id');

        Product::query()->find($id)->update([
           'name' => $name,
           'img_url' => $img_url,
           'quantity' => $quantity,
           'price' => $price,
           'category_id' => $category_id,
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

        return response()->json(['message' => 'successfully deleted']);
    }
}
