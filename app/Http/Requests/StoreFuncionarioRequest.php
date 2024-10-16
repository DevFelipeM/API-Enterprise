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
}
