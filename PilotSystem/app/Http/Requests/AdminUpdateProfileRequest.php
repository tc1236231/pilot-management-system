<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminUpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->hasRole('admin') || $this->user()->level > \PilotLevel::ATC_CAD;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'co' => 'nullable|exists:platform,code',
            'callsign' => 'required|exists:pilots|max:5|string',
            'namelog' => 'required|string',
            'level' => 'required|numeric|min:0|max:12',
            'txt' => 'nullable|string',
        ];
    }
}
