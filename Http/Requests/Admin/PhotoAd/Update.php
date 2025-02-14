<?php

namespace App\Http\Requests\Admin\PhotoAd;

use Illuminate\Foundation\Http\FormRequest;

class Update extends FormRequest
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
            'url'       => 'required|url',
            'user_id'   => 'required|exists:users,id',
            'image'     => 'nullable|image',
        ];
    }
}
