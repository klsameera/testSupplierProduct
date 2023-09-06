<?php

namespace App\Http\Requests\Products;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required','string','min:3','max:255'],
            'code' =>  ['required','string','min:3','max:255','unique:products'],
            'photo' =>  ['mimes:jpeg,png,jpg,gif|max:5048|dimensions:width=100,height=100'],
            'description' =>  ['nullable','string','min:3','max:2000'],
            'price' =>  ['required','numeric','min:0'],
            'quantity' =>  ['required','numeric','min:0'],
            'supplier_id' =>  ['required','numeric','exists:suppliers,id'],
        ];
    }
}
