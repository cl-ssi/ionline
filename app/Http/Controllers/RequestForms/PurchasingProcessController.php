<?php

namespace App\Http\Controllers\RequestForms;

use App\Models\RequestForms\PurchasingProcess;
use Illuminate\Http\Request;

use App\Models\RequestForms\RequestForm;
use App\User;
use App\Models\Parameters\Supplier;
use App\Models\RequestForms\InternalPurchaseOrder;
use App\Models\RequestForms\InternalPmItem;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PurchasingProcessController extends Controller
{
    public function index()
    {
        //By Purchaser
        if(Auth()->user()->organizational_unit_id == 37){
            $purchaser = User::with('requestForms')
                ->latest()
                ->whereHas('requestForms', function ($q){
                    $q->where('status', 'approved');
                })
                ->where('id', Auth()->user()->id)
                ->first();

            return view('request_form.purchase.index', compact('purchaser'));
        }
        else{
          session()->flash('danger', 'Estimado Usuario/a: Usted no pertence a la Unidad de Abastecimiento.');
          return redirect()->route('request_forms.my_forms');
        }
    }

    public function purchase(RequestForm $requestForm)
    {
        if(Auth()->user()->organizational_unit_id == 37){
            $suppliers = Supplier::orderBy('name','asc')->get();
            return view('request_form.purchase.purchase', compact('requestForm', 'suppliers'));
        }
        else{
            session()->flash('danger', 'Estimado Usuario/a: Usted no pertence a la Unidad de Abastecimiento.');
            return redirect()->route('request_forms.my_forms');
        }
    }

    public function create_internal_oc(Request $request, RequestForm $requestForm)
    {
        $purchasingProcess = new PurchasingProcess();

        $purchasingProcess->purchase_mechanism_id = $requestForm->purchase_mechanism_id;
        $purchasingProcess->purchase_type_id      = $requestForm->purchase_type_id;
        $purchasingProcess->start_date            = Carbon::now();
        $purchasingProcess->status                = 'complete';
        $purchasingProcess->user_id               = Auth::user()->id;
        $purchasingProcess->request_form_id       = $requestForm->id;
        $purchasingProcess->save();

        foreach($request->item_id as $item){
            $internalPurchaseOrder                          = new InternalPurchaseOrder();
            $internalPurchaseOrder->date                    = Carbon::now();
            $internalPurchaseOrder->supplier_id             = $request->supplier_id;
            $internalPurchaseOrder->payment_condition       = $request->payment_condition;
            $internalPurchaseOrder->user_id                 = Auth::user()->id;
            $internalPurchaseOrder->purchasing_process_id   = $purchasingProcess->id;
            $internalPurchaseOrder->estimated_delivery_date = $request->estimated_delivery_date;
            $internalPurchaseOrder->save();

            $internalPmItem = new InternalPmItem();
            $internalPmItem->internal_purchase_order_id = $internalPurchaseOrder->id;
            $internalPmItem->item_id = $item;
            $internalPmItem->save();

        }

        return redirect()->route('request_forms.supply.purchase', compact('requestForm'));
    }
}
