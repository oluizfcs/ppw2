<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateFilmeRequest extends FormRequest
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
            'nome' => 'required|string|min:2|max:255',
            'duracao' => 'required|integer|min:1',
            'sinopse' => 'nullable|string|max:2000',
            'classificacao' => 'nullable|string|max:45',
            'data_lancamento' => 'required|date|date_format:Y-m-d',
            'poster' => 'sometimes|image|mimes:jpeg,png,webp|max:2048'
        ];
    }
}
