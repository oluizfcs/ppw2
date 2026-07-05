<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAvaliacaoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'titulo' => 'nullable|string',
            'descricao' => 'nullable|string',
            'nota' => 'required|int|between:1,5',
            'usuario_id' => 'required|int',
            'filme_id' => 'required|int'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'nota.required' => 'O campo nota é obrigatório',
            'nota.between' => 'A nota deve estar entre 1 e 5'
        ];
    }
}
