<?php

namespace App\Http\Controllers;

use App\Repositories\CartRepository;
use App\Repositories\UserAccountRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public $cartRepo;
    public $useraccountRepo;
    public $cartcount;
    public function __construct(CartRepository $cartRepo,UserAccountRepository $useraccountRepo)
    {
        $this->cartRepo =$cartRepo;
        $this->useraccountRepo =$useraccountRepo;
      
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
    public function index(){
        Session::forget('couponID');
        Session::forget('couponVal');
        Session::forget('hidCartId');
        Session::forget('addressID');
        Session::forget('grandtotal');
        Session::forget('paymentID');
        Session::forget('paymentMethod');

        $data = $this->cartRepo->fetchCartProducts();
        $size = $this->cartRepo->fetchSizes();
        $cartcount = $this->cartcount;
        $categories = $this->categories;
        $websitecontact = $this->websitecontact;
        return view('user.cart',compact(['data','cartcount','size','categories','websitecontact']));
    }
    public function deletecart($id){
        $data = $this->cartRepo->deletecart($id);
        return response()->json(['data'=>$data]);
    }
    public function couponapply(Request $request){
        $coupon=$this->cartRepo->couponapply($request->all());
        if(isset($coupon[0]['used_status'])){
            // coupon exist
            if($coupon[0]['used_status']==0){
                //unused coupon
                // return $coupon[0]['id'];
                return response()->json(['id'=>$coupon[0]['id'],'coupon_type'=>$coupon[0]['coupon_type'],'coupon_amount'=>$coupon[0]['coupon_amount']]);
            }else{
                // used coupon
                // return 0;
                return response()->json(['id'=>0]);
            }
        }else{
            // coupon doesn't exist
            // return -1;
            return response()->json(['id'=>-1]);
        }
        
    }
    public function updateCartCount(Request $request){
        $data = $this->cartRepo->updatecartcount($request->all());
        return response()->json(['data'=>$data['data'],'stock'=>$data['stock']]);
    }

    public function checkout(Request $request){
        // dd($request->all());
        $couponID   = $request->get('couponIdHid');
        $hidCartId  = $request->get('hidCartId');
        $couponVal  = $request->get('couponHid');
        // dd($cartdet);
        Session::put('couponID',$couponID);
        Session::put('couponVal',$couponVal);
        Session::put('hidCartId',$hidCartId);
       return redirect(route('checkoutAddress'));
        
    }
    public function checkoutAddress(){
        $hidCartId  = Session::get('hidCartId');
        if($hidCartId==null){
            return redirect(route('cart'));
        }
        $cartdet    = $this->cartRepo->getCheckoutCartDetails($hidCartId);
        $cartcount = $this->cartcount;
        $categories = $this->categories;
        $websitecontact = $this->websitecontact;
        $addressDet = $this->useraccountRepo->fetchUserAddress();
        return view('user.checkout_address',compact(['cartcount','addressDet','cartdet','categories','websitecontact']));
    }
}