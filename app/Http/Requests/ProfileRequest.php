<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProfileRequest extends FormRequest
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
            'name'=>'required|min:2',
            'email'=>'required|email|unique:users,email,'.Auth::guard('user')->user()->id.',id,deleted_at,NULL',
            'mob'=>'nullable|digits:10|unique:users,phone_number,'.Auth::guard('user')->user()->id.',id,deleted_at,NULL',
        ];
    }
    public function messages()
    {
        return [
            'mob.digits'=>'The Mobile Number must be 10 digits.',
            'mob.unique'=>'The Mobile Number must be unique.'
        ];
    }
}
