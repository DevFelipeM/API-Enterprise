<?php

namespace App\Http\Requests;

use App\Rules\CpfValidator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateFuncionarioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Permitir a autorização
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
{
    return [
        'nome' => 'nullable|string|max:255',
        'cpf' => [
            'string',
            Rule::unique('funcionarios')->ignore($this->route('funcionario')),
            new CpfValidator()
        ],
        'dataDeNascimento' => 'nullable|date',
        'file' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
        'empresa_id' => 'nullable|exists:empresas,id',
        'cargo' => 'nullable|string|max:255', 
    ];
}

public function messages(): array
{
    return [
        'nome.string' => 'O nome deve ser uma string.',
        'nome.max' => 'O nome não pode ter mais de 255 caracteres.',

        'cpf.string' => 'O CPF deve ser uma string.',
        'cpf.unique' => 'O CPF já está em uso.',

        'dataDeNascimento.date' => 'A data de nascimento deve ser uma data válida.',

        'file.file' => 'O arquivo deve ser um arquivo válido.',
        'file.mimes' => 'O arquivo deve ser do tipo jpeg, png ou jpg.',
        'file.max' => 'O arquivo não pode ser maior que 2048 kilobytes.',

        'empresa_id.exists' => 'O ID da empresa não foi encontrado.',

        'cargo.string' => 'O cargo deve ser uma string.',
        'cargo.max' => 'O cargo não pode ter mais de 255 caracteres.',
    ];
}

}
