<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'product_name',
        'product_code',
        'cover_image',
        'color_id',
        'size_id',
        'actual_price',
        'offer_price',
        'prod_count',        
        'order_status',
        'prod_id'
    ];


    public function getOrderDetail(){
        return $this->belongsTo(Order::class,'order_id');
    }
    public function getColor(){
        return $this->belongsTo(Color::class,'color_id');
    }
    public function getSize(){
        return $this->belongsTo(Size::class,'size_id');
    }
   
   
}
