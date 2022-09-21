<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\WalletPayment;
use Yajra\DataTables\Facades\DataTables;

class AdminUserRepository 
{
    public function getUsers(){
        $data = User::orderBy('id','desc')->get();
        
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                    $actionBtn = '<a class="btn btn-primary btn-sm " title="view user" href="'.route('userview',$row['id']).'" >
                        <i class="fas fa-eye"></i>
                    </a>';
                return $actionBtn;
            })
            ->addColumn('created', function($row){
                $date = date_create($row['created_at']);
                $created=date_format($date,'d-m-Y');
                return $created;
            })
            ->addColumn('totalorder', function($row){
                
                return Order::where('user_id',$row['id'])->count();
            })
            ->rawColumns(['action','created','totalorder'])
            ->make(true);
    }
    public function getUserDetail($id){
        return User::find($id);
    }
    public function getUserAddressDetail($id){
        return UserAddress::where('user_id',$id)->get();
    }
    public function getUserOrders($id){
        // return Exam::all();
        $data = Order::where('user_id',$id)->orderBy('id','desc')->get();
        
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                    $actionBtn = '<a class="btn btn-secondary btn-sm " target="_blank" title="view order" href="'.route('orderview',$row['id']).'" >
                        <i class="fas fa-eye"></i>
                    </a>';
                return $actionBtn;
            })
            ->addColumn('date', function($row){
                $date=date_create($row['order_date']);
                return date_format($date,'d-m-Y');
            })
            ->addColumn('ordernumber', function($row){
                return '# '.$row['id'];
            })
             ->rawColumns(['action','date','ordernumber'])
            ->make(true);
    }
    public function getWalletTransactions($id){
        // return Exam::all();
        $data = WalletPayment::where('user_id',$id)->orderBy('id','desc')->get();
        
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('date', function($row){
                $date=date_create($row['payment_date']);
                return date_format($date,'d-m-Y');
            })
            ->addColumn('responsedet', function($row){
                $json_decoded = json_decode($row['response']);
                $responsedet='';
                foreach($json_decoded as $key=>$result)
                    $responsedet.='<p> '.$key.' : '.$result.'</p>';
                return $responsedet;
            })
             ->rawColumns(['responsedet','date'])
            ->make(true);
    }
}