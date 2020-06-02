<?php

namespace Techneved\Client\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MobileLogin extends FormRequest
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
     * Get custom attributes for validator errors.
     *
     * @return array
     */

    public function attributes()
    {
        return [
            'mobile'  => 'mobile number',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'mobile' => 'required| numeric| digits:10',
            'password' => 'required'
        ];
    }
}
