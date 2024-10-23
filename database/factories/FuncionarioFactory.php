<?php

namespace Database\Factories;

use App\Models\Empresa;
use App\Models\Funcionario;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Funcionario>
 */
class FuncionarioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        do {
            $cpf = $this->generateValidCpf();
        } while (Funcionario::where('cpf', $cpf)->exists());
        $empresa = Empresa::factory()->create();
        return [
            'nome' => fake()->text(10),
            'cargo' => fake()->text(12),
            'dataDeNascimento' => fake()->date('Y-m-d'),
            'file' => fake()->imageUrl(640, 480, 'people'),
            'empresa_id' => $empresa->id,
            'cpf' => $cpf
        ];
    }
    public function generateValidCpf(): string
    {
        $cpf = [];
    
        for ($i = 0; $i < 9; $i++) {
            $cpf[] = rand(0, 9);
        }

        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            $cpf[$t] = $d;
        }
    
        return implode('', $cpf);
    }
}
