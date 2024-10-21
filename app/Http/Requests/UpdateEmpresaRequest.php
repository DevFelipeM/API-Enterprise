<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmpresaRequest extends FormRequest
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
            'nome' => 'nullable|string|max:255',
            'cnpj' => 'nullable|string|size:14|unique:empresas,cnpj,' . $this->route('empresa'),
            'endereco' => 'nullable|string|max:255',
        ];
    }
    public function messages(): array
    {
        return [
            'nome.string' => 'O nome deve ser uma string.',
            'nome.max' => 'O nome não pode ter mais de 255 caracteres.',

            'cnpj.string' => 'O CNPJ deve ser uma string.',
            'cnpj.size' => 'O CNPJ deve ter 14 caracteres.',
            'cnpj.unique' => 'O CNPJ já está em uso.',

            'endereco.string' => 'O endereço deve ser uma string.',
            'endereco.max' => 'O endereço não pode ter mais de 255 caracteres.',
        ];
    }
}
