<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $table = 'likes';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable =[
        'user_id',
        'product_id',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function product(){
        return $this->belongsTo(Product::class, 'Product_id');
    }
}
