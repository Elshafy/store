<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemRequest extends FormRequest
{

    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }


    public function rules()
    {
        return [
            'name' => 'required|min:5|max:255',
            'code' => 'required|min:5|max:255',

            'amount' => 'required|integer',
            'price' => 'required|numeric',
            'image' => 'required|image',
            'active' => 'required|boolean'

        ];
    }


    public function attributes()
    {
        return [
            //
        ];
    }


    public function messages()
    {
        return [
            //
        ];
    }
}