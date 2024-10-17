<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFuncionarioRequest extends FormRequest
{
    /**
     * Determine se o usuário está autorizado a fazer este pedido.
     */
    public function authorize(): bool
    {
        return true; // Autoriza todas as requisições
    }

    /**
     * Obtém as regras de validação que se aplicam ao pedido.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [      
            'nome' => 'required|string|max:255', 
            'cpf' => 'required|string|size:11|unique:funcionarios,cpf', 
            'empresa_id' => 'required|exists:empresas,id', 
            'cargo' => 'required|string|max:255', 
        ];
    }
    public function messages(): array
    {
        return[
            'nome.required' => 'O nome é obrigatório.',
            'nome.string' => 'O nome deve ser uma string.',
            'nome.max' => 'O nome não pode ter mais de 255 caracteres.',

            'cpf.required' => 'O CPF é obrigatório.',
            'cpf.string' => 'O CPF deve ser uma string.',
            'cpf.size' => 'O CPF deve ter 11 caracteres.',
            'cpf.unique' => 'O CPF já está em uso.',

            'empresa_id.required' => 'O ID da empresa é obrigatório.',
            'empresa_id.exists' => 'Id de empresa não encontrado.',

            'cargo.required' => 'O cargo é obrigatório.',
            'cargo.string' => 'O cargo deve ser uma string.',
            'cargo.max' => 'O cargo não pode ter mais de 255 caracteres.',
        ];
    }
}
