<?php

namespace App\Repositories;

use App\Models\Coupon;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;


class CouponRepository 
{
    public function getcouponlist(){
        // return Exam::all();
        $data = Coupon::get();
        
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $actionBtn ='<div class="" style="display:inline-flex">';
                    
                    if($row['used_status']=='0'){
                        $actionBtn .= '<a class="btn btn-info btn-sm actionedit m-2" title="edit coupon" href="'.route('couponedit',$row['id']).'" >
                        <i class="fas fa-pencil-alt"></i>
                    </a>';
                        $actionBtn.='<a class="btn btn-danger btn-sm actionDelete m-2" data-href="'.route('coupondestroy',$row['id']).'">
                            <i class="fas fa-trash"></i>
                        </a>';
                    }
                    $actionBtn .='</div >';
                return $actionBtn;
            })
            ->addColumn('amount', function($row){
                if($row['coupon_type']=='%'){
                    $actionBtn = $row['coupon_amount'].' '.$row['coupon_type'];
                }
                else{
                    $actionBtn = $row['coupon_type'].' '.$row['coupon_amount'];
                }
                return $actionBtn;
            })
            ->addColumn('used', function($row){
                if($row['used_status']=='0'){
                    $actionBtn = '<span class="text-info"> unused</span>';
                }
                else{
                    $actionBtn = '<span class="text-danger"> used</span>';
                }
                return $actionBtn;
            })
            ->addColumn('user', function($row){
                if($row['user_id']!='0'){
                    $user = User::find($row['user_id']);
                    $actionBtn = $user->name;
                }
                else{
                    $actionBtn = '';
                }
                return $actionBtn;
            })
             ->rawColumns(['action','amount','used','user'])
            ->make(true);
    }

    public function couponstore($data){
        $coupon = new Coupon() ;
        $coupon->coupon_code = $data['coupon_code'];
        $coupon->coupon_amount = $data['coupon_amount'];
        $coupon->coupon_type = $data['coupon_type'];
        $coupon->save();
        return $coupon->id;
    }
    public function coupondestroy($id){
        $coupon = Coupon::find($id);
        $coupon->delete();
        return $coupon;
    }
    public function couponfetch($id){
        return Coupon::find($id);
    }
    public function couponupdate($data,$id){
        $coupon = Coupon::find($id);
        $coupon->coupon_code = $data['coupon_code'];
        $coupon->coupon_amount = $data['coupon_amount'];
        $coupon->coupon_type = $data['coupon_type'];
        $coupon->save();
        return $coupon;
    }
    public function unlimitedcoupon($data)
    {
        $limit = $data['limit'];
        $amount = $data['amount'];
        $coupon_type = $data['coupon_type'];
        for($i=0;$i<$limit;$i++)
        {
            $code = $this->generateRandomString(5);
            $coupon = new Coupon() ;
            $coupon->coupon_code = $code;
            $coupon->coupon_amount = $amount;
            $coupon->coupon_type = $coupon_type;
            $coupon->save();
        }
        return $coupon->id;
    }
    public function generateRandomString($length) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        $count = Coupon::where('coupon_code',$randomString)->count();
        if($count==0){
            return $randomString;
        }else{
            $this->generateRandomString(5);
        }
    }
}