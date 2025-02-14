<?php

namespace App\Http\Requests\Site;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
            'name'        => 'required',
            'country_id'  => 'required|exists:countries,id',
            'city_id'     => 'required|exists:cities,id',
            'avatar'      => 'nullable',
        ];
    }
}
