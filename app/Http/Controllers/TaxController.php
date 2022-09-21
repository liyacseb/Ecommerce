<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaxRequest;
use App\Http\Requests\TaxUpdateRequest;
use App\Repositories\TaxRepository;

class TaxController extends Controller
{
    public $taxRepo;
    public function __construct(TaxRepository $taxRepo)
    {
        $this->taxRepo =$taxRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.tax.taxList');
    }
    public function taxListing()
    {
        return $this->taxRepo->gettaxlist();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function taxcreate()
    {
        return view('admin.tax.taxAdd');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function taxstore(TaxRequest $request)
    {
        $data = $this->taxRepo->taxstore($request->all());
        if($data>0){
            return response()->json(['data'=>$data,'message'=>'Succesfully Created']);
        }else{
            return response()->json(['data'=>$data,'message'=>"Can't Create"]);
        }
    }

    public function taxedit($id)
    {
        $curntdata = $this->taxRepo->taxfetch($id);
        return view('admin.tax.taxEdit',compact(['curntdata']));
    }

    public function taxupdate(TaxUpdateRequest $request, $id)
    {
        $data = $this->taxRepo->taxupdate($request->all(),$id);
        return response()->json(['data'=>$data,'message'=>'Succesfully updated']);
    }

    public function taxdestroy($id)
    {
        $taxexist = $this->taxRepo->taxexist($id);
        if($taxexist==0){
            $data = $this->taxRepo->taxdestroy($id);
            return redirect('admin/tax/tax-list')->withSuccess('Deleted Succesfully');
        }else{
            return redirect('admin/tax/tax-list')->with('errors',"Can't delete.Some Products are used this tax");
        }
    }
    public function test(){
        return view('admin.crop3');
    }

}
