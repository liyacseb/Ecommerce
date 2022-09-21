<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationRequest;
use App\Http\Requests\UserLoginRequest;
use App\Repositories\CartRepository;
use App\Repositories\UserAuthRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserAuthController extends Controller
{
    public $userRepo;
    public $cartRepo;
    public $cartcount;
    public function __construct(UserAuthRepository $userRepo,CartRepository $cartRepo)
    {
        $this->userRepo = $userRepo;
        $this->cartRepo =$cartRepo;
      
        $this->middleware(function ($request, $next) {
            
            $this->categories =$this->cartRepo->fetchCategory();
            $this->websitecontact =$this->cartRepo->fetchwebsiteAddress();
            if(Auth::guard('user')->check()){
                $this->cartcount =$this->cartRepo->fetchCartCount();
            }else{
                $this->cartcount =0;
            }
            return $next($request);
        });
    }
    public function register(){
        $cartcount = $this->cartcount;
        $categories = $this->categories;
        $websitecontact = $this->websitecontact;
        return view('user.register',compact(['cartcount','categories','websitecontact','websitecontact']));
    }
    public function login(){
        if(!(Session::get('previousurl'))){
        Session::put('previousurl',route('home'));
        }
        $prevUrl = url()->previous();
        $orderDetailActive=0;
        if(strpos($prevUrl,'userreset-password/')>0){
            $orderDetailActive=1;  
        }
        if(url()->current()!=$prevUrl && $prevUrl!=route('user.forget.password.get') && $prevUrl!=route('user.forget.password.post') 
        && $prevUrl!=route('user.reset.password.post') && $orderDetailActive==0){
            Session::put('previousurl',$prevUrl);
        }

        $cartcount = $this->cartcount;
        $categories = $this->categories;
        $websitecontact = $this->websitecontact;
        return view('user.login',compact(['cartcount','categories','websitecontact']));
    }
    public function showForgetPasswordForm()
    {
        $cartcount = $this->cartcount;
        $categories = $this->categories;
        $websitecontact = $this->websitecontact;
       return view('user.forgotpassword',compact(['cartcount','categories','websitecontact']));
    }
    public function submitForgetPasswordForm(Request $request)
    {
          $request->validate([
              'email' => 'required|email|exists:users',
          ],
          [
            'email.exists' => "The selected email doesn't exist"
          ]
        );
            
          $this->userRepo->passwordreset($request->all());
        
  
          return back()->with('message', 'We have e-mailed your password reset link!');
    }
    public function showResetPasswordForm($token) { 
        $cartcount = $this->cartcount;
        $categories = $this->categories;
        $websitecontact = $this->websitecontact;
        $count = $this->userRepo->checktokenused($token);
        
        return view('user.resetPassword', ['token' => $token,'cartcount'=>$cartcount,'categories'=>$categories,'websitecontact'=>$websitecontact]);
    }
    public function submitResetPasswordForm(Request $request)
    {
        
         $request->validate([
             'email' => 'required|email|exists:users',
             'password' => 'required|string|min:4',
             'confirmPassword' => 'required|same:password'
         ]);
 
         $updatePassword = $this->userRepo->checktoken($request->all());
        //   dd($updatePassword);
         if($updatePassword == false)
         {
             return back()->withInput()->with('error', 'The link that you used has been used previously');
         }
         return redirect('userlogin')->with('message', 'Your password has been changed!');
    }

    public function registration(RegistrationRequest $request){
      
        $id = $this->userRepo->registration($request->all());
        if($id>0){
            $credentials = $request->only('email','password');
            if(Auth::guard('user')->attempt($credentials)){
                if(session()->get('cart')){
                    // $cart = session()->get('cart');
                    $this->cartRepo->guestAddToCart(session()->get('cart'));
                }
                
                return response()->json(['data'=>$id,'message'=>'Succesfully login']);
            }else{
                return response()->json(['data'=>$id,'message'=>'Succesfully registered']);
            }
        }
        return response()->json(['data'=>$id,'message'=>'error']);

    }
    public function loginSubmit(UserLoginRequest $request){
       
        $credentials = $request->only('email','password');
        if(Auth::guard('user')->attempt($credentials)){
            
            if(session()->get('cart')){
                // $cart = session()->get('cart');
                $this->cartRepo->guestAddToCart(session()->get('cart'));
            }
            //return redirect('/');
            $prevUrl= Session::get('previousurl');
            Session::forget('previousurl');
            return redirect($prevUrl);
        }else{
            return redirect()->back()->with('error', 'Invalid Credentials');
        }
    }
    public function userLogout(){
        Auth::guard('user')->logout();
        return redirect('/');
    }
    
}
