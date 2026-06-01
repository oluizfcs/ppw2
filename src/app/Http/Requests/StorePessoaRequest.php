<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePessoaRequest extends FormRequest
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
            'cpf' => 'required|string|max:45|unique:pessoa,cpf',
            'nome' => 'required|string|min:2|max:45',
            'data_nascimento' => 'required|date|date_format:Y-m-d',
            'biografia' => 'required|string|max:2000',
            'genero' => 'required|string|max:10',
            'nacionalidade' => 'required|string|max:45',
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
            'cpf.required' => 'O campo CPF é obrigatório.',
            'cpf.unique' => 'Este CPF já está cadastrado.',
            'cpf.max' => 'O CPF deve ter no máximo 45 caracteres.',
            'nome.required' => 'O campo nome é obrigatório.',
            'nome.min' => 'O nome deve ter pelo menos 2 caracteres.',
            'nome.max' => 'O nome deve ter no máximo 45 caracteres.',
            'data_nascimento.required' => 'A data de nascimento é obrigatória.',
            'data_nascimento.date' => 'A data de nascimento deve ser uma data válida.',
            'data_nascimento.date_format' => 'A data de nascimento deve estar no formato AAAA-MM-DD.',
            'biografia.required' => 'A biografia é obrigatória.',
            'biografia.max' => 'A biografia deve ter no máximo 2000 caracteres.',
            'genero.required' => 'O gênero é obrigatório.',
            'genero.max' => 'O gênero deve ter no máximo 10 caracteres.',
            'nacionalidade.required' => 'A nacionalidade é obrigatória.',
            'nacionalidade.max' => 'A nacionalidade deve ter no máximo 45 caracteres.',
            'imagens.required' => 'Envie ao menos uma imagem.',
            'imagens.min' => 'Envie ao menos uma imagem.',
            'imagens.max' => 'Máximo de 5 imagens por vez.',
            'imagens.*.image' => 'Todos os arquivos devem ser imagens.',
            'imagens.*.mimes' => 'As imagens devem ser do formato jpeg, png ou webp.',
            'imagens.*.max' => 'Cada imagem pode ter no máximo 2 MB.'
        ];
    }
}
