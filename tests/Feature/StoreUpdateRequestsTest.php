<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Http\Requests\StoreFuncionarioRequest;
use App\Http\Requests\UpdateFuncionarioRequest;
use Illuminate\Support\Facades\Validator;
use App\Models\Empresa;
use App\Models\Funcionario;
use Database\Factories\FuncionarioFactory;

class StoreUpdateRequestsTest extends TestCase
{
    use RefreshDatabase;

    public function testStoreFuncionarioRequestValidation()
    {
        // $empresa = Empresa::factory()->count(11)->create();

        ////////// FUNCIONÁRIO //////////
       $funcionario = Funcionario::factory()->create();

        $this->assertNotNull($funcionario->id, 'O id do funcionário não deve ser nulo.');
        
        $this->assertIsString($funcionario->cpf, 'O CPF deve ser uma string.');
        $this->assertEquals(11, strlen($funcionario->cpf), 'O CPF deve ter 11 dígitos.');
        
        $this->assertNotNull($funcionario->empresa_id, 'O ID da empresa associada não deve ser nulo.');
        
        $this->assertDatabaseHas('empresas', [
            'id' => $funcionario->empresa_id,
        ], 'sqlite');

        ///////// EMPRESA //////////
        $empresa = Empresa::factory()->create();

        $this->assertNotNull($empresa->id, 'O ID da empresa não deve ser nulo.');

        $this->assertIsString($empresa->nome, 'O nome da empresa deve ser uma string.');
        $this->assertNotEmpty($empresa->nome, 'O nome da empresa não deve estar vazio.');

        $this->assertDatabaseHas('empresas', [
            'id' => $empresa->id,
            'nome' => $empresa->nome,
        ], 'sqlite');
    }

    public function testUpdateFuncionarioRequestValidation()
    {
        $empresa = Empresa::factory()->create();
        $funcionario = Funcionario::factory()->create([
            'empresa_id' => $empresa->id,
        ]);

        $updatedData = [
            'nome' => 'Nome Atualizado',
            'cpf' => '12345678901', 
            'dataDeNascimento' => '1990-01-01',
            'file' => null, 
            'empresa_id' => $empresa->id,
            'cargo' => 'Cargo Atualizado',
        ];

        $response = $this->put(route('funcionarios.update', $funcionario), $updatedData);

        $response->assertStatus(200);

        $this->assertDatabaseHas('funcionarios', [
            'id' => $funcionario->id,
            'nome' => $updatedData['nome'],
            'cpf' => $updatedData['cpf'],
            'dataDeNascimento' => $updatedData['dataDeNascimento'],
            'empresa_id' => $updatedData['empresa_id'],
            'cargo' => $updatedData['cargo'],
        ], 'sqlite');
    }
}
