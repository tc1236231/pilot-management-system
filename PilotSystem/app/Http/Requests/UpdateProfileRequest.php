<?php

namespace App\Http\Requests;

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
            'realname' => 'required|max:40|string',
            'phone' => 'required|digits_between:8,14|numeric|unique:pilots',
            'dizhi' => 'required|max:70|string',
        ];
    }
}
