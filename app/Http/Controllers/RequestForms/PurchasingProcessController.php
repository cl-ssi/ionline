<?php

namespace App\Http\Controllers\RequestForms;

use App\Models\RequestForms\PurchasingProcess;
use Illuminate\Http\Request;

use App\Models\RequestForms\RequestForm;
use App\User;
use App\Models\Parameters\Supplier;
use App\Models\RequestForms\InternalPurchaseOrder;

use App\Http\Controllers\Controller;
use App\Models\RequestForms\PettyCash;
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
            $requestForm->load('user', 'userOrganizationalUnit', 'contractManager', 'requestFormFiles', 'purchasingProcesses');
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
            $internalPurchaseOrder->supplier_id             = $item;
            $internalPurchaseOrder->payment_condition       = $request->payment_condition;
            $internalPurchaseOrder->user_id                 = Auth::user()->id;
            $internalPurchaseOrder->purchasing_process_id   = $purchasingProcess->id;
            $internalPurchaseOrder->estimated_delivery_date = $request->estimated_delivery_date;
            $internalPurchaseOrder->save();
        }

        return redirect()->route('request_forms.supply.purchase', compact('requestForm'));
    }

    public function create_petty_cash(Request $request, RequestForm $requestForm)
    {
        $purchasingProcess = new PurchasingProcess();

        $purchasingProcess->purchase_mechanism_id = $requestForm->purchase_mechanism_id;
        $purchasingProcess->purchase_type_id      = $requestForm->purchase_type_id;
        $purchasingProcess->start_date            = Carbon::now();
        $purchasingProcess->status                = 'complete';
        $purchasingProcess->user_id               = Auth::user()->id;
        $purchasingProcess->request_form_id       = $requestForm->id;
        $purchasingProcess->save();

        // foreach($request->item_id as $item){
            $pettyCash                          = new PettyCash();
            $pettyCash->date                    = $request->date;
            $pettyCash->receipt_type            = $request->receipt_type;
            $pettyCash->receipt_number          = $request->receipt_number;
            $pettyCash->amount                  = $request->amount;
            $pettyCash->user_id                 = Auth::user()->id;
            $pettyCash->purchasing_process_id   = $purchasingProcess->id;
            $pettyCash->save();
        // }

        $now = Carbon::now()->format('Y_m_d_H_i_s');
        $file_name = $now.'_petty_cash_file_'.$pettyCash->id;
        $pettyCash->file = $request->file ? $request->file->storeAs('/ionline/request_forms_dev/purchase_item_files', $file_name.'.'.$request->file->extension(), 'gcs') : null;
        $pettyCash->save();

        return redirect()->route('request_forms.supply.purchase', compact('requestForm'));
    }
}
