<?php

namespace App\Http\Requests\Api\User;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\Responses;
use Illuminate\Contracts\Validation\Validator;

const VALIDATION_RULES = [
    'restaurant_ar'          => 'required',
    'restaurant_en'          => 'required',
    'latitude'               => 'nullable',
    'longitude'              => 'nullable',
    'address'                => 'nullable',
    'preparing_time_from'    => 'required',
    'preparing_time_to'      => 'required',
    'available'              => 'nullable',
    'cover'                  => 'nullable',
    'lang'                   => 'nullable',
];

class UpdateProviderReuest extends FormRequest
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

        }
        return $rules;
    }

    protected function failedValidation(Validator $validator)
    {
        $this->validationResponse($validator);
    }
}
