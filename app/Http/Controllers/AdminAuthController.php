<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePswdRequest;
use App\Http\Requests\LoginRequest;
use App\Repositories\AdminDashboardRepository;
use App\Repositories\LoginRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AdminAuthController extends Controller
{
    public $loginRepo;
    public $dashboardRepo;
    public function __construct(LoginRepository $loginRepo,AdminDashboardRepository $dashboardRepo)
    {
        $this->loginRepo = $loginRepo;
        $this->dashboardRepo = $dashboardRepo;
    }

    public function index(){
        if (Auth::guard('admin')->check()) {
            return redirect('dashboard')->withSuccess('Signed In'); 
        }else{
            return view('admin.auth.login');
        }
    }
    
    public function showForgetPasswordForm()
    {
       return view('admin.auth.forgotpassword');
    }
    public function submitForgetPasswordForm(Request $request)
    {
          $request->validate([
              'email' => 'required|email|exists:admins',
          ],
          [
            'email.exists' => "The selected email doesn't exist"
          ]
        );
            
          $this->loginRepo->passwordreset($request->all());
        
  
          return back()->with('message', 'We have e-mailed your password reset link!');
    }
    public function showResetPasswordForm($token) { 
        return view('admin.auth.forgetPasswordLink', ['token' => $token]);
    }
    public function submitResetPasswordForm(Request $request)
    {
        
         $request->validate([
             'email' => 'required|email|exists:admins',
             'password' => 'required|string|min:6|confirmed',
             'password_confirmation' => 'required'
         ]);
 
         $updatePassword = $this->loginRepo->checktoken($request->all());
        //   dd($updatePassword);
         if($updatePassword == false)
         {
             return back()->withInput()->with('error', 'Invalid token!');
         }
 
         
 
         return redirect('admin-login')->with('message', 'Your password has been changed!');
    }


    public function checkLogin(LoginRequest $request){
        $credentials = $request->only('email','password');
        if(Auth::guard('admin')->attempt($credentials)){
            return redirect('dashboard')->withSuccess('Signed In');
        }
        return redirect('admin-login')->withError('Invalid Credentials');
    }
    public function dashboard(){
        $productcount = $this->dashboardRepo->fetchProductCount();
        $ordercount = $this->dashboardRepo->fetchOrderCount();
        $usercount = $this->dashboardRepo->fetchUsersCount();
        $paymentcount = $this->dashboardRepo->fetchPaymentCount();
        return view('admin.dashboard',compact('productcount','ordercount','usercount','paymentcount'));
    }
    public function contactsetting(){
        $contactDet = $this->dashboardRepo->fetchContactDet();
        return view('admin.contactsetting',compact(['contactDet']));
    }
    public function changePassword(){
        return view('admin.changepswd');
    }
    public function submitwebsitesetting(Request $request){
        $contactDet = $this->dashboardRepo->updateContactDet($request->all());
        return redirect('contact-setting')->withSuccess('Succesfully Update');
    }
    public function submitChangePassword(ChangePswdRequest $request){
        $credentials = $request->only('oldpswd');
        if(Auth::guard('admin')->user())
        {
            $pass = Auth::guard('admin')->user()->password;
        }
        if (!(Hash::check($request->get('oldpswd'), $pass))) {
            return back()->withInput()->with('error', 'Current password is incorrect');
        }else{
            $this->loginRepo->changepswd($request->all());
            return back()->withInput()->with('success', 'Successfully updated the password');
        }
    }
    public function logout(){
        // Session::flush();
        Auth::guard('admin')->logout();
  
        return redirect('admin-login');
    }
}