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
            'poster' => 'sometimes|image|mimes:jpeg,png,webp|max:2048',
            'imagens' => 'sometimes|array|min:1|max:5',
            'imagens.*' => 'image|mimes:jpeg,png,webp|max:2048',
            'generos' => 'required|array|min:1',
            'estudios' => 'sometimes|array',
            'estudios.*' => 'exists:estudio,id',
            // 'diretores' => 'sometimes|array',
            // 'diretores.*' => 'exists:pessoa,id',
            // 'produtores' => 'sometimes|array',
            // 'produtores.*' => 'exists:pessoa,id',
            // 'escritores' => 'sometimes|array',
            // 'escritores.*' => 'exists:pessoa,id',
            // 'atores' => 'sometimes|array',
            // 'atores.*' => 'exists:pessoa,id',
            // 'papeis' => 'sometimes|array',
            // 'papeis.*' => 'required|string|max:45'

            'vinculos' => 'nullable|array',
            'vinculos.*.pessoa_id' => 'required_with:vinculos|integer|exists:pessoa,id',
            'vinculos.*.tipo' => 'required_with:vinculos|in:ator,diretor,produtor,escritor',
            'vinculos.*.papel' => 'sometimes|max:100',


            'remover_vinculos' => 'nullable|array',
            'remover_vinculos.atores' => 'nullable|array',
            'remover_vinculos.atores.*' => 'integer|exists:ator,id',
            'remover_vinculos.diretores' => 'nullable|array',
            'remover_vinculos.diretores.*' => 'integer|exists:diretor,id',
            'remover_vinculos.produtores' => 'nullable|array',
            'remover_vinculos.produtores.*' => 'integer|exists:produtor,id',
            'remover_vinculos.escritores' => 'nullable|array',
            'remover_vinculos.escritores.*' => 'integer|exists:escritor,id',
            
            'atores_existentes' => 'nullable|array',
            'atores_existentes.*.papel' => 'sometimes|max:100',

        ];
    }
}
