<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Carbon\Carbon;
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

        $name = $request->query('name');
        $category_id = $request->query('category_id');
        $exp_date = $request->query('exp_date');
        $sort = $request->query('sort');

        if($name != null)
            $ProductQuery->where('name', 'like', '%'.$name.'%');
        else if($category_id != null)
            $ProductQuery->where('category_id', $category_id);
        else if($exp_date != null)
            $ProductQuery->where('exp_date', $exp_date);
        $products = $ProductQuery->get();

        if($sort != null)
        {
            if($sort == 'views')
                $products = $products->sortBy('views');
            else if($sort == 'likes')
                $products = $products->sortBy('likes_count');
            else if($sort == 'comments')
                $products = $products->sortBy('comments_count');
        }

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

        $product = Product::query()->create([
            'name' => $name,
            'img_url' => $img_url,
            'exp_date' => $exp_date,
            'category_id' => $category_id,
            'quantity' => $quantity,
            'price' => $price,
            'user_id' => Auth()->user()->id,
        ]);

        foreach($request->list_discounts as $discount){
            $product->discounts()->create([
                'date' => $discount['date'],
                'discount_percentage' => $discount['discount_percentage'],
            ]);
        }

        return response()->json(['message' => 'successfully stored']);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Product $product
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Product $product, $id)
    {
        $ProductQuery = Product::query();
        $product = $ProductQuery->find($id);
        $product->increment('views');

        $discounts = $product->discounts()->get();
        $maxDiscount = null;
        foreach($discounts as $discount)
            if(Carbon::parse($discount['date']) <= now())
                $maxDiscount = $discount;
        if(!is_null($maxDiscount))
        {
            $discount_value = ($product->price * $maxDiscount['discount_percentage'])/100;
            $product['current_price'] = $product->price - $discount_value;
        }

        return response()->json([
            'message' => $product
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Product $product, $id)
    {
        $ProductQuery = Product::query();
        $product = $ProductQuery->find($id);

        $product_user_id = $product['user']['id'];
        $user_id = Auth()->user()->id;
        if($product_user_id != $user_id)
            return response()->json(['message' => 'you do not have permission to update this product']);

        $name = $request->input('name');
        $img_url = $request->input('img_url');
        $category_id = $request->input('category_id');
        $phone_number = $request->input('phone_number');
        $quantity = $request->input('quantity');
        $price = $request->input('price');

        if($name != null)
            $product->update([
                'name' => $name
            ]);
        if($img_url != null)
            $product->update([
                'img_url' => $img_url
            ]);
        if($category_id != null)
            $product->update([
                'category_id' => $category_id
            ]);
        if($phone_number != null)
            $product->user()->update([
                'phone_number' => $phone_number
            ]);
        if($quantity != null)
            $product->update([
                'quantity' => $quantity
            ]);
        if($price != null)
            $product->update([
                'price' => $price
            ]);

        if($name == null and $img_url == null and $category_id == null and $phone_number == null
            and $quantity == null and $price == null)
            return response()->json(['message' => 'you should update one field']);

        return response()->json(['message' => 'successfully updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Product $product
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Product $product, $id)
    {
        $ProductQuery = Product::query();
        $product = $ProductQuery->find($id);

        $product_user_id = $product['user']['id'];
        $user_id = Auth()->user()->id;
        if($product_user_id != $user_id)
            return response()->json(['message' => 'you do not have permission to delete this product']);

        $product->delete();
        return response()->json(['message' => 'successfully deleted']);
    }
}
