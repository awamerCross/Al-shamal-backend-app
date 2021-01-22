<?php

namespace App\Http\Requests\Admin\Client;

use Illuminate\Foundation\Http\FormRequest;

class AddEditClientRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if($this->getMethod() === 'PUT'){
            $rules = [
                'name'                  => 'required|max:191',
                'phone'                 => 'required|numeric|unique:users,phone,'.$this->id,
                'email'                 => 'required|email|max:191|unique:users,email,'.$this->id,
                'password'              => ['nullable','max:191'],
                'avatar'                => ['nullable','image'],
            ];
            return $rules;
        }else{
            $rules = [
                'name'                  => 'required|max:191',
                'phone'                 => 'required|numeric|unique:users,phone,NULL,NULL,deleted_at,NULL',
                'email'                 => 'required|email|max:191|unique:users,email,NULL,NULL,deleted_at,NULL',
                'password'              => ['required','max:191'],
                'avatar'                => ['required','image'],
            ];
            return $rules;
        }
    }
}
