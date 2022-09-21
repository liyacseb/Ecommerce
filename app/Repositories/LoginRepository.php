<?php

namespace App\Repositories;

use App\Models\Admin;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginRepository 
{
    public function passwordreset($data){
        $token = Str::random(64);
        
        DB::table('password_resets')->insert([
              'email' => $data['email'], 
              'token' => $token, 
              'created_at' => Carbon::now()
        ]);
  
        Mail::send('admin.auth.forgetPasswordEmail', ['token' => $token], function($message) use($data){
              $message->to($data['email']);
              $message->subject('Reset Password');
        });
    }
    public function checktoken($data){
        $result = DB::table('password_resets')
        ->where([
          'email' => $data['email'], 
          'token' => $data['token']
        ])
        ->first();

        if(!$result){
            return false;
        }else{
            Admin::where('email', $data['email'])
                     ->update(['password' => Hash::make($data['password'])]);

            DB::table('password_resets')->where(['email'=> $data['email']])->delete();
            return true;
        }
    }
    

    public function changepswd($data){
        // dd($data);
        // dd($data['oldpswd']);
        return  Admin::where('id', Auth::guard('admin')->user()->id)
        ->update(['password' => Hash::make($data['newpswd'])]);
        
    }
}