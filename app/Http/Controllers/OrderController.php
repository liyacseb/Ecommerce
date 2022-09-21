<?php

namespace App\Http\Controllers;

use App\Repositories\CartRepository;
use App\Repositories\CheckoutRepository;
use App\Repositories\OrderRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Order;

class OrderController extends Controller
{
    public $cartRepo;
    public $checkoutRepo;
    public $cartcount;
    public $orderRepo;
    public function __construct(CartRepository $cartRepo,OrderRepository $orderRepo,CheckoutRepository $checkoutRepo)
    {
        $this->cartRepo =$cartRepo;
        $this->orderRepo =$orderRepo;
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
    public function index(){
        $cartcount = $this->cartcount;
        $categories = $this->categories;
        $websitecontact = $this->websitecontact;
        $orderdetails   =   $this->orderRepo->fetchOrders();
        return view('user.orders',compact(['cartcount','categories','orderdetails','websitecontact'])); 
    }
    // cash on delivery order details store
    public function store(Request $request){
        $paymentmethod = 4;
        $paymentStatus = '0';
        $orderID=$this->checkoutRepo->storeOrderDetail($paymentmethod,$paymentStatus);
        Session::forget('couponID');
        Session::forget('couponVal');
        Session::forget('hidCartId');
        Session::forget('addressID');
        Session::forget('grandtotal');
        Session::forget('paymentID');    
        Session::forget('paymentMethod');    
        return response()->json(['orderID'=>$orderID]);
    }
    // wallet - order details store
    public function walletpaymentprocess(Request $request){
        $paymentmethod = 3;
        $paymentStatus = '1';
        $orderID=$this->checkoutRepo->storeOrderDetail($paymentmethod,$paymentStatus);
        $this->paymentSessionsDestroy();           
        return response()->json(['orderID'=>$orderID]);
    }
    public function paymentSessionsDestroy(){
        Session::forget('couponID');
        Session::forget('couponVal');
        Session::forget('hidCartId');
        Session::forget('addressID');
        Session::forget('grandtotal');
        Session::forget('paymentID');    
        Session::forget('paymentMethod'); 
    }
   
   
    public function orderdetail($orderID){
        $cartcount = $this->cartcount;
        $categories = $this->categories;
        $websitecontact = $this->websitecontact;
        $orderdetails   =   $this->orderRepo->fetchOrderDetail($orderID);

        // $data = Order::findOrFail($orderID);
        // dd($data->addressdetail);
        if(count($orderdetails)>0){
            return view('user.order_details',compact(['cartcount','categories','orderdetails','websitecontact'])); 
        }else{
            return redirect()->back();
        }
    }
}
