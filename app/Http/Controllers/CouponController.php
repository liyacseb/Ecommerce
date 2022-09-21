<?php

namespace App\Http\Controllers;

use App\Http\Requests\CouponRequest;
use App\Http\Requests\CouponUpdateRequest;
use App\Repositories\CouponRepository;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public $couponRepo;
    public function __construct(CouponRepository $couponRepo)
    {
        $this->couponRepo =$couponRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.coupon.couponList');
    }
    public function couponListing()
    {
        return $this->couponRepo->getcouponlist();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function couponcreate()
    {
        return view('admin.coupon.couponAdd');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function couponstore(CouponRequest $request)
    {
        $data = $this->couponRepo->couponstore($request->all());
        if($data>0){
            return response()->json(['data'=>$data,'message'=>'Succesfully Created']);
        }else{
            return response()->json(['data'=>$data,'message'=>"Can't Create"]);
        }
    }

    public function couponedit($id)
    {
        $curntdata = $this->couponRepo->couponfetch($id);
        return view('admin.coupon.couponEdit',compact(['curntdata']));
    }

    public function couponupdate(CouponUpdateRequest $request, $id)
    {
        $data = $this->couponRepo->couponupdate($request->all(),$id);
        return response()->json(['data'=>$data,'message'=>'Succesfully updated']);
    }

    public function coupondestroy($id)
    {
        $data = $this->couponRepo->coupondestroy($id);
        return redirect('coupon/coupon-list')->withSuccess('Deleted Succesfully');
    }
    public function unlimitedcoupon(Request $request){
        $data = $request->all();
        $this->couponRepo->unlimitedcoupon( $data);
        return response()->json(['status'=>1,'message'=>'Succesfully Created']);
    }

}
