<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AnexoContaCorrenteRequest extends FormRequest
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
            'conta_corrente_id' => ['required', 'numeric'],
            'anexo' => ['required', 'array'],
            'anexo.*' => ['file', 'mimes:jpg,png,application/pdf,pdf', 'max:3000'],
        ];
    }
}
