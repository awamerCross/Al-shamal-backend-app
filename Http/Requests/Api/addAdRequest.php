<?php

namespace App\Http\Requests\Api;
namespace App\Http\Requests\Api;
use App\Traits\Responses;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
const VALIDATION_RULES = [
    'country_id'         => 'required|exists:countries,id',
    'city_id'            => 'required|exists:cities,id',
    'category_id'        => 'required|exists:categories,id',
    'title_ar'           => 'required',
//    'title_en'           => 'required',
    'description_ar'     => 'required',
//    'description_en'     => 'required',
    'price'              => 'nullable',
    'address'            => 'required',
//    'latitude'           => 'required',
//    'longitude'          => 'required',
    'phone'              => 'required',
    'is_chat'            => 'required',
    'is_phone'           => 'required',
    'is_refresh'         => 'required',
    'features'           => 'nullable ',
    'features_ids'       => 'nullable ',
    'images'             => 'nullable ',
];
class addAdRequest extends FormRequest
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
