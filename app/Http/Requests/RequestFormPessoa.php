<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestFormPessoa extends FormRequest
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
        // 'cnpj' => 'required_if:tipoCadastro,==,Pessoa Jurídica',
        // 'cpf' => 'required_if:tipoCadastro,==,Pessoa Física',
        return [
            'nome' => 'required|max:255|min:6',
            'tipoCadastro' => 'required',
            'cpf' => 'cpf',
            'telefone' => 'telefone_com_ddd',
            'celular' => 'celular_com_ddd',
            'cnpj' => 'cnpj',
            'cep' => 'formato_cep',
            'complemento' => 'max:255',
        ];
    }

    public function messages() 
    {
        return [
            'required' => 'O campo :attribute é obrigatório',
            'min' => 'O :attribute deve conter ao menos :min caracteres',
            'max' => 'O :attribute deve conter no máximo :max caracteres'
        ];
    }
}
