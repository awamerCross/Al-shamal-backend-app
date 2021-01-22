<?php

namespace App\Http\Requests\Api\User;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\Responses;
use Illuminate\Contracts\Validation\Validator;

const VALIDATION_RULES = [
    'identity'          => 'required',
    'user_license'      => 'required',
    'car_license'       => 'nullable',
    'car_plate_number'  => 'nullable',

];

class UserUpgradeRequest extends FormRequest
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
