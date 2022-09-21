<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'payment_gateway',
        'coupon_discount',
        'amount',
        'payment_status',
        'order_date',
        'name',
        'phone_number',
        'company',
        'adrs_line_1',
        'adrs_line_2',
        'pincode',
        'district',
        'state',
        'country',
        'adress_type'
    ];
    
    protected $appends = ['address','addressdetail'];

    public function getAddressAttribute()
    {
        return $this->name.'</br>'.$this->phone_number.'</br>'.$this->company;
    }
    public function getAddressdetailAttribute()
    {
        return $this->adrs_line_1.','.$this->adrs_line_2;
    }

}
