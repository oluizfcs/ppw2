<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class StoreFilmeRequest extends FormRequest
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
            'classificacao' => 'required|string|max:45',
            'data_lancamento' => 'required|date|date_format:Y-m-d',
            'imagens' => 'required|array|min:1',
            'imagens.*' => 'image|mimes:jpeg,png,webp|max:2048',
            'poster_index' => 'nullable|integer|min:0',
            'generos' => 'sometimes|array',
            'estudios' => 'sometimes|array',
            'estudios.*' => 'exists:estudio,id',
            'vinculos' => 'nullable|array',
            'vinculos.*.pessoa_id' => 'required_with:vinculos|integer|exists:pessoa,id',
            'vinculos.*.tipo' => 'required_with:vinculos|in:ator,diretor,produtor,escritor',
            'vinculos.*.papel' => 'nullable|string|max:45',
        ];
    }

    public function messages()
    {
        return [
            'nome.required' => 'O campo nome é obrigatório',
            'nome.min' => 'O campo nome deve ter pelo menos 2 caracteres',
            'nome.max' => 'O campo nome deve ter no máximo 255 caracteres',
            'duracao.required' => 'O campo duração é obrigatório',
            'duracao.min' => 'O filme deve ter pelo menos 1 segundo de duração',
            'data_lancamento' => 'O campo data de lançamento é obrigatório',
            'imagens.required' => 'Adicione ao menos uma imagem',
            'imagens.*.image' => 'Todos os arquivos devem ser imagens.',
            'imagens.*.max' => 'Cada imagem pode ter no máximo 2 MB.',
        ];
    }
}
