<?php

namespace App\Observers;

use App\Models\Allowances\Allowance;
use App\Models\Documents\Correlative;

class AllowanceObserver
{
    /**
     * Handle the Allowance "creating" event.
     */
    public function creating(Allowance $allowance): void
    {
        //Obtengo el año de creación de viático y la cantidad de viáticos.
        $year = now()->year;
        $countAllowanceCurrentYear = Allowance::whereYear('created_at', $year)
            ->where('establishment_id', $allowance->establishment_id)
            ->count();

        if($countAllowanceCurrentYear == 0){
            $allowance->correlative = 1;
        }
        else{
            $lastCorrelative = Allowance::orderBy('correlative', 'desc')
                ->where('establishment_id', $allowance->establishment_id)
                ->whereYear('created_at', $year)
                ->first();

            $allowance->correlative = $lastCorrelative->correlative + 1;
        }
    }

    /**
     * Handle the Allowance "updated" event.
     */
    public function updated(Allowance $allowance): void
    {
        //
    }

    /**
     * Handle the Allowance "deleted" event.
     */
    public function deleted(Allowance $allowance): void
    {
        //
    }

    /**
     * Handle the Allowance "restored" event.
     */
    public function restored(Allowance $allowance): void
    {
        //
    }

    /**
     * Handle the Allowance "force deleted" event.
     */
    public function forceDeleted(Allowance $allowance): void
    {
        //
    }
}
