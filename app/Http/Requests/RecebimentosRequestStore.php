<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RecebimentosRequestStore extends FormRequest
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
            'parcela_id' => ['nullable', 'numeric'],
            'representante_id' => ['nullable', 'numeric','required_unless:tipo_pagamento,1'],
            'parceiro_id' => ['nullable', 'numeric', 'required_unless:tipo_pagamento,2'],
            'confirmado' => ['boolean'],
            'comprovante_id' => ['nullable', Rule::unique('pagamentos_parceiros', 'comprovante_id')->whereNull('deleted_at'), Rule::unique('pagamentos_representantes', 'comprovante_id')->whereNull('deleted_at'),],
            'tipo_pagamento' => ['required'],
            'forma_pagamento' => ['required', Rule::in($forma_pagamento)],
            'observacao' => ['nullable'],
        ];
        
        // 'anexo' => ['nullable', 'array'],
        // 'anexo.*' => 'file|mimes:application/pdf,pdf,jpeg,jpg|max:3000',
    }
}
