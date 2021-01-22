<?php

namespace App\Http\Requests\Admin\Ad;

use Illuminate\Foundation\Http\FormRequest;

class Create extends FormRequest
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
            'title_ar'                      => 'required',
            'title_en'                      => 'required',
            'description_ar'                => 'required',
            'description_en'                => 'required',
            'country_id'                    => 'required|exists:countries,id',
            'city_id'                       => 'required|exists:cities,id',
            'user_id'                       => 'required|exists:users,id',
            'category_id'                   => 'required|exists:categories,id',
            'price'                         => 'nullable',
            'meta_title_en'                 => 'required',
            'meta_title_ar'                 => 'required',
            'meta_description_ar'           => 'required',
            'meta_description_en'           => 'required',
            'meta_keywords_ar'              => 'required',
            'meta_keywords_en'              => 'required',
            'phone'                         => 'required',
            'address'                       => 'nullable',
            'is_phone'                      => 'nullable',
            'is_chat'                       => 'nullable',
            'is_refresh'                    => 'nullable',
            'images'                        => 'nullable',
        ];
    }
}
