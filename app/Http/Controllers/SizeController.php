<?php

namespace App\Http\Controllers;

use App\Http\Requests\SizeRequest;
use App\Http\Requests\SizeUpdateRequest;
use App\Repositories\SizeRepository;

class SizeController extends Controller
{
    public $sizeRepo;
    public function __construct(SizeRepository $sizeRepo)
    {
        $this->sizeRepo =$sizeRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.size.sizeList');
    }
    public function sizeListing()
    {
        return $this->sizeRepo->getsizelist();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function sizecreate()
    {
        return view('admin.size.sizeAdd');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sizestore(SizeRequest $request)
    {
        $data = $this->sizeRepo->sizestore($request->all());
        if($data>0){
            return response()->json(['data'=>$data,'message'=>'Succesfully Created']);
        }else{
            return response()->json(['data'=>$data,'message'=>"Can't Create"]);
        }
    }

    public function sizeedit($id)
    {
        $curntdata = $this->sizeRepo->sizefetch($id);
        return view('admin.size.sizeEdit',compact(['curntdata']));
    }

    public function sizeupdate(SizeUpdateRequest $request, $id)
    {
        $data = $this->sizeRepo->sizeupdate($request->all(),$id);
        return response()->json(['data'=>$data,'message'=>'Succesfully updated']);
    }

    public function sizedestroy($id)
    {
        $sizeexist = $this->sizeRepo->sizeexist($id);
        if($sizeexist==0){
            $data = $this->sizeRepo->sizedestroy($id);
            return redirect('admin/size/size-list')->withSuccess('Deleted Succesfully');
        }else{
            return redirect('admin/size/size-list')->with('errors',"Can't delete.Some Products are used this size");
        }
    }

}
