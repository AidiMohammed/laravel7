<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfile extends FormRequest
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
            'username' => 'bail|required|min:4:max60',
            'avatar' => 'bail|image|max:3084|mimes:jpeg,jpg,png|dimensions:min_height=200,min_width=200,max_height=600,max_width=600'
        ];
    }
}
