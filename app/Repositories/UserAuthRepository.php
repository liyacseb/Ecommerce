<?php

namespace App\Repositories;

use App\Jobs\SendCouponMailJob;
use App\Models\Coupon;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class UserAuthRepository 
{
    public function registration($data){
        $user = new User() ;
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);        
        $user->save();
        $userID = $user->id;

        $coupon = Coupon::where('status',1)
            ->where('user_id','0')
            ->first();
        if($coupon!=null){
            SendCouponMailJob::dispatch($data,$coupon);
            $coupon =Coupon::find($coupon->id);
            $coupon->user_id = $userID;
            $coupon->save();
        }        

        return $userID;
    }
    public function passwordreset($data){
        $token = Str::random(64);
        
        DB::table('password_resets')->insert([
              'email' => $data['email'], 
              'token' => $token, 
              'created_at' => Carbon::now()
        ]);
  
        Mail::send('user.forgetPasswordEmail', ['token' => $token], function($message) use($data){
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
            User::where('email', $data['email'])
                     ->update(['password' => Hash::make($data['password'])]);

            DB::table('password_resets')->where(['email'=> $data['email']])->delete();
            return true;
        }
    }
    public function checktokenused($token){
        return DB::table('password_resets')
        ->where([
          'token' => $token
        ])
        ->count();

       
    }
}