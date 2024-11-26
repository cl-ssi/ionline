<?php

namespace App\Policies\Welfare\Benefits;

use App\Models\User;
use Carbon\Carbon;

class BenefitPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Lista de permisos permitidos
        $allowedPermissions = [
            'welfare: benefits',
            'be god',
        ];

        // Verificar si el usuario tiene uno de los permisos permitidos
        if ($user->hasAnyPermission($allowedPermissions)) {
           return true;
        }

        $now = Carbon::now();

        // Fecha de inicio: 19 de diciembre a las 12:00 PM
        $start = Carbon::create(2024, 12, 19, 12, 0, 0);

        // Fecha de fin: 2 de enero a las 8:00 AM
        $end = Carbon::create(2025, 1, 2, 8, 0, 0);

        // Devuelve false si estamos dentro del rango de fechas
        if ($now->between($start, $end)) {
            return false;
        }

        // Fuera del rango de fechas, devolver true
        return true;
    }
}
