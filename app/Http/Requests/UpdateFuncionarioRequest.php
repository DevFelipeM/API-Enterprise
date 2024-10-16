<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'email' => 'nullable|email|unique:funcionarios,email,' . $this->route('funcionario'), 
            'telefone' => 'nullable|string|max:15', 
            'empresa_id' => 'nullable|exists:empresas,id', 
        ];
    }
}
