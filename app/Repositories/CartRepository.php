<?php

namespace App\Repositories;

use App\Models\Cart;
use App\Models\Contact;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\Size;
use App\Models\Stock;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Support\Facades\Auth;

class CartRepository 
{
    public function updateCart($data){
        // dd($data);
        
        if($data['sizeExist']==0){
            $sizeID=0;
        }else{
            $sizeID=$data['sizeID'];
        }
        $stockdata = Stock::select('*')
            ->where('prod_id',$data['prodid'])
            ->where('color_id',$data['colorID'])
            ->where('size_id', $sizeID)
            ->where('stock', '!=', '0')
            ->get();
        if(count($stockdata)>0)
        {
           /* $stock = Stock::find($stockdata[0]['id']);
            $stock->stock -= 1;
            $stock->save();
            */
        }else{
            // out of stock
            return -1;
        }
        $cart = Cart::where('prod_id',$data['prodid'])
            ->where('user_id',Auth::guard('user')->user()->id)
            ->where('color_id',$data['colorID'])
            ->where('size_id', $sizeID)->first();
        if($cart){
            // increment cart product quantity
            /*$cart = Cart::find($cart->id);
            $cart->prod_count += 1;
            $cart->status = 0;
            $cart->save();*/
        }else{
            $cart = new Cart();
            $cart->user_id = Auth::guard('user')->user()->id;
            $cart->prod_id = $data['prodid'] ;
            $cart->color_id = $data['colorID'] ;
            $cart->size_id = $sizeID;
            $cart->stock_id = $stockdata[0]['id'] ;
            $cart->prod_count = 1;
            $cart->save();
        }
        return Cart::where('user_id',Auth::guard('user')->user()->id)
        ->count();
    }
    public function fetchCartCount(){
        return Cart::where('user_id',Auth::guard('user')->user()->id)
        ->count();
    }
    public function fetchCategory(){
        return Product::with(['getCategory'=>function($query){
            return $query->where('category_status','1')->get();

        }])->selectRaw('cat_id,count(*) as productcount')->where('status','1')->groupBy('cat_id')->get();
    }
    public function fetchwebsiteAddress(){
        return Contact::find(1);
    }
    public function fetchCartProducts(){
        return Cart::with('getProduct','getProdColor','getProdSize','getStock')
        ->where('user_id',Auth::guard('user')->user()->id)
        ->get();
        
    }
    public function guestAddToCart($data){
        
        $sizeID=$data['sizeID'];
        
        $cart = Cart::where('prod_id',$data['prodid'])
            ->where('user_id',Auth::guard('user')->user()->id)
            ->where('color_id',$data['colorID'])
            ->where('size_id', $sizeID)->first();
        if($cart){
            /*$cart = Cart::find($cart->id);
            $cart->prod_count += 1;
            $cart->save();*/
        }else{
            $stockdata = Stock::select('*')
            ->where('prod_id',$data['prodid'])
            ->where('color_id',$data['colorID'])
            ->where('size_id', $sizeID)
            ->where('stock', '!=', '0')
            ->get();
            if(count($stockdata)>0){
                $cart = new Cart();
                $cart->user_id = Auth::guard('user')->user()->id;
                $cart->prod_id = $data['prodid'] ;
                $cart->color_id = $data['colorID'] ;
                $cart->size_id = $sizeID;
                $cart->stock_id = $stockdata[0]['id'] ;
                $cart->prod_count = 1;
                $cart->save();
            }
        }
    }
    public function deletecart($id){
        $cart = Cart::find($id);
        $cart->delete();
        return $cart;
    }
    public function fetchSizes(){
        return Size::get();
    }
    public function couponapply($data){
        $coupon= Coupon::where('coupon_code',$data['coupon'])
            ->where('status',1)
            ->where('user_id',Auth::guard('user')->user()->id)
            ->get();
        return $coupon;
        /*if(isset($coupon[0]['used_status'])){
            // coupon exist
            if($coupon[0]['used_status']==0){
                //unused coupon
                return $coupon[0]['id'];
            }else{
                // used coupon
                return 0;
            }
        }else{
            // coupon doesn't exist
            return -1;
        }*/
    }
    public function updatecartcount($data){
        // dd($data['cartID']);
        $cart = Cart::find($data['cartID']);

        $stockdata = Stock::select('*')
            ->where('prod_id',$cart['prod_id'])
            ->where('color_id',$cart['color_id'])
            ->where('size_id', $cart['size_id'])
            ->where('stock', '!=', '0')
            ->get();
        // dd($stockdata);
        if(count($stockdata)>0)
        {
            if($data['count']>$stockdata[0]['stock']){
                $result['data'] =-2;
                $result['stock'] = $cart['prod_count'];
                return $result;
                // return -2;
            }else{
                $cart = Cart::find($data['cartID']);
                $cart->prod_count = $data['count'];
                $cart->save();
                return $cart;
            }
        }else{
            // out of stock
            return -1;
        }
    

    }
    public function getCheckoutCartDetails($hidCartId){
        $cartAry = explode(',', $hidCartId);
        // return Cart::where('user_id',Auth::guard('user')->user()->id)
        // ->where('status',0)
        // ->whereIn('id',$cartAry)
        // ->get();
        return Cart::with('getProduct','getProdColor','getProdSize','getStock')
        ->where('user_id',Auth::guard('user')->user()->id)
        ->whereIn('id',$cartAry)
        ->get();
        
    }
    public function getaddressDetail($addressID){
        return UserAddress::find($addressID);
    }
    public function getUserWalletBalance(){
        return User::find(Auth::guard('user')->user()->id);
    }
   
}