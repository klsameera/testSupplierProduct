<?php

namespace App\Http\Requests\Suppliers;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSupplierRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return[
            'name' => ['required','string','min:3','max:255'],
            'email' =>  ['nullable','email','max:255'],
            'contact_no' =>  ['nullable','numeric','digits_between:9,10'],
            'web_url' =>  ['nullable','url','max:255'],
        ];
    }

}
