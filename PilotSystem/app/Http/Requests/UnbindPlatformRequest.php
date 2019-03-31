<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UnbindPlatformRequest extends FormRequest
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
        return [
            'platform' => [
                'required',
                Rule::exists('pilotsdata','bbscode')->where(function($query) use ($request) {
                    return $query->where('callsign',$request->user()->callsign);
                }),
                'max:3'
            ]
        ];
    }
}
