<?php

namespace App\Http\Requests\Api\User;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\Responses;
use Illuminate\Contracts\Validation\Validator;

const VALIDATION_RULES = [
    'name'           => 'required',
    'phone'          => 'required|min:10|unique:users,phone,NULL,NULL,deleted_at,NULL',
    'email'          => 'required|email|unique:users,email,NULL,NULL,deleted_at,NULL',
    'password'       => 'required',
    'country_id'     => 'exists:countries,id|required',
    'city_id'        => 'exists:cities,id|required',
    'device_id'      => 'required',
    'avatar'         => 'nullable',
    'key'            => 'required',
];

class StoreUpdateRequest extends FormRequest
{

    use Responses;
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
        $rules =  VALIDATION_RULES;

        if($this->getMethod() == 'POST'){
        }else{ // update
            $rules['phone'][1] = 'unique:users,phone,NULL,NULL,deleted_at,NULL' . request()->route('user')->id;
            $rules['email'][1] = 'unique:users,email,NULL,NULL,deleted_at,NULL' . request()->route('user')->id;
        }
        return $rules;
    }

    protected function failedValidation(Validator $validator)
    {
        $this->validationResponse($validator);
    }
}
