<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Http\Requests\UserChangePswdRequest;
use App\Repositories\CartRepository;
use App\Repositories\UserAccountRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Session;
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;


class CustomerAccountController extends Controller
{
    public $userAccntRepo;
    public $cartRepo;
    public function __construct(UserAccountRepository $userAccntRepo,CartRepository $cartRepo)
    {
        $this->userAccntRepo = $userAccntRepo;
        $this->cartRepo =$cartRepo;

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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $country = $this->userAccntRepo->fetchCountry();
        // $state = $this->userAccntRepo->fetchStates();
        $cartcount = $this->cartcount;
        $categories = $this->categories;
        $websitecontact = $this->websitecontact;
        $wallet = $this->userAccntRepo->getuserwallet();
        return view('user.customerAccount',compact(['cartcount','wallet','categories','websitecontact']));
    }
    public function profileUpdate(ProfileRequest $request){
        $data = $this->userAccntRepo->profileUpdate($request->all());
        return response()->json(['data'=>$data,'message'=>'Succesfully updated']);
    }
    public function changepassword()
    {
        $cartcount = $this->cartcount;
        $categories = $this->categories;
        $websitecontact = $this->websitecontact;
        return view('user.changePassword',compact(['cartcount','categories','websitecontact']));
    }
    public function submitChangePassword(UserChangePswdRequest $request){
        $credentials = $request->only('oldPassword');
        if(Auth::guard('user')->user())
        {
            $pass = Auth::guard('user')->user()->password;
        }
        if (!(Hash::check($request->get('oldPassword'), $pass))) {
            return response()->json(['status'=>0,'message'=>'Current password is not same']);
        }else{
            $this->userAccntRepo->changepswd($request->all());
            return response()->json(['status'=>1,'message'=>'Successfully updated the password']);
        }
    }
    public function addressstore(Request $request){
        $addressId = $this->userAccntRepo->addressstore($request->all());
        return response()->json(['addressid'=>$addressId]);
    }
    public function getuseraddress($id){
        $addressDet = $this->userAccntRepo->getuseraddress($id);
        return response()->json(['addressDet'=>$addressDet]);
    }
    public function addressupdate(Request $request){
        $addressId = $this->userAccntRepo->addressupdate($request->all());
        return response()->json(['addressid'=>$addressId]);
    }
    public function walletrazorpayordercreation(Request $request){
        $amount = $request->get('wallet');
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = 'wallet';
        for ($i = 0; $i < 5; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        $orderData = [
            'receipt'         => $randomString,
            'amount'          => ($amount*100), // 39900 rupees in paise
            'currency'        => 'INR'
        ];
        $api = new Api(config('paymentcredentials.razor.key'), config('paymentcredentials.razor.secret'));
        // $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        $razorpayOrder = $api->order->create($orderData);
        return response()->json($razorpayOrder['id']);
    }
    public function addwallet(Request $request){
        // do wallet store details
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
            $paymentID = $this->userAccntRepo->storepaymentDetails($request->all());
            return response()->json(['status'=>1]);
        }
        else
        {
            $html = "<p>Your payment failed</p>
                    <p>{$error}</p>";
            $paymentID = $this->userAccntRepo->paymentfail($request->get('amount'),$error);
            return response()->json(['status'=>0]);
        }
    }
    public function walletaddfailed(Request $request){
        $paymentID = $this->userAccntRepo->paymentfail($request->get('amount'),$request->get('response'));
        return response()->json(['status'=>0]);
    }
}
