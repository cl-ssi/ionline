<?php

namespace App\Observers;

use App\Models\Rrhh\Absenteeism; 
use App\Models\Rrhh\AbsenteeismType;
use Illuminate\Support\Facades\Auth;


class AbsenteeismObserver
{
    /**
     * Handle the Absenteeism "created" event.
     */
    public function created(Absenteeism $absenteeism): void
    {
        $absenteeism->rut = Auth::id();
        $absenteeism->dv = Auth::user()->dv;
        $absenteeism->nombre = Auth::user()->fullName;
        $absenteeism->tipo_de_ausentismo = AbsenteeismType::find($absenteeism->absenteeism_type_id)->name;
        $absenteeism->codigo_de_establecimiento = Auth::user()->establishment?->sirh_code;
        $absenteeism->nombre_de_establecimiento = Auth::user()->establishment?->name;
        $absenteeism->codigo_unidad = Auth::user()->organizationalUnit?->sirh_ou_id;
        $absenteeism->nombre_unidad = Auth::user()->organizationalUnit?->name;
        $absenteeism->edadanos = Auth::user()->age;
        $absenteeism->edadmeses = Auth::user()->ageMonths;

        // Guarda los cambios
        $absenteeism->save();
    }

    /**
     * Handle the Absenteeism "updated" event.
     */
    public function updated(Absenteeism $absenteeism): void
    {
        //
    }

    /**
     * Handle the Absenteeism "deleted" event.
     */
    public function deleted(Absenteeism $absenteeism): void
    {
        //
    }

    /**
     * Handle the Absenteeism "restored" event.
     */
    public function restored(Absenteeism $absenteeism): void
    {
        //
    }

    /**
     * Handle the Absenteeism "force deleted" event.
     */
    public function forceDeleted(Absenteeism $absenteeism): void
    {
        //
    }
}
