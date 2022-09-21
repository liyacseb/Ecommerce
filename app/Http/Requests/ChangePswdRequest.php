<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePswdRequest extends FormRequest
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
            'oldpswd'=>'required|min:6',
            'newpswd'=>'required|min:6',
            'renewpswd'=>'required|min:6|same:newpswd',
        ];
    }
    public function messages()
    {
        return [
            'oldpswd.required'=>'Please enter current password',
            'oldpswd.min'=>'The current password must be at least 6 characters.',
            'newpswd.required'=>'Please enter New password',
            'newpswd.min'=>'The New password must be at least 6 characters.',
            'renewpswd.required'=>'Please enter password',
            'renewpswd.min'=>'The new password and confirm password must match.',
        ];
    }
}
