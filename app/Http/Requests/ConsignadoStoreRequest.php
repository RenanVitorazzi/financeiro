<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConsignadoStoreRequest extends FormRequest
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
            'data' => ['required', 'date', 'date_format:Y-m-d'],
            'peso' => ['required_without:fator', 'numeric', 'min:0', 'nullable'],
            'fator' => ['required_without:peso', 'numeric', 'min:0', 'nullable'],
            'representante_id' => ['required', 'exists:representantes,id'],
            'cliente_id' => ['required', 'exists:clientes,id']
        ];
    }
}
