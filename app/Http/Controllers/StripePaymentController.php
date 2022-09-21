<?php

namespace App\Http\Controllers;

use App\Repositories\CartRepository;
use App\Repositories\CheckoutRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Stripe;

class StripePaymentController extends Controller
{
    public $cartRepo;
    public $checkoutRepo;
    public $cartcount;
    public function __construct(CartRepository $cartRepo,CheckoutRepository $checkoutRepo)
    {
        $this->cartRepo =$cartRepo;
        $this->checkoutRepo =$checkoutRepo;
      
        $this->middleware(function ($request, $next) {
            
            if(Auth::guard('user')->check()){
                $this->cartcount =$this->cartRepo->fetchCartCount();
            }else{
                $this->cartcount =0;
            }
            return $next($request);
        });
    }
    public function process(Request $request)
    {
      
        $token = $request->get('tokenId');

        Stripe::setApiKey(config('paymentcredentials.stripe.secret'));

        $stripe = Stripe::charges()->create([
            'source' => $request->get('tokenId'),
            'currency' => 'INR',
            'amount' => $request->get('amount') 
        ]);
        // try {
        //     return Stripe_Charges::create([
        //         'amount' => 1000,
        //         'currenct' => 'gbp',
        //         'description' => Auth::user()->email,
        //         'card' => $token,
        //     ]);
        // } catch(Stripe_CardError $e) {
        //     dd('card declined');
        // }
        $paymentmethod=2;
        $response=json_encode($stripe);
        if($stripe['status']=='succeeded'){
            $paymentStatus = 1;
            $paymentID= $this->checkoutRepo->stripePaymentStore($stripe['id'],$response,$paymentmethod,$paymentStatus);
        }else{
            $paymentStatus = 2;
            $paymentID=$this->checkoutRepo->paymentfail($paymentmethod,$paymentStatus,$response);
        }
        Session::forget('couponID');
        Session::forget('couponVal');
        Session::forget('hidCartId');
        Session::forget('addressID');
        Session::forget('grandtotal');
        Session::forget('paymentID');    
        Session::forget('paymentMethod');    
        return response()->json(['paymentID'=>$paymentID,'paymentStatus'=>$paymentStatus]);
    }
}
