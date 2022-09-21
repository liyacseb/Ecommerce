<?php

namespace App\Http\Controllers;

use App\Repositories\AdminOrderRepository;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public $adminOrderRepo;
    public function __construct(AdminOrderRepository $adminOrderRepo)
    {
        $this->adminOrderRepo =$adminOrderRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.order.orderList');
    }
    public function orderListing()
    {
        return $this->adminOrderRepo->getOrders();
    }
    public function orderview($orderid)
    {
        $orderDetail= $this->adminOrderRepo->fetchOrderDetail($orderid);
        $paymentDetail = null;
        $userDetail =$this->adminOrderRepo->fetchUserDetail($orderDetail[0]['getOrderDetail']['user_id']);

        if($orderDetail[0]['getOrderDetail']['payment_gateway']!=4 && $orderDetail[0]['getOrderDetail']['payment_gateway']!=3)
        {
            $payment_status = $orderDetail[0]['getOrderDetail']['payment_status'];
            
            $paymentDetail=$this->adminOrderRepo->fetchPaymentDetail($orderid,$payment_status);
        }
        return view('admin.order.orderView',compact(['orderDetail','paymentDetail','userDetail']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   
    public function orderupdate(Request $request)
    {
        $data = $this->adminOrderRepo->orderupdate($request->all());
        return response()->json(['data'=>$data,'message'=>'Succesfully updated']);
    }
    public function paymentupdate(Request $request)
    {
        $data = $this->adminOrderRepo->paymentupdate($request->all());
        return response()->json(['data'=>$data,'message'=>'Succesfully updated']);
    }

    

}
