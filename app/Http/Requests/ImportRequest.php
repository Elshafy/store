<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ImportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'amount' => 'required|integer|min:1',
            'item_id' => [
                'required',
                'integer',
                Rule::exists('items', 'id')->where(function ($query) {
                    return $query->where('active', 1);
                })
            ],
            'supplier_id' => [
                'required',
                'integer',
                Rule::exists('suppliers', 'id')->where(function ($query) {
                    return $query->where('active', 1);
                })
            ],


        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     *     'email' => [
        'required',
        Rule::exists('staff')->where(function ($query) {
            return $query->where('account_id', 1);
        }),
    ],
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //
        ];
    }
}