<?php

namespace Database\Factories;

use App\Models\Empresa;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Empresa>
 */
class EmpresaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $model = Empresa::class;

        $cnpj = $this->generateValidCnpj();
        return [
            'nome' => fake()->text(10),
            'cnpj' => $cnpj
        ];
    }
    public function generateValidCnpj(): string
{
    $cnpj = array_map(fn() => rand(0, 9), range(1, 12)); 

    $cnpj[] = $this->calculateCnpjDigit($cnpj, [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2]); // Primeiro dígito verificador
    $cnpj[] = $this->calculateCnpjDigit($cnpj, [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2]); // Segundo dígito verificador

    return implode('', $cnpj);
}

private function calculateCnpjDigit(array $cnpj, array $weights): int
{
    $sum = array_reduce(array_keys($weights), fn($carry, $i) => $carry + $cnpj[$i] * $weights[$i], 0);
    $remainder = $sum % 11;

    return $remainder < 2 ? 0 : 11 - $remainder;
}

}
