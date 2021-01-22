<?php

namespace App\Http\Requests\Api;

namespace App\Http\Requests\Api;
use App\Traits\Responses;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
const VALIDATION_RULES = [
    'bank_id'           => 'required|exists:banks,id',
    'ad_id'             => 'required|exists:ads,id',
    'ammount'           => 'required|numeric',
    'account_number'    => 'required',
    'account_name'      => 'required',
    'bank_name'         => 'required',
    'image'             => 'required',
];

class addTransferRequest extends FormRequest
{
     use Responses ;
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
        return $rules;
    }

    protected function failedValidation(Validator $validator)
    {
        $this->validationResponse($validator);
    }
}
