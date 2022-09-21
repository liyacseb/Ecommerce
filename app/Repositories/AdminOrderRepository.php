<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Payment;
use App\Models\PaymentFailure;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;


class AdminOrderRepository 
{
    public function getOrders(){
        // return Exam::all();
        $data = Order::orderBy('id','desc')->get();
        
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                    $actionBtn = '<a class="btn btn-secondary btn-sm " title="view order" href="'.route('orderview',$row['id']).'" >
                        <i class="fas fa-eye"></i>
                    </a>';
                return $actionBtn;
            })
            ->addColumn('userdetails', function($row){
                    $user=User::where('id',$row['user_id'])->first();
                    $actionBtn = $user->name.'<br>'. $user->email;
                return $actionBtn;
            })
            ->addColumn('date', function($row){
                $date=date_create($row['order_date']);
                return date_format($date,'d-m-Y');
            })
            ->addColumn('paidstatus', function($row){
                if($row['payment_status']==1){
                    return '<span class="badge badge-success">Paid</span>';
                }else{
                    return '<span class="badge badge-info">Unpaid</span>';
                }
            })
            ->addColumn('orderstatus', function($row){
                $order=OrderDetail::where('order_id',$row['id'])->get();
                $row=0;
                foreach($order as $orderVal){
                    if($orderVal['order_status']!=2){
                        $row++;
                    }
                }
                $orderstatus = 'Completed';
                if($row>0){
                    $orderstatus='Pending';
                }
                return $orderstatus;
            })
            ->addColumn('ordernumber', function($row){
                return '# '.$row['id'];
            })
             ->rawColumns(['action','userdetails','date','ordernumber','paidstatus','orderstatus'])
            ->make(true);
    }
    public function fetchOrderDetail($orderID){
        return OrderDetail::with('getOrderDetail','getColor','getSize')->where('order_id',$orderID)->get();
    }
    public function fetchUserDetail($userID){
        return User::where('id',$userID)->first();
    }
    public function fetchPaymentDetail($orderid,$payment_status){
        if($payment_status==1){
            //payment success
            return Payment::where('order_id',$orderid)->get();            
        }
        if($payment_status==2){
            //payment failed
            return PaymentFailure::where('order_id',$orderid)->get();  
        }
    }
    public function orderupdate($data){
        $orderDet = OrderDetail::find($data['orderDetID']);
        $orderDet->order_status = max($data['status']);
        $orderDet->Save();
        return $orderDet;
    }
    public function paymentupdate($data){
        $order = Order::find($data['orderID']);
        $order->payment_status = $data['status'];
        $order->Save();
        return $order;
    }
}