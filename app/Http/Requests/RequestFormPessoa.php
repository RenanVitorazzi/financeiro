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
            'cpf' => 'cpf|nullable',
            'cnpj' => 'cnpj|nullable',
            'cep' => 'formato_cep|nullable',
            'estado' => 'string|nullable',
            'municipio' => 'string|nullable',
            'bairro' => 'string|nullable',
            'logradouro' => 'nullable',
            'numero' => 'nullable',
            'complemento' => 'max:255|nullable',
            'telefone' => 'telefone_com_ddd|nullable',
            'celular' => 'celular_com_ddd|nullable',
            'telefone2' => 'telefone_com_ddd|nullable',
            'celular2' => 'celular_com_ddd|nullable',
            'email' => 'email:rfc,dns|nullable|',
            'representante_id' => 'nullable|integer'
        ];
    }

}
