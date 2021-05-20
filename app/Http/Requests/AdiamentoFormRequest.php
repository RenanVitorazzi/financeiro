<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdiamentoFormRequest extends FormRequest
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
            'taxa' => 'required|numeric|min:0',
            'data_cheque' => 'required|date|date_format:Y-m-d',
            'data' => 'required|date|date_format:Y-m-d|after:data_cheque',
            'juros_adicionais' => 'required|numeric|min:0',
            'juros_novos' => 'required|numeric|min:0',
            'cheque_id' => 'required|numeric',
            'troca_parcela_id' => 'required|numeric',
            'observacao' => 'nullable',
        ];
    }
}
