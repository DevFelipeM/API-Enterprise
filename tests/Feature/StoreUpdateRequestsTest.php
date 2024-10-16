<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Http\Requests\StoreFuncionarioRequest;
use App\Http\Requests\UpdateFuncionarioRequest;
use Illuminate\Support\Facades\Validator;
use App\Models\Empresa;
use App\Models\Funcionario;

class StoreUpdateRequestsTest extends TestCase
{
    use RefreshDatabase;

    public function testStoreFuncionarioRequestValidation()
    {
        // Arrange
        $empresa = Empresa::create([
            'nome' => 'Empresa Teste',
            'cnpj' => '12345678000199',
            'endereco' => 'Endereço Teste',
        ]);

        $data = [
            'nome' => 'Funcionario Teste',
            'cpf' => '12345678901',
            'empresa_id' => $empresa->id,
            'cargo' => 'Desenvolvedor'
        ];

        $request = new StoreFuncionarioRequest();
        $validator = Validator::make($data, $request->rules());

        $this->assertFalse($validator->fails()); // Verifica se não falha

        // Testar com dados inválidos
        $dataInvalid = [
            'nome' => '', 
            'cpf' => '123', 
            'empresa_id' => 9999, 
            'cargo' => '' 
        ];

        $validator = Validator::make($dataInvalid, $request->rules());
        $this->assertTrue($validator->fails()); // Verifica se falha
    }

    public function testUpdateFuncionarioRequestValidation()
    {
        $empresa = Empresa::create([
            'nome' => 'Empresa Teste',
            'cnpj' => '12345678000199',
            'endereco' => 'Endereço Teste',
        ]);

        $funcionario = Funcionario::create([
            'nome' => 'Funcionario Teste',
            'cpf' => '12345678901',
            'empresa_id' => $empresa->id,
            'cargo' => 'Desenvolvedor'
        ]);

        $data = [
            'nome' => 'Funcionario Atualizado',
            'cpf' => '12345678902',
            'empresa_id' => $empresa->id,
            'cargo' => 'Gerente'
        ];

        // Act
        $request = new UpdateFuncionarioRequest();
        $validator = Validator::make($data, $request->rules());

        // Assert
        $this->assertFalse($validator->fails()); // Verifica se não falha

        // Testar com dados inválidos
        $dataInvalid = [
            'nome' => '', 
            'cpf' => '123', 
            'empresa_id' => 9999, 
            'cargo' => '' 
        ];

        $validator = Validator::make($dataInvalid, $request->rules());
        $this->assertTrue($validator->fails()); 
    }
}
