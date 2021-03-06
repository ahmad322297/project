<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public $with = ['category','user','discounts','comments','likes'];
    public $withCount = ['comments','likes'];
    protected $table = 'products';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'name',
        'img_url',
        'exp_date',
        'category_id',
        'quantity',
        'price',
        'user_id',
        'views',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function discounts(){
        return $this->hasMany(Discount::class, 'product_id')->orderBy('date');
    }

    public function comments(){
        return $this->hasMany(Comment::class, 'product_id')->orderBy('created_at');
    }

    public function likes(){
        return $this->hasMany(Like::class, 'product_id')->orderBy('updated_at');
    }
}
