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
            'nova_data' => ['required','date','date_format:Y-m-d','after:parcela_data'],
            'taxa_juros' => ['required','numeric','min:0'],
            'juros_totais' => ['required','numeric','min:0'],
            'parcela_data' => ['required','date','date_format:Y-m-d'],
            'parcela_id' => ['required','numeric'],
            'observacao' => ['nullable'],
        ];
    }
}
