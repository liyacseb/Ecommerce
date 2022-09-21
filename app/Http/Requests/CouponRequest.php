<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CouponRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'coupon_code'=>'required|min:2|unique:coupons,coupon_code,NULL,id,deleted_at,NULL',
            'coupon_amount'=>'required|integer',
            'coupon_type'=>'required'
        ];
    }
    public function messages()
    {
        return [
            'coupon_amount.integer'=>'Please enter only digits'
        ];
    }
}
