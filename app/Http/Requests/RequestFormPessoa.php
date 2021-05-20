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
        return [
            'nome' => 'required|max:255|min:3|string',
            'tipoCadastro' => 'required',
            'cpf' => 'cpf',
            'cnpj' => 'cnpj',
            'cep' => 'formato_cep',
            'estado' => 'string|nullable',
            'municipio' => 'string|nullable',
            'bairro' => 'string|nullable',
            'logradouro' => 'nullable',
            'numero' => 'nullable',
            'complemento' => 'max:255|nullable',
            'telefone' => 'telefone_com_ddd',
            'celular' => 'celular_com_ddd',
            'telefone2' => 'telefone_com_ddd',
            'celular2' => 'celular_com_ddd',
            'email' => 'email:rfc,dns|nullable|',
            'representante_id' => 'nullable'
        ];
    }

}
