<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEstudioRequest extends FormRequest
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
            'nome' => 'required|string|min:2|max:45|unique:estudio,nome',
            'local' => 'nullable|string|max:45',
            'imagens' => 'required|array|min:1|max:5',
            'imagens.*' => 'image|mimes:jpeg,png,webp|max:2048'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'nome.required' => 'O campo nome é obrigatório.',
            'nome.min' => 'O nome do estúdio deve ter pelo menos 2 caracteres.',
            'nome.max' => 'O nome do estúdio deve ter no máximo 45 caracteres.',
            'nome.unique' => 'Este estúdio já está cadastrado.',
            'local.max' => 'O local deve ter no máximo 45 caracteres.',
            'imagens.required' => 'Envie ao menos uma imagem.',
            'imagens.min' => 'Envie ao menos uma imagem.',
            'imagens.max' => 'Máximo de 5 imagens por vez.',
            'imagens.*.image' => 'Todos os arquivos devem ser imagens.',
            'imagens.*.mimes' => 'As imagens devem ser do formato jpeg, png ou webp.',
            'imagens.*.max' => 'Cada imagem pode ter no máximo 2 MB.'
        ];
    }
}
