<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrdemDePagamentoRequest extends FormRequest
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
            'nome_cheque' => ['required'],
            'representante_id' => ['numeric', 'required', 'min:1'],
            'valor_parcela' => ['array', 'min:1'],
            'valor_parcela.*' => ['required', 'numeric'],
            'data_parcela' => ['array', 'min:1'],
            'data_parcela.*' => ['required', 'date'],
        ];
    }
}
