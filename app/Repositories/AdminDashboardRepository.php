<?php

namespace App\Repositories;

use App\Models\Contact;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdminDashboardRepository 
{
    public function fetchProductCount(){
        return Product::count();
    }
    public function fetchOrderCount(){
        return Order::count();
    }
    public function fetchUsersCount(){
        return User::count();
    }
    public function fetchPaymentCount(){
        return DB::table('orders')->where('payment_status',1)->sum('grand_total');
    }
    public function fetchContactDet(){
        return Contact::get();
    }
    public function updateContactDet($data){
        

        $contact = Contact::find(1);
        $contact->website_name = $data['websitename'];
        $contact->adrs_line_1 = $data['adrs_line_1'];
        $contact->adrs_line_2 = $data['adrs_line_2'];
        $contact->pincode = $data['pincode'];
        $contact->district = $data['district'];
        $contact->state = $data['state'];
        $contact->country = $data['country'];
        $contact->fb_link = $data['fb_link'];
        $contact->twitter_link = $data['twitter_link'];
        $contact->insta_link = $data['insta_link'];
        $contact->gmail_link = $data['gmail_link'];

        if(isset($data['logo_upload'])){
            $image_1 = $data['logo_upload'];
            $imgarr = explode(',', $image_1);
            if(!isset($imgarr[1])){
                $this->response['message'] = 'Error on post data image. String is not the expected string.';
                dd($this->response);
            }
            $this->image = base64_decode($imgarr[1]);
            $destinationPath = 'assets/dist/img';
            if(!is_null($this->image)){
                $website_logo =date('Ymdms').uniqid().'.png';
                $file = $destinationPath .'/'.$website_logo;
                if(file_exists($file)){
                    $this->response['message'] = 'Image already exists on server.';
                    // dd($this->response);
                }
                if(file_put_contents($file, $this->image) !== false){
                    $this->response['error'] = 1;
                    $this->response['message'] = 'Image saved to server';
                    // dd($this->response);
                    $contact->website_logo = $website_logo;
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

        $contact->save();
        return $contact;
    }
}