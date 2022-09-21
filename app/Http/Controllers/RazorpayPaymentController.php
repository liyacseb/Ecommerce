<?php

namespace App\Http\Controllers;

use App\Repositories\CartRepository;
use App\Repositories\CheckoutRepository;
use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class RazorpayPaymentController extends Controller
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

    public function store(Request $request)
    {
        
        $success = true;

        $error = "Payment Failed";

        if (empty($_POST['razorpay_payment_id']) === false)
        {
            $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

            try
            {
                // Please note that the razorpay order ID must
                // come from a trusted source (session here, but
                // could be database or something else)
                $attributes = array(
                    'razorpay_order_id' => $request->get('razorpay_order_id'),
                    'razorpay_payment_id' => $request->get('razorpay_payment_id') ,
                    'razorpay_signature' => $request->get('razorpay_signature') 
                );
                $api->utility->verifyPaymentSignature($attributes);
            }
            catch(SignatureVerificationError $e)
            {
                $success = false;
                $error = 'Razorpay Error : ' . $e->getMessage();
            }
        }
        
        if ($success === true)
        {
            $html = "<p>Your payment was successful</p>
                    <p>Payment ID: {$_POST['razorpay_payment_id']}</p>";
            $paymentStatus = 1;
            $paymentID = $this->checkoutRepo->storepaymentDetails($paymentStatus,$request->all());
        }
        else
        {
            $html = "<p>Your payment failed</p>
                    <p>{$error}</p>";
            $paymentStatus = 2;
            $paymentMethod=Session::get('paymentMethod');
            $paymentID = $this->checkoutRepo->paymentfail($paymentMethod,$paymentStatus,$error);
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
