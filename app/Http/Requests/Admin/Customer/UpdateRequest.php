<?php
/**
 * Created by PhpStorm.
 * User: jvgiv
 * Date: 8/25/2019
 * Time: 8:25 AM
 */

namespace App\Http\Requests\Admin\Customer;

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
            'email' => 'required|email|max:255|unique:users,email,' . $this->route('customer'),
            'name' => 'required|max:50',
            'company' => 'required|max:50',
            'phone' => 'required|numeric|digits_between:10,15',
            'avatar' => 'image'
        ];
    }
}