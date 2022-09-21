<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stock extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'size',
        'prod_id',
        'color_id',
        'size_id',
        'stock'
    ];
    public function getProduct(){
        return $this->belongsTo(Product::class,'prod_id')->where('deleted_at',null);
    }
}
