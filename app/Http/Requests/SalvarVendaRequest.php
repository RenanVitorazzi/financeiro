<?php

namespace App\Http\Requests;

use App\Rules\VendaRepresentante;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule as ValidationRule;

class SalvarVendaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $metodos = ['À vista', 'Parcelado'];
        $forma_pagamento = ['Dinheiro', 'Cheque', 'Transferência Bancária', 'Pix'];
        $status_parcela = ['Aguardando', 'Pago', 'Aguardando Envio', 'Aguardando Pagamento'];

        return [
            'data_venda' => ['required', 'date', 'date_format:Y-m-d'],
            'cliente_id' => ['required', 'integer'],
            'representante_id' => ['required', 'integer'],
            'peso' => ['required_without:fator', 'numeric', 'min:0', 'nullable'],
            'fator' => ['required_without:peso', 'numeric', 'min:0', 'nullable'],
            'cotacao_peso' => ['required_with:peso', 'numeric', 'min:0', 'nullable'],
            'cotacao_fator' => ['required_with:fator', 'numeric', 'min:0', 'nullable'],
            'valor_total' => ['required', 'numeric', 'min:0'],
            'metodo_pagamento' => ['required', ValidationRule::in($metodos)],
            'data_parcela' => ['required', 'array', 'nullable', 'min:1'],
            'data_parcela.*' => ['required', 'date', 'nullable', 'date_format:Y-m-d'],
            'valor_parcela' => ['required', 'array', 'nullable', 'min:1'],
            'valor_parcela.*' => ['required', 'numeric', 'nullable', 'min:0'],
            'forma_pagamento' => ['required', 'array', 'nullable', 'min:1'],
            'forma_pagamento.*' => ['required', ValidationRule::in($forma_pagamento)],
            'status' => ['required', 'array', 'nullable', 'min:1'],
            'status.*' => ['required', ValidationRule::in($status_parcela)],
            'observacao' => ['array', 'nullable'],
            'observacao.*' => ['nullable', 'string', 'max:255'],
            'numero_cheque' => ['array', 'nullable'],
            'numero_cheque.*' => ['nullable', 'string', 'max:255'],
            'nome_cheque' => ['array', 'nullable'],
            'nome_cheque.*' => ['required_if:forma_pagamento,Cheque', 'nullable', 'string', 'max:255'],
            'numero_banco' => ['array', 'nullable'],
            'numero_banco.*' => ['nullable', 'string', 'max:255'],
        ];
    }

}
