<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class GeneroRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nome' => 'required|min:2|unique:genero,nome'
        ];
    }

    public function messages()
    {
        return [
            'nome.required' => 'O campo nome não pode estar vazio',
            'nome.min' => 'O nome do gênero deve conter ao menos 2 caracteres',
            'nome.unique' => 'Já existe um gênero com este nome'
        ];
    }
}
