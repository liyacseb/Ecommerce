<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserChangePswdRequest extends FormRequest
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
            'oldPassword'=>'required|min:6',
            'password'=>'required|min:6',
            'confirmPassword'=>'required|min:6|same:password',
        ];
    }
    public function messages()
    {
        return [
            'oldPassword.required'=>'Please enter current password',
            'oldPassword.min'=>'The current password must be at least 6 characters.',
            'password.required'=>'Please enter New password',
            'confirmPassword.min'=>'The New password must be at least 6 characters.',
            'confirmPassword.required'=>'Please enter password',
            'confirmPassword.min'=>'The new password and confirm password must match.',
        ];
    }
}
