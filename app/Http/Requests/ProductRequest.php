<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'product_name'=>'required|min:2|unique:products,product_name,NULL,id,deleted_at,NULL',
            'tax_id'=>'required',
            'cat_id'=>'required',
            'actual_price'=>'required|numeric',
            'offer_price'=>'nullable|numeric',
            'color_id'=>'required',
            'image_0_upload'=>'required',
            'image_1_upload'=>'required',
            'status'=>'required'
        ];
        
    }
    public function messages()
    {
        return [
            'image_0_upload.required'=>'Please upload cover image',
            'image_1_upload.required'=>'Please upload preview image'
        ];
    }
}
