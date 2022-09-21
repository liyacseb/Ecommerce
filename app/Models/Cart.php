<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'prod_id',
        'color_id',
        'size_id',
        'prod_count',
        'stock_id',
        'status'
    ];
    public function getProduct(){
        return $this->belongsTo(Product::class,'prod_id')->with('getCategory');
    }
    public function getProdColor(){
        return $this->belongsTo(Color::class,'color_id');
    }
    public function getProdSize(){
        return $this->belongsTo(Size::class,'size_id');
    }
    public function getStock(){
        return $this->belongsTo(Stock::class,'stock_id');
    }
   
}
