<?php

namespace App\Http\Requests\Admin\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfile extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [

            'name'      => 'required|max:191',
            'phone'     => "required|numeric|unique:users,phone,".auth()->id(),
            'email'     => "required|email|max:191|unique:users,email,".auth()->id(),
            'password'  => 'nullable|max:191',
            'avatar'    => 'nullable|image',
        ];
    }
}
