<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChequeRepresentanteRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'representante_id' => ['numeric', 'required', 'min:1'],
            'nome_cheque' => ['array', 'min:1'],
            'nome_cheque.*' => ['required', 'string'],
            'numero_cheque' => ['array', 'min:1'],
            'numero_cheque.*' => ['required', 'string'],
            'valor_parcela' => ['array', 'min:1'],
            'valor_parcela.*' => ['required', 'numeric'],
            'data_parcela' => ['array', 'min:1'],
            'data_parcela.*' => ['required', 'date'],
            'nova_troca' => ['required'],
            'taxa_juros' => ['required_if:nova_troca,sim', 'min:0', 'max:100', 'nullable'],
        ];
    }
}
