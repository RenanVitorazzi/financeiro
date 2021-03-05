<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule as ValidationRule;

class SalvarVendaRequest extends FormRequest
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
        $metodos = ['Cheque', 'Dinheiro', 'Depósito', 'Nota Promissória', null];
        
        return [
            'data_venda' => 'required|date',
            'cliente_id' => 'required|integer',
            'balanco' => 'required',
            'representante_id' => 'required|integer',
            'peso' => 'required_if:balanco,Venda|numeric|min:0|nullable',
            'fator' => 'required_if:balanco,Venda|numeric|min:0|nullable',
            'cotacao_peso' => 'required_if:balanco,Venda|numeric|min:0|nullable',
            'cotacao_fator' => 'required_if:balanco,Venda|numeric|min:0|nullable',
            'valor_total' => 'required_if:balanco,Venda|numeric|min:0|nullable',
            'metodo_pagamento' => ValidationRule::in($metodos),
            'data_parcela' => 'required_if:metodo_pagamento,Cheque|array|nullable',
            'data_parcela.*' => 'required_if:metodo_pagamento,Cheque|date|nullable',
            'valor_parcela' => 'required_if:metodo_pagamento,Cheque|array|nullable',
            'valor_parcela.*' => 'required_if:metodo_pagamento,Cheque|numeric|nullable'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'O campo :attribute é obrigatório',
            'integer' => 'O campo :attribute precisar ser inteiro',
            'numeric' => 'O campo :attribute precisar ser numérico',
            'min' => 'O campo :attribute precisar ter valor :min no mínimo',
        ];
    }
}
