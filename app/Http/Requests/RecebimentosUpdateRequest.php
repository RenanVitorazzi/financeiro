<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RecebimentosUpdateRequest extends FormRequest
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
        $forma_pagamento = ['Pix', 'Depósito', 'Dinheiro', 'TED', 'DOC'];

        return [
            'data' => ['date', 'required'],
            'valor' => ['required', 'numeric', 'min:0'],
            'conta_id' => ['required', 'numeric'],
            'confirmado' => ['boolean'],
            'comprovante_id' => ['nullable', 'unique:pagamentos_parceiros,comprovante_id', 'unique:pagamentos_representantes,comprovante_id'],
            'forma_pagamento' => ['required', Rule::in($forma_pagamento)],
            'observacao' => ['nullable'],
        ];
    }
}
