<?php

namespace App\Filament\Clusters\Finance\Resources\ReceptionResource\Pages;

use App\Filament\Clusters\Finance\Resources\ReceptionResource;
use App\Models\Finance\PurchaseOrder;
use App\Models\Finance\Receptions\Reception;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditReception extends EditRecord
{
    protected static string $resource = ReceptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    // protected function beforeSave(): void
    // {
    //     dd($this->getRecord());
    //     $this->halt();
    // }

    // public function mount($record): void
    // {
    //     parent::mount($record);

    //     $reception = Reception::find($record);

    //     // Ejecutar el código de las líneas 49 a 54
    //     $globalPurchaseOrder = PurchaseOrder::with(['requestForm', 'receptions', 'dtes'])
    //         ->where('code' ,$reception->purchase_order)
    //         ->first();

    //     // // Almacenar la orden de compra en una variable de estado
    //     // $this->form->fill([
    //     //     'globalPurchaseOrder' => $globalPurchaseOrder, // Aquí seteas la variable del formulario
    //     // ]);
    // }
}
