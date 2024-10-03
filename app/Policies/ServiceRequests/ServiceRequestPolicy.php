<?php

namespace App\Policies\ServiceRequests;

use App\Models\ServiceRequests\ServiceRequest;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ServiceRequestPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ServiceRequest $serviceRequest): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ServiceRequest $serviceRequest): bool
    {
        // Lista de roles permitidos
        $allowedRoles = [
            'Honorarios: Creador de solicitud de contratos',
            'Honorarios: Encargado del área',
            'Honorarios: Finanzas',
            'Honorarios: RRHH',
        ];

        // Verificar si el usuario tiene uno de los roles permitidos
        if ($user->hasAnyRole($allowedRoles)) {
            // Obtener el establishment_id del usuario autenticado
            $user_establishment_id = $user->organizationalUnit->establishment_id;

            // Si el establecimiento del usuario es 38, solo permitir si el servicio no es de los establecimientos 1 y 41
            if ($user_establishment_id == 38) {
                return !in_array($serviceRequest->establishment_id, [1, 41]);
            }

            // Si el establecimiento del usuario no es 38, permitir solo si pertenece al mismo establecimiento
            return $serviceRequest->establishment_id == $user_establishment_id;
        }

        // Si no tiene los roles permitidos, solo permitir si el ServiceRequest pertenece a él mismo
        return $serviceRequest->user_id == $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ServiceRequest $serviceRequest): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ServiceRequest $serviceRequest): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ServiceRequest $serviceRequest): bool
    {
        //
    }
}
