<?php

namespace App\Http\Controllers\RequestForms;

use App\Documents\Document;
use App\Models\RequestForms\PurchasingProcess;
use Illuminate\Http\Request;

use App\Models\RequestForms\RequestForm;
use App\User;
use App\Models\Parameters\Supplier;
use App\Models\RequestForms\InternalPurchaseOrder;
use App\Models\RequestForms\InternalPmItem;

use App\Http\Controllers\Controller;
use App\Models\RequestForms\FundToBeSettled;
use App\Models\RequestForms\PettyCash;
use App\Models\RequestForms\PurchasingProcessDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PurchasingProcessController extends Controller
{
    public function index()
    {
        if(Auth()->user()->organizational_unit_id != 37){
            session()->flash('danger', 'Estimado Usuario/a: Usted no pertence a la Unidad de Abastecimiento.');
            return redirect()->route('request_forms.my_forms');
        }

        $requestForms = RequestForm::where('status', 'approved')->whereNotNull('signatures_file_id')
            ->whereHas('purchasers', function ($q){
                return $q->where('users.id', Auth()->user()->id);
            })->latest()->get();

        return view('request_form.purchase.index', compact('requestForms'));
    }

    public function purchase(RequestForm $requestForm)
    {
        if(Auth()->user()->organizational_unit_id == 37){
            $requestForm->load('user', 'userOrganizationalUnit', 'contractManager', 'requestFormFiles', 'purchasingProcess.details', 'eventRequestForms.signerOrganizationalUnit', 'eventRequestForms.signerUser');
            // return $requestForm;
            $isBudgetEventSignPending = $requestForm->eventRequestForms()->where('status', 'pending')->where('event_type', 'budget_event')->count() > 0;
            if($isBudgetEventSignPending) session()->flash('warning', 'Estimado/a usuario/a: El formulario de requerimiento tiene una firma pendiente de aprobación por concepto de presupuesto, por lo que no podrá agregar o quitar compras hasta que no se haya notificado de la resolución de la firma.');
            $suppliers = Supplier::orderBy('name','asc')->get();
            return view('request_form.purchase.purchase', compact('requestForm', 'suppliers', 'isBudgetEventSignPending'));
        }
        else{
            session()->flash('danger', 'Estimado Usuario/a: Usted no pertence a la Unidad de Abastecimiento.');
            return redirect()->route('request_forms.my_forms');
        }
    }

    public function create(RequestForm $requestForm)
    {
        $purchasingProcess = new PurchasingProcess();

        $purchasingProcess->purchase_mechanism_id = $requestForm->purchase_mechanism_id;
        $purchasingProcess->purchase_type_id      = $requestForm->purchase_type_id;
        $purchasingProcess->start_date            = Carbon::now();
        $purchasingProcess->status                = 'in_process';
        $purchasingProcess->user_id               = Auth::user()->id;
        $purchasingProcess->request_form_id       = $requestForm->id;
        $purchasingProcess->save();
        return $purchasingProcess;
    }

    public function estimated_expense_exceeded(RequestForm $requestForm)
    {
        //total del monto por items seleccionados + item registrados no debe sobrepasar el total del presupuesto asignado al formulario de requerimiento
        $totalItemPurchased = 0;
        if($requestForm->purchasingProcess->details) $totalItemPurchased = $requestForm->purchasingProcess->getExpense();

        $totalItemSelected = 0;
        foreach(request()->item_id as $key => $item)
            $totalItemSelected += request()->item_total[$key];

        return $totalItemPurchased + $totalItemSelected > $requestForm->estimated_expense;
    }

    public function create_internal_oc(Request $request, RequestForm $requestForm)
    {
        $requestForm->load('purchasingProcess.details');
        if($this->estimated_expense_exceeded($requestForm)){
            session()->flash('danger', 'Estimado Usuario/a: El monto total por los items que está seleccionando más los ya registrados sobrepasa el monto total del presupuesto.');
            return redirect()->back()->withInput();
        }

        if(!$requestForm->purchasingProcess) $requestForm->purchasingProcess = $this->create($requestForm);

        $internalPurchaseOrder                          = new InternalPurchaseOrder();
        $internalPurchaseOrder->date                    = Carbon::now();
        $internalPurchaseOrder->supplier_id             = $request->supplier_id;
        $internalPurchaseOrder->payment_condition       = $request->payment_condition;
        $internalPurchaseOrder->estimated_delivery_date = $request->estimated_delivery_date;
        $internalPurchaseOrder->save();

        foreach($request->item_id as $key => $item){
            $detail = new PurchasingProcessDetail();
            $detail->purchasing_process_id      = $requestForm->purchasingProcess->id;
            $detail->item_request_form_id       = $item;
            $detail->internal_purchase_order_id = $internalPurchaseOrder->id;
            $detail->user_id                    = Auth::user()->id;
            $detail->quantity                   = $request->quantity[$key];
            $detail->unit_value                 = $request->unit_value[$key];
            $detail->expense                    = $request->item_total[$key];
            $detail->status                     = 'total';
            $detail->save();
        }

        return redirect()->route('request_forms.supply.purchase', compact('requestForm'));
    }

    public function create_petty_cash(Request $request, RequestForm $requestForm)
    {
        $requestForm->load('purchasingProcess.details');
        if($this->estimated_expense_exceeded($requestForm)){
            session()->flash('danger', 'Estimado Usuario/a: El monto total por los items que está seleccionando más los ya registrados sobrepasa el monto total del presupuesto.');
            return redirect()->back()->withInput();
        }

        if(!$requestForm->purchasingProcess) $requestForm->purchasingProcess = $this->create($requestForm);

        $pettyCash                          = new PettyCash();
        $pettyCash->date                    = $request->date;
        $pettyCash->receipt_type            = $request->receipt_type;
        $pettyCash->receipt_number          = $request->receipt_number;
        $pettyCash->amount                  = $request->amount;
        $pettyCash->save();

        $now = Carbon::now()->format('Y_m_d_H_i_s');
        $file_name = $now.'_petty_cash_file_'.$pettyCash->id;
        $pettyCash->file = $request->file ? $request->file->storeAs('/ionline/request_forms_dev/purchase_item_files', $file_name.'.'.$request->file->extension(), 'gcs') : null;
        $pettyCash->save();

        foreach($request->item_id as $key => $item){
            $detail = new PurchasingProcessDetail();
            $detail->purchasing_process_id      = $requestForm->purchasingProcess->id;
            $detail->item_request_form_id       = $item;
            $detail->petty_cash_id              = $pettyCash->id;
            $detail->user_id                    = Auth::user()->id;
            $detail->quantity                   = $request->quantity[$key];
            $detail->unit_value                 = $request->unit_value[$key];
            $detail->expense                    = $request->item_total[$key];
            $detail->status                     = 'total';
            $detail->save();
        }

        return redirect()->route('request_forms.supply.purchase', compact('requestForm'));
    }

    public function create_fund_to_be_settled(Request $request, RequestForm $requestForm)
    {
        $requestForm->load('purchasingProcess.details');
        if($this->estimated_expense_exceeded($requestForm)){
            session()->flash('danger', 'Estimado Usuario/a: El monto total por los items que está seleccionando más los ya registrados sobrepasa el monto total del presupuesto.');
            return redirect()->back()->withInput();
        }

        if(!$requestForm->purchasingProcess) $requestForm->purchasingProcess = $this->create($requestForm);

        $fundToBeSettled                          = new FundToBeSettled();
        $fundToBeSettled->date                    = Carbon::now();
        $fundToBeSettled->amount                  = $request->amount;
        $fundToBeSettled->document_id             = Document::where('number', $request->memo_number)->where('type', 'Memo')->first()->id;
        $fundToBeSettled->save();

        foreach($request->item_id as $key => $item){
            $detail = new PurchasingProcessDetail();
            $detail->purchasing_process_id      = $requestForm->purchasingProcess->id;
            $detail->item_request_form_id       = $item;
            $detail->fund_to_be_settled_id      = $fundToBeSettled->id;
            $detail->user_id                    = Auth::user()->id;
            $detail->quantity                   = $request->quantity[$key];
            $detail->unit_value                 = $request->unit_value[$key];
            $detail->expense                    = $request->item_total[$key];
            $detail->status                     = 'total';
            $detail->save();
        }

        return redirect()->route('request_forms.supply.purchase', compact('requestForm'));
    }
}
