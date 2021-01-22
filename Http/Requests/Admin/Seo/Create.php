<?php

namespace App\Http\Requests\Admin\Seo;

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
            'key'                           => 'required',

            'meta_title_en'                 => 'required',
            'meta_title_ar'                 => 'required',

            'meta_description_ar'           => 'required',
            'meta_description_en'           => 'required',

            'meta_keywords_ar'              => 'required',
            'meta_keywords_en'              => 'required',
        ];
    }
    public function messages()
    {
        return [
            'key.required'                  => 'ال key مطلوب',
        ];
    }
}
