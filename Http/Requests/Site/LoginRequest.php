<?php

namespace App\Http\Requests\Site;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
        if(is_numeric($this->phone)){
            return [
                'phone'     => 'required|exists:users,phone',
                'key'       => 'required|exists:countries,key',
                'password'  => 'required',
            ];
        } elseif (filter_var($this->phone, FILTER_VALIDATE_EMAIL)) {
            return [
                'phone'     => 'required|exists:users,email',
                'password'  => 'required',
            ];
        }

    }

    public function messages(){
        if(is_numeric($this->phone)){
            return [
                'phone.required'     => __('site.phone_req') ,
                'phone.exists'     => __('site.phone_ex') ,
            ];
        } elseif (filter_var($this->phone, FILTER_VALIDATE_EMAIL)) {
            return [
                'phone.required'     => __('site.email_req') ,
                'phone.exists'       => __('site.email_ex') ,
            ];
        }
    }
}
