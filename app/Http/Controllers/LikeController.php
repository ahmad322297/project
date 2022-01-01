<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Product $product)
    {
        $likes = $product->likes()->get();
        return response()->json([
            'message' => $likes
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, Product $product)
    {
        if ($product->likes()->where('user_id', Auth::id())->exists())
            $product->likes()->where('user_id', Auth::id())->delete();
        else
            $product->likes()->create([
                'user_id' => Auth::id()
            ]);
        return response()->json(null);
    }
}
