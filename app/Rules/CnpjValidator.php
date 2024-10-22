<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CnpjValidator implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  Closure  $fail
     * @return void
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Chama o método de validação do CNPJ
        $this->validateCNPJ($attribute, $value, $fail);
    }

    public function validateCNPJ(string $attribute, mixed $value, Closure $fail)
    {
        $c = preg_replace('/\D/', '', $value);

        $b = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];

        if (strlen($c) != 14) {
            return $fail("O campo $attribute não é um CNPJ válido.");
        }

        elseif (preg_match("/^{$c[0]}{14}$/", $c) > 0) {
            return $fail("O campo $attribute não é um CNPJ válido.");
        }

        for ($i = 0, $n = 0; $i < 12; $n += $c[$i] * $b[++$i]);

        if ($c[12] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
            return $fail("O campo $attribute não é um CNPJ válido.");
        }

        for ($i = 0, $n = 0; $i <= 12; $n += $c[$i] * $b[$i++]);

        if ($c[13] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
            return $fail("O campo $attribute não é um CNPJ válido.");
        }
    }
}
