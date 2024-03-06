<?php

namespace App\Http\Controllers\Pharmacies;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Pharmacies\Batch;
use App\Models\Pharmacies\ReceivingItem;
use App\Models\Pharmacies\PurchaseItem;
use App\Models\Pharmacies\DispatchItem;

class BatchController extends Controller
{
    public function update(Request $request, Batch $batch){
        $batch->receivingItems()->update(['batch' => $request->batch, 'due_date' => $request->due_date]);
        $batch->purchaseItems()->update(['batch' => $request->batch, 'due_date' => $request->due_date]);
        $batch->dispatchItems()->update(['batch' => $request->batch, 'due_date' => $request->due_date]);
        $batch->update(['batch' => $request->batch, 'due_date' => $request->due_date]);

        session()->flash('success', 'Se modificó la información.');
        return redirect()->back();
    }
}
