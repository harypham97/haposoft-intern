<?php

namespace App\Http\Requests\Client\Report;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'name' => 'required|max:100',
            'date' => 'required|date',
            'time_start' => 'required',
            'time_end' => 'required|after:time_start',
            'description' => 'required'
        ];
    }
}