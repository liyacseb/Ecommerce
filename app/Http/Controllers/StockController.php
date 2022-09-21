<?php

namespace App\Http\Controllers;

use App\Repositories\StockRepository;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public $stockRepo;
    public function __construct(StockRepository $stockRepo)
    {
        $this->stockRepo =$stockRepo;
    }
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.stock.stockList');
    }
    public function stockListing()
    {
        return $this->stockRepo->getstocklist();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getprodcolorsize(Request $request){
        $data = $this->stockRepo->getprodcolorsize($request->all());
        return response()->json(['data'=>$data]);
    }
    public function stockcreate()
    {
        $products = $this->stockRepo->getProducts();
        return view('admin.stock.stockAdd',compact(['products']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function stockstore(Request $request)
    {
        $data = $this->stockRepo->stockstore($request->all());
        if($data>0){
            return response()->json(['data'=>$data,'message'=>'Succesfully Created']);
        }else{
            return response()->json(['data'=>$data,'message'=>"Can't Create"]);
        }
    }
    public function fetchproductstock(Request $request)
    {
        $data = $this->stockRepo->fetchproductstock($request->all());
        return response()->json(['data'=>$data]);        
    }


    public function stockedit($prod_id)
    {
        $curntdata = $this->stockRepo->stockfetch($prod_id);
        if(count($curntdata)>0){
            $products = $this->stockRepo->getAllProducts();
            return view('admin.stock.stockEdit',compact(['curntdata','products']));
        }else{
            return redirect('admin/stock/stock-list');
        }
    }

    public function stockupdate(Request $request, $id)
    {
        $data = $this->stockRepo->stockupdate($request->all(),$id);
        return response()->json(['data'=>$data,'message'=>'Succesfully updated']);
    }

    public function stockdestroy($id)
    {
        $data = $this->stockRepo->stockdestroy($id);
        return redirect('stock/stock-list')->withSuccess('Deleted Succesfully');
    }

}
