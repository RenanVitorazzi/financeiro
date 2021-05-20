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
            'fornecedor_id' => 'required|numeric',
            'balanco' => 'required',
            'cotacao' => 'nullable|numeric|min:0',
            'peso' => 'numeric|min:0|nullable|required_if:balanco,Débito',
            'observacao' => 'nullable|string',
            'anexo' => 'nullable|array|',
            'anexo.*' => 'file|mimes:jpg,png,application/pdf,pdf|max:3000',
        ];
    }
}
