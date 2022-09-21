<?php

namespace App\Http\Controllers;

use App\Repositories\BannerRepository;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public $bannerRepo;
    public function __construct(BannerRepository $bannerRepo)
    {
        $this->bannerRepo =$bannerRepo;
    }

    public function index()
    {
        return view('admin.banner.bannerList');
    }
    public function bannerListing()
    {
        return $this->bannerRepo->getbannerlist();
    }

    public function bannercreate()
    {
        return view('admin.banner.bannerAdd');
    }
    public function bannerstore(Request $request)
    {
        $data = $this->bannerRepo->bannerstore($request->all());
        if($data>0){
            return response()->json(['data'=>$data,'message'=>'Succesfully Created']);
        }else{
            return response()->json(['data'=>$data,'message'=>"Can't Create"]);
        }
    }
    public function banneredit($id){
        $curntdata = $this->bannerRepo->bannerfetch($id);
        return view('admin.banner.bannerEdit',compact(['curntdata']));
    }
    public function bannerupdate(Request $request,$id){
        $data = $this->bannerRepo->bannerupate($request->all(),$id);
        if($data>0){
            return response()->json(['data'=>$data,'message'=>'Succesfully Updated']);
        }else{
            return response()->json(['data'=>$data,'message'=>"Can't Update"]);
        }
    }
    public function bannerdestroy($id)
    {
        $bannercount = $this->bannerRepo->bannercount();
        if($bannercount>1){
            $data = $this->bannerRepo->bannerdestroy($id);
            return redirect('admin/banner/banner-list')->withSuccess('Deleted Succesfully');
        }else{
            return redirect('admin/banner/banner-list')->with('errors',"Atleast one banner should be active");
        }
    }
    public function availableBannerCheck(){
        $bannercount = $this->bannerRepo->bannercount();
        return response()->json(['bannercount'=>$bannercount]);
    }

}
