<?php

namespace App\Http\Controllers;

use App\Repositories\CartRepository;
use App\Repositories\CheckoutRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Razorpay\Api\Api;

class CheckoutController extends Controller
{
    public $cartRepo;
    public $checkoutRepo;
    public $cartcount;
    public function __construct(CartRepository $cartRepo,CheckoutRepository $checkoutRepo)
    {
        $this->cartRepo =$cartRepo;
        $this->checkoutRepo =$checkoutRepo;
      
        $this->categories =$this->cartRepo->fetchCategory();
        $this->websitecontact =$this->cartRepo->fetchwebsiteAddress();
        $this->middleware(function ($request, $next) {
            
            if(Auth::guard('user')->check()){
                $this->cartcount =$this->cartRepo->fetchCartCount();
            }else{
                $this->cartcount =0;
            }
            return $next($request);
        });
    }
    public function index(Request $request){
        $request->validate(
            [
            'checkout_address'=>'required'
            ],
            [
                'checkout_address.required'=>'Please chose address.'                
            ]
        );
        $addressID  = $request->get('checkout_address');

        Session::put('addressID',$addressID);
        return redirect(route('paymentform'));
    }
    public function paymentform(){
        $hidCartId  = Session::get('hidCartId');
        
        if( $hidCartId==null){
            return redirect(route('cart'));
        }
        $cartdet    = $this->cartRepo->getCheckoutCartDetails($hidCartId);        
        $cartcount = $this->cartcount;
        $categories = $this->categories;
        $websitecontact = $this->websitecontact;
        $walletAmount = $this->cartRepo->getUserWalletBalance();
        $walletAmount =  $walletAmount['wallet_amount'];
        return view('user.checkout_payment',compact(['cartcount','categories','cartdet','walletAmount','websitecontact']));
    }
    public function paymentfail(Request $request){
        $paymentMethod  = Session::get('paymentMethod');
        $paymentStatus='2';
        $paymentID    = $this->checkoutRepo->paymentfail($paymentMethod,$paymentStatus,$request->all());        
        Session::forget('couponID');
        Session::forget('couponVal');
        Session::forget('hidCartId');
        Session::forget('addressID');
        Session::forget('grandtotal');
        Session::forget('paymentID');    
        Session::forget('paymentMethod');    
        return response()->json(['paymentID'=>$paymentID,'paymentStatus'=>$paymentStatus]);
    }
    public function checkoutpayment(Request $request){
        $request->validate(
            [
            'payment'=>'required'
            ],
            [
                'payment.required'=>'Please chose payment method.'                
            ]
        );
        $paymentID  = $request->get('payment');
        $grandtotal  = $request->get('grandtotal');
        Session::put('paymentID',$paymentID);
        Session::put('grandtotal',$grandtotal);
        //Razorpay
        if($paymentID=='1' ){
            if($grandtotal>1){
                $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $charactersLength = strlen($characters);
                $randomString = '';
                for ($i = 0; $i < 8; $i++) {
                    $randomString .= $characters[rand(0, $charactersLength - 1)];
                }
                $orderData = [
                    'receipt'         => $randomString,
                    'amount'          => ($grandtotal*100), // 39900 rupees in paise
                    'currency'        => 'INR'
                ];
                $api = new Api(config('paymentcredentials.razor.key'), config('paymentcredentials.razor.secret'));
                // $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
                $razorpayOrder = $api->order->create($orderData);
                Session::put('razorpayOrder',$razorpayOrder['id']);
            }else{
                return redirect()->back()->with('paymentErrorMessage', 'The amount must be atleast INR 1.00');
            }
        }
        Session::put('paymentMethod',$paymentID);
        return redirect(route('orderPreview'));

    }
    public function orderPreview(){
        $addressID  = Session::get('addressID');
        $hidCartId  = Session::get('hidCartId');
        if($addressID==null || $hidCartId==null){
            return redirect(route('cart'));
        }
        $cartdet    = $this->cartRepo->getCheckoutCartDetails($hidCartId);        
        $addressdet    = $this->cartRepo->getaddressDetail($addressID);        
        $cartcount = $this->cartcount;
        $categories = $this->categories;
        $websitecontact = $this->websitecontact;
        $razorpayKey = config('paymentcredentials.razor.key');
        $stripeKey = config('paymentcredentials.stripe.key');
        // $razorpayKey = env('RAZORPAY_KEY');
        return view('user.order_preview',compact(['cartcount','categories','cartdet','addressdet','razorpayKey','stripeKey','websitecontact']));
    }
}
