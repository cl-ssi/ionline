<?php

namespace App\Observers\Documents;

use App\Models\Documents\Approval;
use App\Notifications\Documents\NewApproval;

class ApprovalObserver
{
    /**
     * Handle the Approval "creating" event.
     */
    public function creating(Approval $approval): void
    {
        /**
         * Obtener las iniciales para cada sent_to_ou_id o sent_to_user_id
         */
        if ($approval->sentToOu) {
            $approval->initials = $approval->sentToOu->initials;
        } elseif ($approval->sentToUser) {
            $approval->initials = $approval->sentToUser->initials;
        }
    }

    /**
     * Handle the Approval "created" event.
     */
    public function created(Approval $approval): void
    {
        /** Enviar notificación al jefe de la unidad  */
        if($approval->sent_to_ou_id AND $approval->active) {
            $approval->sentToOu->currentManager?->user?->notify(new NewApproval($approval));
        }

        /** Si tiene un aprobador en particular envia la notificación al usuario específico */
        if($approval->sent_to_user_id AND $approval->active) {
            $approval->sentToUser->notify(new NewApproval($approval));
        }

        /** Agregar el approval_id al comienzo de los parámetros del callback */
        /** Solo si tiene un callback controller method */
        if($approval->callback_controller_method) {
            $params = json_decode($approval->callback_controller_params,true) ?? [];
            $approval->callback_controller_params = json_encode(array_merge(array('approval_id' => $approval->id), $params));
            $approval->save();
        }

    }

    /**
     * Handle the Approval "updated" event.
     */
    public function updated(Approval $approval): void
    {
        /** Preguntar si el estado cambio de null a true (los falsos no continuan la cadena) */
        if ( $approval->status === true ) {
            /* Preguntar si tiene un NextApproval (es en cadena) */
            if ($approval->nextApproval) {
                /** Activar el NextApproval */
                $approval->nextApproval->update(['active' => true]);

                /** Notificar al jefe de unidad o persona */
                /** Enviar notificación al jefe de la unidad  */
                if($approval->nextApproval->sent_to_ou_id) {
                    $approval->nextApproval->sentToOu->currentManager?->user?->notify(new NewApproval($approval->nextApproval));
                }
                /** Si tiene un aprobador en particular envia la notificación al usuario específico */
                if($approval->nextApproval->sent_to_user_id) {
                    $approval->nextApproval->sentToUser->notify(new NewApproval($approval->nextApproval));
                }
            }
        }
    }

    /**
     * Handle the Approval "deleted" event.
     */
    public function deleted(Approval $approval): void
    {
        //
    }

    /**
     * Handle the Approval "restored" event.
     */
    public function restored(Approval $approval): void
    {
        //
    }

    /**
     * Handle the Approval "force deleted" event.
     */
    public function forceDeleted(Approval $approval): void
    {
        //
    }
}
