<?php

namespace App\Repositories;

use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Payment;
use App\Models\PaymentFailure;
use App\Models\Stock;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CheckoutRepository 
{
    public function storepaymentDetails($paymentStatus,$data){ 
        // dd($data['response']) ;
        $orderID = $this->storeOrderDetail(1,$paymentStatus);
        $payment = new Payment();
        $payment->order_id = $orderID;
        $payment->response  = $data['response'];
        $payment->payment_id = $data['razorpay_payment_id'];
        $payment->signature_id = $data['razorpay_signature'];
        $payment->save();
        return $payment->id;
    }
    public function storeOrderDetail($paymentmethod,$paymentStatus){
        
        $hidCartId = Session::get('hidCartId');
        $cartAry = explode(',', $hidCartId);
        // return Cart::where('user_id',Auth::guard('user')->user()->id)
        // ->where('status',0)
        // ->whereIn('id',$cartAry)
        // ->get();
        $cart= Cart::with('getProduct','getProdColor','getProdSize','getStock')
            ->where('user_id',Auth::guard('user')->user()->id)
            ->whereIn('id',$cartAry)
            ->get();

        
        $addressID = Session::get('addressID');
        $address = UserAddress::find($addressID);

        $orders = new Order();
        $orders->payment_gateway = $paymentmethod;
        $orders->coupon_id =  Session::get('couponID');
        $orders->coupon_discount = Session::get('couponVal');
        $orders->user_id = Auth::guard('user')->user()->id;
        $orders->payment_status = $paymentStatus;
        $orders->grand_total = Session::get('grandtotal');
        $orders->name = $address['name'];
        $orders->phone_number = $address['phone_number'];
        $orders->company = $address['company'];
        $orders->adrs_line_1 = $address['adrs_line_1'];
        $orders->adrs_line_2 = $address['adrs_line_2'];
        $orders->pincode = $address['pincode']; 
        $orders->district = $address['district'];
        $orders->state = $address['state'];
        $orders->country = $address['country'];
        $orders->adress_type = $address['adress_type'];
        $orders->save();
        $orderID= $orders->id;

        //couponid status change
        $couponId =  Session::get('couponID');
        if($couponId!=0){
            $coupon = Coupon::find($couponId);
            $coupon->used_status = 1;
            $coupon->save();
        }

        // $total = 0 ;
        $price = 0 ;
        // $discounttotal = 0 ;
        // $offer = 0 ;
        foreach($cart as $cartval){
                        
            $orderDetail = new OrderDetail();
            $orderDetail->order_id = $orderID;
            $orderDetail->prod_id = $cartval['prod_id'];
            $orderDetail->product_name = $cartval->getProduct['product_name'];
            $orderDetail->product_code = $cartval->getProduct['product_code'];
            $orderDetail->cover_image = $cartval->getProduct['cover_image'];
            $orderDetail->color_id = $cartval['color_id'];
            $orderDetail->size_id = $cartval['size_id'];
            $orderDetail->actual_price = $cartval->getProduct['actual_price'];
            $orderDetail->offer_price = $cartval->getProduct['offer_price'];
            $orderDetail->prod_count = $cartval['prod_count'];
            $orderDetail->order_status = '0';
            $orderDetail->save();

            // cart delete
            $cartUpdate = Cart::find($cartval['id']);
            $cartUpdate->delete();
            if($paymentStatus==1){

                //decrement stock count
                $stockUpdate = Stock::find($cartval['stock_id']);
                $stockUpdate->stock -= $cartval['prod_count'];
                $stockUpdate->save();
            }
            // $total=$total+($price*$cartval['prod_count']);
            // $discounttotal = $discounttotal+($offer*$cartval['prod_count']);            
        }
        //Payment through wallet
        if($paymentmethod==3){
            $user  = User::find(Auth::guard('user')->user()->id);
            $user->wallet_amount -= Session::get('grandtotal');
            $user->save();
        }
        return $orderID;
    }
    public function paymentfail($paymentMethod,$paymentStatus,$data){
        $orderID = $this->storeOrderDetail($paymentMethod,$paymentStatus);
        $payment = new PaymentFailure();
        $payment->order_id = $orderID;
        $payment->response  = $data;
        $payment->save();
        return $payment->id;
    }
    public function stripePaymentStore($stripeID,$response,$paymentmethod,$paymentStatus){
        $orderID = $this->storeOrderDetail($paymentmethod,$paymentStatus);
        $payment = new Payment();
        $payment->order_id = $orderID;
        $payment->response  = $response;
        $payment->payment_id = $stripeID;
        $payment->signature_id ='';
        $payment->save();
        return $payment->id;
    }
}