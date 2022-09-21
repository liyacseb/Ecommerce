<?php

namespace App\Repositories;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\Size;
use App\Models\Stock;
use App\Models\Tax;
use Exception;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;


class ProductRepository 
{
    public function productview($id){
       return Product::with(['getTax','getCategory'])->find($id);
    }
    public function getproductlist(){
        // return Exam::all();
        $data = Product::with(['getTax','getallCategory'])
            ->orderBy('id','desc')
            ->get();
        
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                    $actionBtn = '<a class="btn btn-primary btn-sm " title="edit product" href="'.route('productview',$row['id']).'" >
                        <i class="fas fa-eye"></i>
                    </a>
                    <a class="btn btn-info btn-sm actionedit" title="edit product" href="'.route('productedit',$row['id']).'" >
                        <i class="fas fa-pencil-alt"></i>
                    </a>
                    <a class="btn btn-danger btn-sm actionDelete" data-href="'.route('productdestroy',$row['id']).'">
                        <i class="fas fa-trash"></i>
                    </a>';
                return $actionBtn;
            })
            ->addColumn('status', function($row){
                $actionBtn = '<span class="text-success">Active</span>'; 
                if($row['status']==0){
                    $actionBtn = '<span class="text-info">Inactive</span>'; 
                }
                  
                return $actionBtn;
            })
             ->rawColumns(['action','status'])
            ->make(true);
    }

    public function getTax(){
        return Tax::get();
    }
    public function getColor(){
        return Color::get();
    }
    public function getSize(){
        return Size::get();
    }
    public function getCategory(){
        return Category::get();
    }

    public function Productstore($data){

        $color_id =implode(',',$data['color_id']);

        $product = new Product() ;
        $product->product_name = $data['product_name'];
        $product->slug = str_replace(" ",'',$data['product_name']);
        $product->product_code = $data['product_code'];
        $product->cat_id = $data['cat_id'];
        $product->tax_id = $data['tax_id'];
        $product->actual_price = $data['actual_price'];
        $product->offer_price = $data['offer_price'];
        $product->color_id = $color_id;
        if(isset($data['size_id'])){
            $size_id =implode(',',$data['size_id']);
            $product->size_id = $size_id;
        }
        $product->description = $data['description'];
        $product->status = $data['status'];

        // if ( isset($data['cover_image'])) {
        //     if ($image = $data['cover_image']) {
        //         $destinationPath = 'assets/product';
        //         $cover_image = date('YmdHis') . "." . $image->getClientOriginalExtension();
        //         $image->move($destinationPath, $cover_image);
        //         $product->cover_image = $cover_image;
        //     }
        // }
        if(isset($data['image_0_upload'])){
            $image_1 = $data['image_0_upload'];
            $imgarr = explode(',', $image_1);
            if(!isset($imgarr[1])){
                $this->response['message'] = 'Error on post data image. String is not the expected string.';
                dd($this->response);
            }
            $this->image = base64_decode($imgarr[1]);
            $destinationPath = 'assets/product';
            if(!is_null($this->image)){
                $cover_image =date('Ymdms').uniqid().'.png';
                $file = $destinationPath .'/'.$cover_image;
                if(file_exists($file)){
                    $this->response['message'] = 'Image already exists on server.';
                    // dd($this->response);
                }
                if(file_put_contents($file, $this->image) !== false){
                    $this->response['error'] = 1;
                    $this->response['message'] = 'Image saved to server';
                    // dd($this->response);
                    $product->cover_image = $cover_image;
                }
                else{
                    $this->response['message'] = 'Error writing file to disk';
                    // dd($this->response);
                }
            }
            else{
                $this->response['message'] = 'Error decoding base64 string.';
                // dd($this->response);
            }
        }
        // if ( isset($data['image_1'])) {
        //     if ($image1 = $data['image_1']) {
        //         $destinationPath = 'assets/product';
        //         $image_1 = date('YmdHis') . "." . $image1->getClientOriginalExtension();
        //         $image1->move($destinationPath, $image_1);
        //         $product->image_1 = $image_1;
        //     }
        // }
        if(isset($data['image_1_upload'])){
            $image_1 = $data['image_1_upload'];
            $imgarr = explode(',', $image_1);
            if(!isset($imgarr[1])){
                $this->response['message'] = 'Error on post data image. String is not the expected string.';
                dd($this->response);
            }
            $this->image = base64_decode($imgarr[1]);
            $destinationPath = 'assets/product';
            if(!is_null($this->image)){
                $image_1 =date('Ymdms').uniqid().'.png';
                $file = $destinationPath .'/'.$image_1;
                if(file_exists($file)){
                    $this->response['message'] = 'Image already exists on server.';
                    // dd($this->response);
                }
                if(file_put_contents($file, $this->image) !== false){
                    $this->response['error'] = 1;
                    $this->response['message'] = 'Image saved to server';
                    // dd($this->response);
                    $product->image_1 = $image_1;
                }
                else{
                    $this->response['message'] = 'Error writing file to disk';
                    // dd($this->response);
                }
            }
            else{
                $this->response['message'] = 'Error decoding base64 string.';
                // dd($this->response);
            }
        }
        // if ( isset($data['image_2'])) {
        //     if ($image2 = $data['image_2']) {
        //         $destinationPath = 'assets/product';
        //         $image_2 = date('YmdHis') . "." . $image2->getClientOriginalExtension();
        //         $image2->move($destinationPath, $image_2);
        //         $product->image_2 = $image_2;
        //     }
        // }
        if(isset($data['image_2_upload'])){
            $image_1 = $data['image_2_upload'];
            $imgarr = explode(',', $image_1);
            if(!isset($imgarr[1])){
                $this->response['message'] = 'Error on post data image. String is not the expected string.';
                dd($this->response);
            }
            $this->image = base64_decode($imgarr[1]);
            $destinationPath = 'assets/product';
            if(!is_null($this->image)){
                $image_2 =date('Ymdms').uniqid().'.png';
                $file = $destinationPath .'/'.$image_2;
                if(file_exists($file)){
                    $this->response['message'] = 'Image already exists on server.';
                    // dd($this->response);
                }
                if(file_put_contents($file, $this->image) !== false){
                    $this->response['error'] = 1;
                    $this->response['message'] = 'Image saved to server';
                    // dd($this->response);
                    $product->image_2 = $image_2;
                }
                else{
                    $this->response['message'] = 'Error writing file to disk';
                    // dd($this->response);
                }
            }
            else{
                $this->response['message'] = 'Error decoding base64 string.';
                // dd($this->response);
            }
        }
        // if ( isset($data['image_3'])) {
        //     if ($image3 = $data['image_3']) {
        //         $destinationPath = 'assets/product';
        //         $image_3 = date('YmdHis') . "." . $image3->getClientOriginalExtension();
        //         $image3->move($destinationPath, $image_3);
        //         $product->image_3 = $image_3;
        //     }
        // }
        if(isset($data['image_3_upload'])){
            $image_1 = $data['image_3_upload'];
            $imgarr = explode(',', $image_1);
            if(!isset($imgarr[1])){
                $this->response['message'] = 'Error on post data image. String is not the expected string.';
                dd($this->response);
            }
            $this->image = base64_decode($imgarr[1]);
            $destinationPath = 'assets/product';
            if(!is_null($this->image)){
                $image_3 =date('Ymdms').uniqid().'.png';
                $file = $destinationPath .'/'.$image_3;
                if(file_exists($file)){
                    $this->response['message'] = 'Image already exists on server.';
                    // dd($this->response);
                }
                if(file_put_contents($file, $this->image) !== false){
                    $this->response['error'] = 1;
                    $this->response['message'] = 'Image saved to server';
                    // dd($this->response);
                    $product->image_3 = $image_3;
                }
                else{
                    $this->response['message'] = 'Error writing file to disk';
                    // dd($this->response);
                }
            }
            else{
                $this->response['message'] = 'Error decoding base64 string.';
                // dd($this->response);
            }
        }

        
        $product->save();
        $proID= $product->id;
        if(isset($data['size_id'])){
            $sizeID= $data['size_id'];
        }else{
            $sizeID= [];
        }
        $this->stockcreate($proID,$data['color_id'],$sizeID);

        return $proID;
    }
    public function stockcreate($proID,$colorID,$sizeID){
        // dd($colorID,$sizeID);
        for($i=0;$i<count($colorID);$i++){
            if(count($sizeID)>0){
                for($j=0;$j<count($sizeID);$j++){
                    $stock =new Stock();
                    $stock->prod_id=$proID;
                    $stock->color_id =$colorID[$i];
                    $stock->size_id =$sizeID[$j];
                    $stock->stock = 0;
                    $stock->save();
                }
            }else{
                $stock =new Stock();
                $stock->prod_id=$proID;
                $stock->color_id =$colorID[$i];
                $stock->size_id = 0;
                $stock->stock = 0;
                $stock->save();
            }
        }
    }
    public function Productdestroy($id){
        $product = Product::find($id);
        $product->delete();

        $stock = Stock::where('prod_id',$id);
        $stock->delete();

        return $product;
    }
    public function Productfetch($id){
        return Product::find($id);
    }
    public function Productupdate($data,$id){
       
        $color_id =implode(',',$data['color_id']);

        $product = Product::find($id);
        $product->product_name = $data['product_name'];
        $product->slug = str_replace(" ",'',$data['product_name']);
        $product->product_code = $data['product_code'];
        $product->cat_id = $data['cat_id'];
        $product->tax_id = $data['tax_id'];
        $product->actual_price = $data['actual_price'];
        $product->offer_price = $data['offer_price'];
        $product->color_id = $color_id;
        if(isset($data['size_id'])){
            $size_id =implode(',',$data['size_id']);
            $product->size_id = $size_id;
        }else{
            $product->size_id = NULL;
        }
        $product->description = $data['description'];
        $product->status = $data['status'];

        // if ( isset($data['cover_image'])) {
        //     if ($image = $data['cover_image']) {
        //         $destinationPath = 'assets/product';
        //         $cover_image = date('YmdHis') . "." . $image->getClientOriginalExtension();
        //         $image->move($destinationPath, $cover_image);
        //         $product->cover_image = $cover_image;
        //     }
        // }
        if(isset($data['image_0_upload'])){
            $image_1 = $data['image_0_upload'];
            $imgarr = explode(',', $image_1);
            if(!isset($imgarr[1])){
                $this->response['message'] = 'Error on post data image. String is not the expected string.';
                dd($this->response);
            }
            $this->image = base64_decode($imgarr[1]);
            $destinationPath = 'assets/product';
            if(!is_null($this->image)){
                $cover_image =date('Ymdms').uniqid().'.png';
                $file = $destinationPath .'/'.$cover_image;
                if(file_exists($file)){
                    $this->response['message'] = 'Image already exists on server.';
                    // dd($this->response);
                }
                if(file_put_contents($file, $this->image) !== false){
                    $this->response['error'] = 1;
                    $this->response['message'] = 'Image saved to server';
                    // dd($this->response);
                    $product->cover_image = $cover_image;
                }
                else{
                    $this->response['message'] = 'Error writing file to disk';
                    // dd($this->response);
                }
            }
            else{
                $this->response['message'] = 'Error decoding base64 string.';
                // dd($this->response);
            }
        }
        // if ( isset($data['image_1'])) {
        //     if ($image1 = $data['image_1']) {
        //         $destinationPath = 'assets/product';
        //         $image_1 = date('YmdHis') . "." . $image1->getClientOriginalExtension();
        //         $image1->move($destinationPath, $image_1);
        //         $product->image_1 = $image_1;
        //     }
        // }
        if(isset($data['image_1_upload'])){
            $image_1 = $data['image_1_upload'];
            $imgarr = explode(',', $image_1);
            if(!isset($imgarr[1])){
                $this->response['message'] = 'Error on post data image. String is not the expected string.';
                dd($this->response);
            }
            $this->image = base64_decode($imgarr[1]);
            $destinationPath = 'assets/product';
            if(!is_null($this->image)){
                $image_1 =date('Ymdms').uniqid().'.png';
                $file = $destinationPath .'/'.$image_1;
                if(file_exists($file)){
                    $this->response['message'] = 'Image already exists on server.';
                    // dd($this->response);
                }
                if(file_put_contents($file, $this->image) !== false){
                    $this->response['error'] = 1;
                    $this->response['message'] = 'Image saved to server';
                    // dd($this->response);
                    $product->image_1 = $image_1;
                }
                else{
                    $this->response['message'] = 'Error writing file to disk';
                    // dd($this->response);
                }
            }
            else{
                $this->response['message'] = 'Error decoding base64 string.';
                // dd($this->response);
            }
        }
        // if ( isset($data['image_2'])) {
        //     if ($image2 = $data['image_2']) {
        //         $destinationPath = 'assets/product';
        //         $image_2 = date('YmdHis') . "." . $image2->getClientOriginalExtension();
        //         $image2->move($destinationPath, $image_2);
        //         $product->image_2 = $image_2;
        //     }
        // }
        if(isset($data['image_2_upload'])){
            $image_1 = $data['image_2_upload'];
            $imgarr = explode(',', $image_1);
            if(!isset($imgarr[1])){
                $this->response['message'] = 'Error on post data image. String is not the expected string.';
                dd($this->response);
            }
            $this->image = base64_decode($imgarr[1]);
            $destinationPath = 'assets/product';
            if(!is_null($this->image)){
                $image_2 =date('Ymdms').uniqid().'.png';
                $file = $destinationPath .'/'.$image_2;
                if(file_exists($file)){
                    $this->response['message'] = 'Image already exists on server.';
                    // dd($this->response);
                }
                if(file_put_contents($file, $this->image) !== false){
                    $this->response['error'] = 1;
                    $this->response['message'] = 'Image saved to server';
                    // dd($this->response);
                    $product->image_2 = $image_2;
                }
                else{
                    $this->response['message'] = 'Error writing file to disk';
                    // dd($this->response);
                }
            }
            else{
                $this->response['message'] = 'Error decoding base64 string.';
                // dd($this->response);
            }
        }
        // if ( isset($data['image_3'])) {
        //     if ($image3 = $data['image_3']) {
        //         $destinationPath = 'assets/product';
        //         $image_3 = date('YmdHis') . "." . $image3->getClientOriginalExtension();
        //         $image3->move($destinationPath, $image_3);
        //         $product->image_3 = $image_3;
        //     }
        // }
        if(isset($data['image_3_upload'])){
            $image_1 = $data['image_3_upload'];
            $imgarr = explode(',', $image_1);
            if(!isset($imgarr[1])){
                $this->response['message'] = 'Error on post data image. String is not the expected string.';
                dd($this->response);
            }
            $this->image = base64_decode($imgarr[1]);
            $destinationPath = 'assets/product';
            if(!is_null($this->image)){
                $image_3 =date('Ymdms').uniqid().'.png';
                $file = $destinationPath .'/'.$image_3;
                if(file_exists($file)){
                    $this->response['message'] = 'Image already exists on server.';
                    // dd($this->response);
                }
                if(file_put_contents($file, $this->image) !== false){
                    $this->response['error'] = 1;
                    $this->response['message'] = 'Image saved to server';
                    // dd($this->response);
                    $product->image_3 = $image_3;
                }
                else{
                    $this->response['message'] = 'Error writing file to disk';
                    // dd($this->response);
                }
            }
            else{
                $this->response['message'] = 'Error decoding base64 string.';
                // dd($this->response);
            }
        }
        $product->save();

         if(isset($data['size_id'])){
            $sizeID= $data['size_id'];
        }else{
            $sizeID= [];
        }
        $this->stockUpdation($id,$data['color_id'],$sizeID);

        return $product;
    }
    public function stockUpdation($proID,$colorID,$sizeID){
        
        $color =Stock::where('prod_id',$proID)->whereNotIn('color_id',$colorID)->get();
       
        foreach($color as $colorStock){ 
            $stock = Stock::find($colorStock['id']);
            $stock->delete();
        }

        if(count($sizeID)>0){ 
            $query =Stock::where('prod_id',$proID);        
            $query->whereNotIn('size_id',$sizeID);
            $size = $query->get();
            foreach($size as $sizeStock){
                $stock = Stock::find($sizeStock['id']);
                $stock->delete();
            }
        }
       

        for($i=0;$i<count($colorID);$i++){
            //color exist check
            $stockdata = Stock::where('prod_id',$proID)->where('color_id',$colorID[$i])->get();
            if(count($stockdata)==0){
                if(count($sizeID)>0){
                    for($j=0;$j<count($sizeID);$j++){
                        $stock =new Stock();
                        $stock->prod_id=$proID;
                        $stock->color_id =$colorID[$i];
                        $stock->size_id =$sizeID[$j];
                        $stock->stock = 0;
                        $stock->save();
                    }
                }else{
                    $stock =new Stock();
                    $stock->prod_id=$proID;
                    $stock->color_id =$colorID[$i];
                    $stock->size_id = 0;
                    $stock->stock = 0;
                    $stock->save();
                }
            }
            // size exist check
            if(count($sizeID)>0){
                for($j=0;$j<count($sizeID);$j++){
                    $stockdata = Stock::where('prod_id',$proID)
                    ->where('color_id',$colorID[$i])
                    ->where('size_id',$sizeID[$j])
                    ->get();
                    if(count($stockdata)==0){
                        $stock =new Stock();
                        $stock->prod_id=$proID;
                        $stock->color_id =$colorID[$i];
                        $stock->size_id =$sizeID[$j];
                        $stock->stock = 0;
                        $stock->save();                    
                    }
                }
            }
        }
        
        // Stock id updation in cart table
        $cartstock = Cart::get();
        foreach($cartstock as $cart){
            $proID = $cart->prod_id;
            $color_id = $cart->color_id;
            $size_id = $cart->size_id;
            $stock_id = $cart->stock_id;
            try {
                DB::beginTransaction();
            $result = Stock::where('prod_id',$proID)->where('color_id',$color_id)->where('size_id',$size_id)->first();
           
            if($result['id'] != $stock_id){
                $cartUpdate = Cart::find($cart->id);
                $cartUpdate->stock_id = $result['id'];
                $cartUpdate->save();
            }
            DB::commit();
        } catch (Exception $e) {
            logger()->error($e);
            // return false;
        }
        }

        return 1;
    }
} 