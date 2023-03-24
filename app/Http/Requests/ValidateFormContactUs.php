<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateFormContactUs extends FormRequest
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
            'firstName' => 'bail|required|max:50',
            'lastName' => 'bail|required|max:50',
            'email' => 'bail|required|max:50|email',
            'phone' => 'bail|required|max:50',
            'message' => 'bail|required|max:50',
        ];
    }
}
