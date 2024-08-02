<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Str;

class Utilily
{
    /**
     * Create a new class instance.
     */
    public static function generateUsername(string $name): string
    {
        $username = Str::slug($name);
        $originalUsername = $username;

        // Verificar si el nombre de usuario ya existe en la base de datos
        $counter = 1;
        while (User::where('username', $username)->exists()) {
            $username = $originalUsername . $counter;
            $counter++;
        }

        return $username;
    }
}
