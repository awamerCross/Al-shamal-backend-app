<?php

namespace App\Http\Requests\Site;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name'           => 'required',
            'phone'          => 'required|min:10|unique:users,phone,NULL,NULL,deleted_at,NULL',
            'email'          => 'required|email|unique:users,email,NULL,NULL,deleted_at,NULL',
            'password'       => 'required|confirmed|min:6',
            'country_id'     => 'exists:countries,id|required',
            'city_id'        => 'exists:cities,id|required',
            'avatar'         => 'nullable',
            'key'            => 'required',
        ];
    }
}
