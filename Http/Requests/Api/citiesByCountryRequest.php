<?php

namespace App\Http\Requests\Api;

use App\Traits\Responses;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;


class citiesByCountryRequest extends FormRequest
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
        return [
            'country_id'   => 'required|exists:countries,id'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $this->validationResponse($validator);
    }
}
