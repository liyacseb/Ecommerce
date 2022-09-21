<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\UserAddress;
use App\Models\WalletPayment;
use App\Models\WalletPaymentFailed;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserAccountRepository 
{
    public function changepswd($data){
        // dd($data);
        // dd($data['oldpswd']);
        return  User::where('id', Auth::guard('user')->user()->id)
        ->update(['password' => Hash::make($data['password'])]);
        
    }
    // public function fetchCountry(){
    //     return DB::table('countries')->where('id',101)->get();
    // }
    // public function fetchStates(){
    //     return DB::table('states')->where('country_id',101)->get();
    // }
    public function profileUpdate($data){
        $user = User::find(Auth::guard('user')->user()->id);
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->phone_number = $data['mob'];
        $user->save();
        return $user;
    }
    public function fetchUserAddress(){
        return UserAddress::where('user_id',Auth::guard('user')->user()->id)->get();
    }
    public function addressstore($data){
        $userAddress = new UserAddress();
        $userAddress->user_id = Auth::guard('user')->user()->id;
        $userAddress->name = $data['name'];
        $userAddress->phone_number = $data['phone_number'];
        $userAddress->company = $data['company'];
        $userAddress->adrs_line_1 = $data['adrs_line_1'];
        $userAddress->adrs_line_2 = $data['adrs_line_2'];
        $userAddress->pincode = $data['zip'];
        $userAddress->district = $data['district'];
        $userAddress->state = $data['state'];
        $userAddress->country = $data['country'];
        $userAddress->adress_type = $data['addressType'];
        $userAddress->save();
        return $userAddress->id;
    }
   
    public function getuseraddress($id){
        return UserAddress::find($id);
    }
    public function addressupdate($data){
        $userAddress = UserAddress::find($data['adderssIdHid']);
        $userAddress->name = $data['name'];
        $userAddress->phone_number = $data['phone_number'];
        $userAddress->company = $data['company'];
        $userAddress->adrs_line_1 = $data['adrs_line_1'];
        $userAddress->adrs_line_2 = $data['adrs_line_2'];
        $userAddress->pincode = $data['zip']; 
        $userAddress->district = $data['district'];
        $userAddress->state = $data['state'];
        $userAddress->country = $data['country'];
        $userAddress->adress_type = $data['addressType'];
        $userAddress->save();
        return $userAddress;
    }
    public function getuserwallet(){
        return User::where('id',Auth::guard('user')->user()->id)->select('wallet_amount')->get();
    }
    public function storepaymentDetails($data){ 
        $userWallet = User::find(Auth::guard('user')->user()->id);
        $userWallet->wallet_amount += $data['amount'];
        $userWallet->save();

        $payment = new WalletPayment();
        $payment->user_id = Auth::guard('user')->user()->id;
        $payment->amount = $data['amount'];
        $payment->response  = $data['response'];
        $payment->payment_id = $data['razorpay_payment_id'];
        $payment->save();
        return $payment->id;
    }
    public function paymentfail($amount,$response){
        $payment = new WalletPaymentFailed();
        $payment->user_id = Auth::guard('user')->user()->id;
        $payment->amount = $amount;
        $payment->response  = $response;
        $payment->save();
        return $payment->id;
    }
}