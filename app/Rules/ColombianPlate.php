<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ColombianPlate implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Formato: ABC123 o ABC12D
        if (!preg_match('/^[A-Z]{3}[0-9]{2}[0-9A-Z]$/', strtoupper($value))) {
            $fail('La placa debe tener el formato colombiano (ej: ABC123 o ABC12D)');
        }
    }
}