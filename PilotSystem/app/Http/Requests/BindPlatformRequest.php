<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BindPlatformRequest extends FormRequest
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
        $request = $this;
        $rules = [
            'platform'    => [
                    'required',
                    Rule::unique('pilotsdata','bbscode')->where(function($query) use ($request) {
                        return $query->where('callsign',$request->user()->callsign);
                    }),
                    'max:3',
                    'exists:platform,code',
                ],
            'email'    => 'required|string',
            'password'    => 'required|string'
        ];
        return $rules;
    }
}