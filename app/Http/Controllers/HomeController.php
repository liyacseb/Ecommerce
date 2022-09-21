<?php

namespace App\Http\Controllers;

use App\Repositories\CartRepository;
use App\Repositories\HomeRepository;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public $homeRepo;
    public $cartRepo;
    public $cartcount;
    public function __construct(HomeRepository $homeRepo,CartRepository $cartRepo)
    {
        $this->homeRepo =$homeRepo;
        $this->cartRepo =$cartRepo;
      
        $this->categories =$this->cartRepo->fetchCategory();
        $this->websitecontact =$this->cartRepo->fetchwebsiteAddress();
        $this->middleware(function ($request, $next) {
            
            if(Auth::guard('user')->check()){
                $this->cartcount =$this->cartRepo->fetchCartCount();
            }else{
                $this->cartcount =0;
            }
            return $next($request);
        });
    }
    public function index(){
        $product = $this->homeRepo->fetchAllProducts();
        $category = $this->homeRepo->fetchCategory();
        $banner = $this->homeRepo->fetchBanners();
        $cartcount = $this->cartcount;
        $categories = $this->categories;
        $websitecontact = $this->websitecontact;
        return view('user.index',compact(['banner','product','category','cartcount','categories','websitecontact']));
    }
    public function detail($id){
        $curntdata = $this->homeRepo->fetchProduct($id);
        if($curntdata==null || $curntdata->getCategory==null){
            return redirect('/');
        }
        $catproducts = $this->homeRepo->relatedCategoryProduct($curntdata->cat_id,$id);
        $category = $this->homeRepo->fetchCategory();
        $colors = $this->homeRepo->fetchColors();
        $size = $this->homeRepo->fetchSize();
        $cartcount = $this->cartcount;
        $categories = $this->categories;
        $websitecontact = $this->websitecontact;
        return view('user.detail',compact(['curntdata','catproducts','category','colors','size','cartcount','categories','websitecontact']));
    }
    public function update(Request $request)
    {
        
        if(Auth::guard('user')->check()){
            $data=$this->cartRepo->updateCart($request->all());
            return response()->json(['data'=>$data]);
        }else{
            if($request->prodid && $request->colorID){
                
                $cart["colorID"] = $request->colorID;
                $cart["prodid"] = $request->prodid;
                if($request->sizeExist!=0){
                    $cart["sizeID"] = $request->sizeID;
                }else{
                    $cart["sizeID"] = 0;
                }
                
                // session()->put('cart', $cart);
                // $ar = session()->get('cart');
                Session::put('cart', $cart);
                $ar =Session::get('cart');
                // dd($ar);
                return response()->json(['data'=>0]);
            }
        }
    }
    public function productlist(Request $request){
        $category = $this->homeRepo->fetchCategory();
        $search = $request->get('search');
        $products = $this->homeRepo->getProducts($search);
        $cartcount = $this->cartcount;
        $categories = $this->categories;
        $websitecontact = $this->websitecontact;
        return view('user.product_listing',compact(['cartcount','category','products','search','categories','websitecontact']));
    }
    public function productlistdefault(){
        $category = $this->homeRepo->fetchCategory();
        $search = null;
        $products = $this->homeRepo->getProducts($search);
        $cartcount = $this->cartcount;
        $categories = $this->categories;
        $websitecontact = $this->websitecontact;
        return view('user.product_listing',compact(['cartcount','category','products','search','categories','websitecontact']));
    }
    public function sortbyurl(Request $request){
        $sortBy = $request->get('sortBy');
        $catid = $request->get('catid');
        $product = $this->homeRepo->sortPrice($sortBy,$catid);
        $prducthtml = $this->appendproduct($product);
        return response()->json($prducthtml);
    }
    public function appendproduct($product){
        $prducthtml = '';
        foreach($product as $proVal){
            if($proVal['offer_price']){
                $price = '<del>₹'.$proVal['actual_price'].'</del>₹'.$proVal['offer_price'];
            }else{
                $price = '<del></del>₹'.$proVal['actual_price'];
            }
            $producturl = route('detail',$proVal['id']);
            $prducthtml .='<div class="col-lg-4 col-md-6">
            <div class="product">
              <div class="flip-container">
                <div class="flipper">
                  <div class="front"><a href="'.$producturl.'"><img src="'.asset('assets/product/'.$proVal['cover_image']).'" alt="" class="img-fluid"></a></div>
                  <div class="back"><a href="'.$producturl.'"><img src="'.asset('assets/product/'.$proVal['image_1']).'" alt="" class="img-fluid"></a></div>
                </div>
              </div><a href="'.$producturl.'" class="invisible"><img src="'.asset('assets/product/'.$proVal['cover_image']).'" alt="" class="img-fluid"></a>
              <div class="text">
                <h3><a href="'.$producturl.'">'.$proVal['product_name'].'</a></h3>
                <p class="price"> 
                 '.$price.'
                </p>
                <p class="buttons"><a href="'.$producturl.'" class="btn btn-outline-secondary">View detail</a>
                </p>
              </div>
              </div>
            </div>';
        }
        return $prducthtml;
    }
    public function category($id){
        $products = $this->homeRepo->getProductsByCategory($id);
        if(count($products)>0 && $products[0]['getCategory']!=null){
            $cartcount = $this->cartcount;
            $categories = $this->categories;
            $websitecontact = $this->websitecontact;
            return view('user.product_listing_category',compact(['cartcount','products','categories','websitecontact']));
        }else{
            return back();
        }
    }
}
