<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateRedeemCodesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->hasRole('admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'keybeizhu' => 'required|string',
            'huo_dong' => 'required|string',
            'cishu' => 'required|numeric|min:1|max:1',
            'leixing' => 'required|numeric|min:1|max:2',
            'callsign_str' => 'required|string',
            'val_price' => 'required|numeric|min:0|max:999'
        ];
    }
}
