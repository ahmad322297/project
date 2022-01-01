<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Product $product)
    {
        $comments = $product->comments()->get();
        return response()->json([
            'message' => $comments
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
        $request->validate([
            'value' => ['required','string','min:1','max:400']
        ]);
        $comment = $product->comments()->create([
            'value' => $request->value,
            'user_id' => Auth::id()
        ]);
        return response()->json([
            'message' => $comment
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Product $product, Comment $comment, $comment_id)
    {
        $comment_user_id = $product->comments()->find($comment_id)->user_id;
        $user_id = Auth()->user()->id;
        if($comment_user_id != $user_id)
            return response()->json([
                'message' => 'you do not have permission to update this comment'
            ]);

        $request->validate([
            'value' => ['required','string','min:1','max:400']
        ]);
        $product->comments()->find($comment_id)->update([
            'value' => $request->value,
        ]);
        return response()->json([
            'message' => 'updated successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Comment $comment, Product $product, $comment_id)
    {
        $comment_user_id = $product->comments()->find($comment_id)->user_id;
        $user_id = Auth()->user()->id;
        if($comment_user_id != $user_id)
            return response()->json([
                'message' => 'you do not have permission to delete this comment'
            ]);

        $product->comments()->find($comment_id)->delete();
        return response()->json([
            'message' => 'successfully deleted'
        ]);
    }
}
