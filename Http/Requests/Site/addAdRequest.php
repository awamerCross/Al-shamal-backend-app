<?php

namespace App\Http\Requests\Site;

use Illuminate\Foundation\Http\FormRequest;

class addAdRequest extends FormRequest
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
            'title_ar'                      => 'required|string|max:250',
//            'title_en'                      => 'required|string|max:250',
            'description_ar'                => 'required',
//            'description_en'                => 'required',
            'country_id'                    => 'required|exists:countries,id',
            'city_id'                       => 'required|exists:cities,id',
            'category_id'                   => 'required|exists:categories,id',
            'price'                         => 'nullable|numeric',
            'phone'                         => 'required',
            'address'                       => 'nullable',
            'is_phone'                      => 'nullable',
            'is_chat'                       => 'nullable',
            'is_refresh'                    => 'nullable',
            'images'                        => 'nullable|array',
            'images.*'                      => 'mimes:png,jpeg,jpg|max:8000'
        ];
    }
}
