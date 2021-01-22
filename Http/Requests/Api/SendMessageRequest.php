<?php

namespace App\Http\Requests\Api;
use Illuminate\Foundation\Http\FormRequest;
use App\Traits\Responses;
use Illuminate\Contracts\Validation\Validator;
const VALIDATION_RULES = [
    'r_id'    => 'required|exists:users,id',
    'ad_id'   => 'required|exists:ads,id',
    'message' => 'required',
];
class SendMessageRequest extends FormRequest
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
        return $rules;
    }

    protected function failedValidation(Validator $validator)
    {
        $this->validationResponse($validator);
    }
}
