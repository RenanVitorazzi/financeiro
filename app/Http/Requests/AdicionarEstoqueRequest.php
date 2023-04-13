<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class AdicionarEstoqueRequest extends FormRequest
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
        $balanco = ['Crédito', 'Débito'];

        return [
            "peso" => ["numeric", "required", "min:0"],
            "fator" => ["numeric", "required", "min:0"],
            "data" => ["date", "required"],
            "balanco" => ["required", Rule::in($balanco)],
            "tabela" => ["nullable"],
            "conta_corrente_id" => ["nullable"],
        ];
    }
}
