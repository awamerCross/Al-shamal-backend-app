<?php

namespace App\Http\Requests\Admin\Bank;

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
            'name_ar'            => 'required',
            'name_en'            => 'required',
            'icon'               => 'nullable|image',
            'account_name'       => 'required',
            'account_number'     => 'required',
            'iban'               => 'required',
        ];
    }
}
