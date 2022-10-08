<?php

namespace App\Http\Requests;

use App\Models\Item;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'name' => ['required', 'string', Rule::unique('items', 'name')->ignore($this->id)],
            'code' => 'required|min:5|max:255',

            'amount' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'image' => 'image',
            // 'active' => 'required|boolean'

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
            'name' => 'dsadasdasda'
        ];
    }
}
