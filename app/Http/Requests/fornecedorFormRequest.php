<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class fornecedorFormRequest extends FormRequest
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
            'nome' => 'required|max:255|min:3',
            'cpf' => 'required|unique:representantes',
        ];
    }

    public function messages() 
    {
        return [
            'required' => 'O campo :attribute é obrigatório',
            'min' => 'O :attribute deve conter ao menos :min',
            'max' => 'O :attribute deve conter no máximo :max',
        ];
    }
}
