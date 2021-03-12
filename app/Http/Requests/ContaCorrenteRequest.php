<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContaCorrenteRequest extends FormRequest
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
            'data' => 'required',
            'balanco' => 'required',
            'cotacao' => 'nullable|numeric|min:1|required_if:balanco,Débito',
            'peso' => 'required_if:balanco,Crédito|numeric|min:1|nullable',
            'observacao' => 'required|string',
        ];
    }
}
