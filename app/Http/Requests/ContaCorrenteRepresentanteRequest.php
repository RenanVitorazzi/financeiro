<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ContaCorrenteRepresentanteRequest extends FormRequest
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
        $balanco = ['Reposição', 'Venda', 'Devolução'];

        return [
            'fator' => ['required', 'numeric', 'min:0'],
            'peso' => ['required', 'numeric', 'min:0'],
            'data' => ['required', 'date'],
            'balanco' => ['required', Rule::in($balanco)],
            'representante_id' => ['required', 'numeric'],
            'observacao' => ['nullable'],
        ];
    }
}
