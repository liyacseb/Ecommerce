<?php

namespace App\Repositories;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\Size;

class HomeRepository 
{
    public function fetchAllProducts(){
        return Product::where('status','1')->orderBy('cat_id')->get();
    }
    public function fetchBanners(){
        return Banner::where('status','1')->orderBy('id')->get();
    }
    public function fetchCategory(){
        return Product::with(['getCategory'=>function($query){
            return $query->where('category_status','1')->get();

        }])->selectRaw('cat_id,count(*) as productcount')->where('status','1')->groupBy('cat_id')->get();
    }
    public function getProducts($search){
        $catAry=Product::with(['getCategory'=>function($query){
            return $query->where('category_status','1')->get();

        }])->select('cat_id')->where('status','1')->groupBy('cat_id')->get();
        $categories=[];
        foreach($catAry as $catVal){
            if($catVal['getCategory']){
                $categories[]=$catVal['getCategory']['id'];
            }
        }
        if($search){
            $search = str_replace(" ",'',$search);
            return Product::with('getCategory')
            ->whereIn('cat_id',$categories)
            ->where('status',1)
            ->where('slug', 'LIKE', "%{$search}%") 
            ->select('*')->orderBy('id','DESC')->get();
        }else{
            return Product::with('getCategory')->whereIn('cat_id',$categories)->where('status',1)->select('*')->orderBy('id','DESC')->get();
        }
    }
    public function getProductsByCategory($cat_id){
        return Product::with('getCategory')->where('cat_id',$cat_id)->where('status',1)->select('*')->orderBy('id','DESC')->get();        
    }
    public function fetchProduct($id){
        return Product::with('getCategory','getTax')->find($id);
    }
    public function fetchColors(){
        return Color::get();
    }
    public function fetchSize(){
        return Size::get();
    }
    public function relatedCategoryProduct($catID,$prodID){
        return Product::where('cat_id',$catID)->where('id','!=',$prodID)->where('status','1')->take(3)->get();
    }
    public function sortPrice($sortBy,$catid){
        $catAry=Product::with(['getCategory'=>function($query){
            return $query->where('category_status','1')->get();

        }])->select('cat_id')->where('status','1')->groupBy('cat_id')->get();
        $categories=[];
        foreach($catAry as $catVal){
            if($catVal['getCategory']){
                $categories[]=$catVal['getCategory']['id'];
            }
        }
        if($sortBy==0){
            // sortby newest
            return $this->getProducts(null);

        }elseif($sortBy==1){
            //price low to high          
            $order='ASC';
        }else{
            //price high to low
            $order='DESC';
        }
        
        $query = Product::with('getCategory')
        ->where('status',1)->select('*');
        if($catid==0){
            $query->whereIn('cat_id',$categories);
        }else{
            $query->where('cat_id',$catid);
        }
        return $query->orderBy('actual_price',$order)->get();
    }
}