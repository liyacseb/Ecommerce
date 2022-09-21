<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Repositories\ProductRepository;

class ProductController extends Controller
{
    public $productRepo;
    public function __construct(ProductRepository $productRepo)
    {
        $this->productRepo =$productRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.product.productList');
    }
    public function productListing()
    {
        return $this->productRepo->getproductlist();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function productcreate()
    {
        $tax = $this->productRepo->getTax();
        $color = $this->productRepo->getColor();
        $size = $this->productRepo->getSize();
        $category = $this->productRepo->getCategory();
        return view('admin.product.productAdd',compact(['tax','color','size','category']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function productstore(ProductRequest $request)
    {
        $data = $this->productRepo->productstore($request->all());
        if($data>0){
            return response()->json(['data'=>$data,'message'=>'Succesfully Created']);
        }else{
            return response()->json(['data'=>$data,'message'=>"Can't Create"]);
        }
    }

    public function productedit($id)
    {
        $curntdata = $this->productRepo->productfetch($id);
        if($curntdata!=null){
            $tax = $this->productRepo->getTax();
            $color = $this->productRepo->getColor();
            $size = $this->productRepo->getSize();
            $category = $this->productRepo->getCategory();
            return view('admin.product.productEdit',compact(['curntdata','tax','color','size','category']));
        }else{
            return redirect('admin/product/product-list')->with('errors','No Such Product');
        }
    }

    public function productupdate(ProductUpdateRequest $request, $id)
    {
        $data = $this->productRepo->productupdate($request->all(),$id);
        return response()->json(['data'=>$data,'message'=>'Succesfully updated']);
    }

    public function productdestroy($id)
    {
        $data = $this->productRepo->productdestroy($id);
        return redirect('product/product-list')->withSuccess('Deleted Succesfully');
    }
    public function productview($id){
        $data = $this->productRepo->productview($id);
        if($data!=null){
            $tax = $this->productRepo->getTax();
            $color = $this->productRepo->getColor();
            $size = $this->productRepo->getSize();
            $category = $this->productRepo->getCategory();
            return view('admin.product.productView',compact(['data','tax','color','size']));
        }else{
            return redirect('admin/product/product-list')->with('errors','No Such Product');
        }
    }

}
