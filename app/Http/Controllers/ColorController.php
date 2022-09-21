<?php

namespace App\Http\Controllers;

use App\Http\Requests\ColorRequest;
use App\Http\Requests\ColorUpdateRequest;
use App\Repositories\ColorRepository;

class ColorController extends Controller
{
    public $colorRepo;
    public function __construct(ColorRepository $colorRepo)
    {
        $this->colorRepo =$colorRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.color.colorList');
    }
    public function colorListing()
    {
        return $this->colorRepo->getcolorlist();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function colorcreate()
    {
        return view('admin.color.colorAdd');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function colorstore(ColorRequest $request)
    {
        $data = $this->colorRepo->colorstore($request->all());
        if($data>0){
            return response()->json(['data'=>$data,'message'=>'Succesfully Created']);
        }else{
            return response()->json(['data'=>$data,'message'=>"Can't Create"]);
        }
    }

    public function coloredit($id)
    {
        $curntdata = $this->colorRepo->colorfetch($id);
        return view('admin.color.colorEdit',compact(['curntdata']));
    }

    public function colorupdate(ColorUpdateRequest $request, $id)
    {
        $data = $this->colorRepo->colorupdate($request->all(),$id);
        return response()->json(['data'=>$data,'message'=>'Succesfully updated']);
    }

    public function colordestroy($id)
    {
        $colorexist = $this->colorRepo->colorexist($id);
        if($colorexist==0){
            $data = $this->colorRepo->colordestroy($id);
            return redirect('admin/color/color-list')->withSuccess('Deleted Succesfully');
        }else{
            return redirect('admin/color/color-list')->with('errors',"Can't delete.Some Products are used this color");
        }
    }

}
