<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChequeRequest extends FormRequest
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
            'data_parcela' => 'required|date',
            'numero_cheque' => 'nullable|string',
            'nome_cheque' => 'nullable',
            'valor_parcela' => 'numeric|required|min:0',
            'status' => 'required',
            'motivo' => 'required_if:status,Devolvido|string|nullable|',
            'observacao' => 'nullable|string',
        ];
    }
}
