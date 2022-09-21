<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Auth;

class OrderRepository 
{
    public function fetchOrders(){
        return Order::where('user_id',Auth::guard('user')->user()->id)->get();
    }
    public function fetchOrderDetail($orderID){
        return OrderDetail::with('getOrderDetail','getColor','getSize')->where('order_id',$orderID)->get();
    }
}