<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'cat_id',
        'product_name',
        'description',
        'image_1',
        'image_2',
        'image_3',
        'image_4',
        'image_5',
        'image_6',
        'cover_img',
        'tax_id',
        'actual_price',
        'offer_price',
        'status',
    ];
    public function getTax(){
        return $this->belongsTo(Tax::class,'tax_id');
    }
    public function getallCategory(){
        return $this->belongsTo(Category::class,'cat_id');
    }
    public function getCategory(){
        return $this->belongsTo(Category::class,'cat_id')->where('category_status',1);
    }
}
