<?php

namespace App\Filament\Clusters\Finance\Resources\ReceptionResource\Pages;

use App\Filament\Clusters\Finance\Resources\ReceptionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateReception extends CreateRecord
{
    protected static string $resource = ReceptionResource::class;

    protected function afterCreate(): void
    {
        $reception = $this->getRecord();
        $ctApprovals = $reception->approvals->count();
        foreach($reception->approvals as $key => $approval) {
            /* Setear el reception_id que se obtiene despues de hacer el Reception::create();*/
            $approval->document_route_params = json_encode([
                "reception_id" => $reception->id
            ]);

            /* Setear el filename */
            $approval->filename = "ionline/finances/receptions/{$reception->id}.pdf";

            /* Si hay mas de un approval y no es el primero */
            if( $key > 0 ) {
                /* Setea el previous_approval_id y active en false */
                $approval->previous_approval_id = $reception->approvals[$key - 1]->id;
                $approval->active = false;
            }

            /* Si es el último, entonces es el de firma electrónica */
            if (0 === --$ctApprovals) {
                $approval->digital_signature = true;
                $approval->callback_controller_method = 'App\Http\Controllers\Finance\Receptions\ReceptionController@approvalCallback';
                $approval->callback_controller_params = json_encode(value: ['approval_id' => $approval->id]);
            }

            $approval->save();
        }
    }
}
