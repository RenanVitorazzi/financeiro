<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditTrocaChequeRequest extends FormRequest
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
            "titulo" => ["string", "nullable"],
            "data_troca" => ["required", "date"],
            "parceiro_id" => ["nullable", "numeric"],
            "observacao" => ["string", "nullable"],
            "taxa_juros" => ["required", "numeric", "min:0", "max:100"],
        ];
    }
}
