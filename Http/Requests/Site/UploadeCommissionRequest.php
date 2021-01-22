<?php

namespace App\Http\Requests\Site;

use Illuminate\Foundation\Http\FormRequest;

class UploadeCommissionRequest extends FormRequest
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
            'image'          => 'required|image',
            'bank_name'      => 'required',
            'account_name'   => 'required',
            'account_number' => 'required',
            'ammount'        => 'required',
            'bank_id'        => 'required',
//            'ad_id'          => 'required',
        ];
    }
}
