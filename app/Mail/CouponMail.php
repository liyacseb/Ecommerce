<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CouponMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public function __construct($data,$coupon)
    {
        $this->data = $data;
        $this->coupon = $coupon;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('user.couponEmail', ['name' => $this->data['name'],'email'=>$this->data['email'],'coupon_code'=>$this->coupon['coupon_code'] ])
        ->subject('Coupon time is here!');
    }
}
