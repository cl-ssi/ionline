<?php

namespace App\Http\Controllers\RequestForms;

use App\Models\Documents\Document;
use App\Models\RequestForms\PurchasingProcess;
use Illuminate\Http\Request;

use App\Models\RequestForms\RequestForm;
use App\Models\User;
use App\Models\Parameters\Supplier;
use App\Models\Parameters\Parameter;
use App\Models\RequestForms\InternalPurchaseOrder;
use App\Models\RequestForms\InternalPmItem;

use App\Http\Controllers\Controller;
use App\Models\RequestForms\AttachedFile;
use App\Models\RequestForms\FundToBeSettled;
use App\Models\RequestForms\ImmediatePurchase;
use App\Models\RequestForms\PettyCash;
use App\Models\RequestForms\PurchasingProcessDetail;
use App\Models\RequestForms\Tender;
use App\Models\RequestForms\DirectDeal;
use App\Models\RequestForms\PurchaseOrder;
use App\Models\WebService\MercadoPublico;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class PurchasingProcessController extends Controller
{
    public function index()
    {
        // $ouSearch = Parameter::where('module', 'ou')->whereIn('parameter', ['AbastecimientoSSI', 'AbastecimientoHAH', 'AdquisicionesHAH'])->pluck('value')->toArray();
        $ouSearch = array_unique(Parameter::get('Abastecimiento',['supply_ou_id', 'purchaser_ou_id']));
        if (!in_array(auth()->user()->organizational_unit_id, $ouSearch) && !auth()->user()->can('Request Forms: purchaser')) {
            session()->flash('danger', 'Estimado Usuario/a: Usted no pertenece a la Unidad de Abastecimiento o no tiene los permisos de acceso.');
            return redirect()->route('request_forms.my_forms');
        }

        return view('request_form.purchase.index');
    }

    public function purchase(RequestForm $requestForm)
    {
        // $ouSearch = Parameter::where('module', 'ou')->whereIn('parameter', ['AbastecimientoSSI', 'AbastecimientoHAH', 'AdquisicionesHAH'])->pluck('value')->toArray();
        $ouSearch = array_unique(Parameter::get('Abastecimiento',['supply_ou_id', 'purchaser_ou_id']));
        if (!in_array(auth()->user()->organizational_unit_id, $ouSearch) && !auth()->user()->can('Request Forms: purchaser')) {
            session()->flash('danger', 'Estimado Usuario/a: Usted no pertenece a la Unidad de Abastecimiento o no tiene los permisos de acceso.');
            return redirect()->route('request_forms.my_forms');
        }
        
        $requestForm->load('itemRequestForms.budgetItem', 'itemRequestForms.product', 'user', 'userOrganizationalUnit', 'contractManager', 'requestFormFiles', 'purchasingProcess.details', 'purchasingProcess.detailsPassenger', 'eventRequestForms.signerOrganizationalUnit', 'eventRequestForms.signerUser', 'purchaseMechanism', 'purchaseType', 'children', 'father.requestFormFiles');
        // return $requestForm;
        $isBudgetEventSignPending = $requestForm->eventRequestForms()->where('status', 'pending')->where('event_type', 'budget_event')->count() > 0;
        if ($isBudgetEventSignPending) session()->flash('warning', 'Estimado/a usuario/a: El formulario de requerimiento tiene una firma pendiente de aprobación por concepto de presupuesto, por lo que no podrá agregar o quitar compras hasta que no se haya notificado de la resolución de la firma.');
        $suppliers = Supplier::orderBy('name', 'asc')->get();

        return view('request_form.purchase.purchase', compact('requestForm', 'suppliers', 'isBudgetEventSignPending'));
    }

    public function edit(RequestForm $requestForm, PurchasingProcessDetail $purchasingProcessDetail)
    {
        // $ouSearch = Parameter::where('module', 'ou')->whereIn('parameter', ['AbastecimientoSSI', 'AbastecimientoHAH', 'AdquisicionesHAH'])->pluck('value')->toArray();
        $ouSearch = array_unique(Parameter::get('Abastecimiento',['supply_ou_id', 'purchaser_ou_id']));
        if (!in_array(auth()->user()->organizational_unit_id, $ouSearch) && !auth()->user()->can('Request Forms: purchaser')) {
            session()->flash('danger', 'Estimado Usuario/a: Usted no pertenece a la Unidad de Abastecimiento o no tiene los permisos de acceso.');
            return redirect()->route('request_forms.my_forms');
        }
        $result = $purchasingProcessDetail->getPurchasingType();
        $result->load('attachedFiles');
        // return $result;
        $result_details = PurchasingProcessDetail::where($purchasingProcessDetail->getPurchasingTypeColumn(), $result->id)->get();
        // return $result_details;
        $requestForm->load('user', 'userOrganizationalUnit', 'contractManager', 'requestFormFiles', 'purchasingProcess.details', 'purchasingProcess.detailsPassenger', 'eventRequestForms.signerOrganizationalUnit', 'eventRequestForms.signerUser', 'purchaseMechanism', 'purchaseType', 'children', 'father.requestFormFiles');
        $requestForm->purchase_type_id = $result->purchase_type_id;
        $isBudgetEventSignPending = $requestForm->eventRequestForms()->where('status', 'pending')->where('event_type', 'budget_event')->count() > 0;
        if ($isBudgetEventSignPending) session()->flash('warning', 'Estimado/a usuario/a: El formulario de requerimiento tiene una firma pendiente de aprobación por concepto de presupuesto, por lo que no podrá agregar o quitar compras hasta que no se haya notificado de la resolución de la firma.');
        $suppliers = Supplier::orderBy('name', 'asc')->get();

        return view('request_form.purchase.purchase', compact('requestForm', 'suppliers', 'isBudgetEventSignPending', 'result', 'result_details'));
    }

    // public function show(RequestForm $requestForm)
    // {
    //     $requestForm->load('user', 'userOrganizationalUnit', 'contractManager', 'requestFormFiles', 'purchasingProcess.details', 'purchasingProcess.detailsPassenger', 'eventRequestForms.signerOrganizationalUnit', 'eventRequestForms.signerUser', 'purchaseMechanism', 'purchaseType', 'children', 'father.requestFormFiles');
    //     // return $requestForm;
    //     return view('request_form.purchase.show', compact('requestForm'));
    // }

    public function create(RequestForm $requestForm)
    {
        $purchasingProcess = new PurchasingProcess();

        $purchasingProcess->purchase_mechanism_id = $requestForm->purchase_mechanism_id;
        $purchasingProcess->purchase_type_id      = $requestForm->purchase_type_id;
        $purchasingProcess->start_date            = Carbon::now();
        $purchasingProcess->status                = 'in_process';
        $purchasingProcess->user_id               = auth()->id();
        $purchasingProcess->request_form_id       = $requestForm->id;
        $purchasingProcess->save();
        return $purchasingProcess;
    }

    public function close_purchasing_process(RequestForm $requestForm, Request $request)
    {
        $requestForm->load('purchasingProcess');
        if (!$requestForm->purchasingProcess) $requestForm->purchasingProcess = $this->create($requestForm);
        $requestForm->purchasingProcess()->update([
            'status' => $request->status == 'finished' ? (Str::contains($requestForm->subtype, 'tiempo') ? 'finalized' : 'purchased') : 'canceled',
            'observation' => $request->observation
        ]);

        session()->flash('success', 'Cierre de proceso de compra registrado exitosamente');
        return redirect()->route('request_forms.supply.purchase', compact('requestForm'));
    }

    public function reasign_purchaser(RequestForm $requestForm, Request $request)
    {
        if($request->new_purchaser_user_id != null){
            $requestForm->purchasers()->detach();
            $requestForm->purchasers()->attach($request->new_purchaser_user_id);
            session()->flash('success', 'Nuevo Comprador asignado exitosamente.');
        }

        if($request->new_request_user_id != null){
            $requestForm->update(['request_user_id' => $request->new_request_user_id, 'request_user_ou_id' => User::findOrFail($request->new_request_user_id)->organizational_unit_id]);
            session()->flash('success', 'Nuevo Usuario Gestor asignado exitosamente.');
        }

        return redirect()->route('request_forms.all_forms');   
    }

    public function edit_observation(RequestForm $requestForm, Request $request)
    {
        $requestForm->purchasingProcess()->update(['observation' => $request->observation]);
        session()->flash('success', 'La observación al proceso de compra ha sido registrado exitosamente');
        return redirect()->route('request_forms.supply.purchase', compact('requestForm'));
    }

    public function estimated_expense_exceeded(RequestForm $requestForm)
    {
        //total del monto por items seleccionados + item registrados no debe sobrepasar el total del presupuesto asignado al formulario de requerimiento
        $totalItemPurchased = 0;
        if ($requestForm->purchasingProcess && ($requestForm->purchasingProcess->details || $requestForm->purchasingProcess->detailsPassenger)) $totalItemPurchased = $requestForm->purchasingProcess->getExpense();

        $totalItemSelected = 0;
        foreach ((request()->has('item_id') ? request()->item_id : request()->passenger_id) as $key => $item)
            $totalItemSelected += request()->item_total[$key];

        return $totalItemPurchased + $totalItemSelected > $requestForm->estimated_expense;
    }

    public function create_internal_oc(Request $request, RequestForm $requestForm)
    {
        $requestForm->load('purchasingProcess.details', 'purchasingProcess.detailsPassenger');
        if ($this->estimated_expense_exceeded($requestForm)) {
            session()->flash('danger', 'Estimado Usuario/a: El monto total por los items que está seleccionando más los ya registrados sobrepasa el monto total del presupuesto.');
            return redirect()->back()->withInput();
        }

        if (!$requestForm->purchasingProcess) $requestForm->purchasingProcess = $this->create($requestForm);

        $internalPurchaseOrder                          = new InternalPurchaseOrder();
        $internalPurchaseOrder->date                    = Carbon::now();
        $internalPurchaseOrder->supplier_id             = $request->supplier_id;
        $internalPurchaseOrder->payment_condition       = $request->payment_condition;
        $internalPurchaseOrder->estimated_delivery_date = $request->estimated_delivery_date;
        $internalPurchaseOrder->save();

        $items = $request->has('item_id') ? $request->item_id : $request->passenger_id;
        foreach ($items as $key => $item) {
            $detail = new PurchasingProcessDetail();
            $detail->purchasing_process_id      = $requestForm->purchasingProcess->id;
            if($request->has('item_id')){
                $detail->item_request_form_id       = $item;
                $detail->supplier_run               = $request->supplier_run[$key];
                $detail->supplier_name              = $request->supplier_name[$key];
                $detail->supplier_specifications    = $request->supplier_specifications[$key];
            }else{ // passengers
                $detail->passenger_request_form_id  = $item;
            }
            $detail->internal_purchase_order_id = $internalPurchaseOrder->id;
            $detail->user_id                    = auth()->id();
            $detail->quantity                   = $request->quantity[$key];
            $detail->unit_value                 = $request->unit_value[$key];
            $detail->tax                        = $request->tax[$key];
            $detail->expense                    = $request->item_total[$key];
            $detail->charges                    = $request->charges[$key];
            $detail->discounts                  = $request->discounts[$key];
            $detail->status                     = 'total';
            $detail->save();
        }

        $requestForm->load('purchasingProcess.details', 'purchasingProcess.detailsPassenger');
        if (round($requestForm->estimated_expense - $requestForm->purchasingProcess->getExpense()) == 0) { //Saldo total utilizado
            $requestForm->purchasingProcess()->update(['status' => Str::contains($requestForm->subtype, 'tiempo') ? 'finalized' : 'purchased']);
        }

        session()->flash('success', 'La Orden de compra interna ha sido registrado exitosamente');
        return redirect()->route('request_forms.supply.purchase', compact('requestForm'));
    }

    public function create_petty_cash(Request $request, RequestForm $requestForm)
    {
        $requestForm->load('purchasingProcess.details', 'purchasingProcess.detailsPassenger');
        if ($this->estimated_expense_exceeded($requestForm)) {
            session()->flash('danger', 'Estimado Usuario/a: El monto total por los items que está seleccionando más los ya registrados sobrepasa el monto total del presupuesto.');
            return redirect()->back()->withInput();
        }

        if (!$requestForm->purchasingProcess) $requestForm->purchasingProcess = $this->create($requestForm);

        $pettyCash                          = new PettyCash();
        $pettyCash->date                    = $request->date;
        $pettyCash->receipt_type            = $request->receipt_type;
        $pettyCash->receipt_number          = $request->receipt_number;
        $pettyCash->amount                  = $request->amount;
        $pettyCash->save();

        $now = Carbon::now()->format('Y_m_d_H_i_s');
        $file_name = $now . '_petty_cash_file_' . $pettyCash->id;
        $pettyCash->file = $request->file ? $request->file->storeAs('/ionline/request_forms/purchase_item_files', $file_name . '.' . $request->file->extension(), 'gcs') : null;
        $pettyCash->save();

        $items = $request->has('item_id') ? $request->item_id : $request->passenger_id;
        foreach ($items as $key => $item) {
            $detail = new PurchasingProcessDetail();
            $detail->purchasing_process_id      = $requestForm->purchasingProcess->id;
            if($request->has('item_id')){
                $detail->item_request_form_id       = $item;
                $detail->supplier_run               = $request->supplier_run[$key];
                $detail->supplier_name              = $request->supplier_name[$key];
                $detail->supplier_specifications    = $request->supplier_specifications[$key];
            }else{ // passengers
                $detail->passenger_request_form_id  = $item;
            } 
            $detail->petty_cash_id              = $pettyCash->id;
            $detail->user_id                    = auth()->id();
            $detail->quantity                   = $request->quantity[$key];
            $detail->unit_value                 = $request->unit_value[$key];
            $detail->tax                        = $request->tax[$key];
            $detail->expense                    = $request->item_total[$key];
            $detail->charges                    = $request->charges[$key];
            $detail->discounts                  = $request->discounts[$key];
            $detail->status                     = 'total';
            $detail->save();
        }

        $requestForm->load('purchasingProcess.details', 'purchasingProcess.detailsPassenger');
        if (round($requestForm->estimated_expense - $requestForm->purchasingProcess->getExpense()) == 0) { //Saldo total utilizado
            $requestForm->purchasingProcess()->update(['status' => Str::contains($requestForm->subtype, 'tiempo') ? 'finalized' : 'purchased']);
        }

        session()->flash('success', 'El fondo menor (caja chica) ha registrado creado exitosamente');
        return redirect()->route('request_forms.supply.purchase', compact('requestForm'));
    }

    public function create_fund_to_be_settled(Request $request, RequestForm $requestForm)
    {
        $requestForm->load('purchasingProcess.details', 'purchasingProcess.detailsPassenger');
        if ($this->estimated_expense_exceeded($requestForm)) {
            session()->flash('danger', 'Estimado Usuario/a: El monto total por los items que está seleccionando más los ya registrados sobrepasa el monto total del presupuesto.');
            return redirect()->back()->withInput();
        }

        if (!$requestForm->purchasingProcess) $requestForm->purchasingProcess = $this->create($requestForm);

        $fundToBeSettled                          = new FundToBeSettled();
        $fundToBeSettled->date                    = Carbon::now();
        $fundToBeSettled->amount                  = $request->amount;
        $fundToBeSettled->document_id             = $request->document_id;
        $fundToBeSettled->save();

        $items = $request->has('item_id') ? $request->item_id : $request->passenger_id;
        foreach ($items as $key => $item) {
            $detail = new PurchasingProcessDetail();
            $detail->purchasing_process_id      = $requestForm->purchasingProcess->id;
            if($request->has('item_id')){
                $detail->item_request_form_id       = $item;
                $detail->supplier_run               = $request->supplier_run[$key];
                $detail->supplier_name              = $request->supplier_name[$key];
                $detail->supplier_specifications    = $request->supplier_specifications[$key];
            }else{ // passengers
                $detail->passenger_request_form_id  = $item;
            }
            $detail->fund_to_be_settled_id      = $fundToBeSettled->id;
            $detail->user_id                    = auth()->id();
            $detail->quantity                   = $request->quantity[$key];
            $detail->unit_value                 = $request->unit_value[$key];
            $detail->tax                        = $request->tax[$key];
            $detail->expense                    = $request->item_total[$key];
            $detail->charges                    = $request->charges[$key];
            $detail->discounts                  = $request->discounts[$key];
            $detail->status                     = 'total';
            $detail->save();
        }

        $requestForm->load('purchasingProcess.details', 'purchasingProcess.detailsPassenger');
        if (round($requestForm->estimated_expense - $requestForm->purchasingProcess->getExpense()) == 0) { //Saldo total utilizado
            $requestForm->purchasingProcess()->update(['status' => Str::contains($requestForm->subtype, 'tiempo') ? 'finalized' : 'purchased']);
        }

        session()->flash('success', 'El fondo a rendir ha sido registrado exitosamente');
        return redirect()->route('request_forms.supply.purchase', compact('requestForm'));
    }

    public function create_tender(Request $request, RequestForm $requestForm)
    {
        $requestForm->load('purchasingProcess.details', 'purchasingProcess.detailsPassenger');
        if ($this->estimated_expense_exceeded($requestForm)) {
            session()->flash('danger', 'Estimado Usuario/a: El monto total por los items que está seleccionando más los ya registrados sobrepasa el monto total del presupuesto.');
            return redirect()->back()->withInput();
        }

        if (!$requestForm->purchasingProcess) $requestForm->purchasingProcess = $this->create($requestForm);

        $tender = new Tender($request->all());
        $tender->is_lower_amount = $request->has('is_lower_amount');
        $tender->has_taking_of_reason = $request->has('has_taking_of_reason');
        $tender->save();

        $items = $request->has('item_id') ? $request->item_id : $request->passenger_id;
        foreach ($items as $key => $item) {
            $detail = new PurchasingProcessDetail();
            $detail->purchasing_process_id      = $requestForm->purchasingProcess->id;
            if($request->has('item_id')){
                $detail->item_request_form_id       = $item;
                $detail->supplier_run               = $request->supplier_run[$key];
                $detail->supplier_name              = $request->supplier_name[$key];
                $detail->supplier_specifications    = $request->supplier_specifications[$key];
            }else{ // passengers
                $detail->passenger_request_form_id  = $item;
            }
            $detail->tender_id                  = $tender->id;
            $detail->user_id                    = auth()->id();
            $detail->quantity                   = $request->quantity[$key];
            $detail->unit_value                 = $request->unit_value[$key];
            $detail->tax                        = $request->tax[$key];
            $detail->expense                    = $request->item_total[$key];
            $detail->charges                    = $request->charges[$key];
            $detail->discounts                  = $request->discounts[$key];
            $detail->status                     = 'total';
            $detail->save();
        }

        //Registrar oc de la licitacion como compra inmediata
        if (!$requestForm->father && Str::contains($requestForm->subtype, 'inmediata') && $request->status == 'adjudicada') {
            $oc = new ImmediatePurchase($request->all());
            $oc->request_form_id = $requestForm->id;
            $oc->description = $request->po_description;
            $oc->supplier_specifications = null; // Las especificaciones tecnicas del proveedor son propias del item y no de la OC
            $tender->oc()->save($oc);
        }


        //Registrar archivos en attached_files
        $now = Carbon::now()->format('Y_m_d_H_i_s');
        $files = [
            'resol_administrative_bases_file' => 'Resolución bases administrativas',
            'resol_adjudication_deserted_file' => 'Resolución de adjudicación/desierta',
            'resol_contract_file' => 'Resolución de contrato',
            'guarantee_ticket_file' => 'Boleta de garantía',
            'memo_file' => 'Oficio',
            'oc_file' => 'Orden de compra'
        ];

        foreach ($files as $key => $file) {
            if ($request->hasFile($key)) {
                $archivo = $request->file($key);
                $file_name = $now . '_' . $key . '_' . $tender->id;
                $attachedFile = new AttachedFile();
                $attachedFile->file = $archivo->storeAs('/ionline/request_forms/attached_files', $file_name . '.' . $archivo->extension(), 'gcs');
                $attachedFile->document_type = $file;
                $attachedFile->tender_id = $tender->id;
                $attachedFile->save();
            }
        }

        $requestForm->load('purchasingProcess.details', 'purchasingProcess.detailsPassenger');
        if (round($requestForm->estimated_expense - $requestForm->purchasingProcess->getExpense()) == 0) { //Saldo total utilizado
            $requestForm->purchasingProcess()->update(['status' => Str::contains($requestForm->subtype, 'tiempo') ? 'finalized' : 'purchased']);
        }

        session()->flash('success', 'La Licitación ha sido registrado exitosamente');
        return redirect()->route('request_forms.supply.purchase', compact('requestForm'));
    }

    public function create_oc(Request $request, RequestForm $requestForm)
    {
        $requestForm->load('purchasingProcess.details', 'purchasingProcess.detailsPassenger');
        if ($this->estimated_expense_exceeded($requestForm)) {
            session()->flash('danger', 'Estimado Usuario/a: El monto total por los items que está seleccionando más los ya registrados sobrepasa el monto total del presupuesto.');
            return redirect()->back()->withInput();
        }

        if (!$requestForm->purchasingProcess) $requestForm->purchasingProcess = $this->create($requestForm);

        $oc = new ImmediatePurchase($request->all());
        // $oc->po_id = $request->po_id;
        $oc->request_form_id = $requestForm->id;
        $oc->description = $request->po_description;
        $oc->supplier_specifications = null; // Las especificaciones tecnicas del proveedor son propias del item y no de la OC
        $oc->save();

        $items = $request->has('item_id') ? $request->item_id : $request->passenger_id;
        foreach ($items as $key => $item) {
            $detail = new PurchasingProcessDetail();
            $detail->purchasing_process_id      = $requestForm->purchasingProcess->id;
            if($request->has('item_id')){
                $detail->item_request_form_id       = $item;
                $detail->supplier_run               = $request->supplier_run[$key];
                $detail->supplier_name              = $request->supplier_name[$key];
                $detail->supplier_specifications    = $request->supplier_specifications[$key];
            }else{ // passengers
                $detail->passenger_request_form_id  = $item;
            }
            $detail->immediate_purchase_id      = $oc->id;
            $detail->user_id                    = auth()->id();
            $detail->quantity                   = $request->quantity[$key];
            $detail->unit_value                 = $request->unit_value[$key];
            $detail->tax                        = $request->tax[$key];
            $detail->expense                    = $request->item_total[$key];
            $detail->charges                    = $request->charges[$key];
            $detail->discounts                  = $request->discounts[$key];
            $detail->status                     = 'total';
            $detail->save();
        }

        $now = Carbon::now()->format('Y_m_d_H_i_s');
        $files = [
            'oc_file' => 'Orden de compra',
            'mail_file' => 'Correo de respaldo'
        ];

        foreach ($files as $key => $file) {
            if ($request->hasFile($key)) {
                $archivo = $request->file($key);
                $file_name = $now . '_' . $key . '_' . $oc->id;
                $attachedFile = new AttachedFile();
                $attachedFile->file = $archivo->storeAs('/ionline/request_forms/attached_files', $file_name . '.' . $archivo->extension(), 'gcs');
                $attachedFile->document_type = $file;
                $attachedFile->immediate_purchase_id = $oc->id;
                $attachedFile->save();
            }
        }

        $requestForm->load('purchasingProcess.details', 'purchasingProcess.detailsPassenger');
        if (round($requestForm->estimated_expense - $requestForm->purchasingProcess->getExpense()) == 0) { //Saldo total utilizado
            $requestForm->purchasingProcess()->update(['status' => Str::contains($requestForm->subtype, 'tiempo') ? 'finalized' : 'purchased']);
        }

        session()->flash('success', 'La Orden de compra ha sido registrado exitosamente');
        return redirect()->route('request_forms.supply.purchase', compact('requestForm'));
    }

    public function create_convenio_marco(Request $request, RequestForm $requestForm)
    {
        $requestForm->load('purchasingProcess.details', 'purchasingProcess.detailsPassenger');
        if ($this->estimated_expense_exceeded($requestForm)) {
            session()->flash('danger', 'Estimado Usuario/a: El monto total por los items que está seleccionando más los ya registrados sobrepasa el monto total del presupuesto.');
            return redirect()->back()->withInput();
        }

        if (!$requestForm->purchasingProcess) $requestForm->purchasingProcess = $this->create($requestForm);

        $cm = new ImmediatePurchase($request->all());
        $cm->request_form_id = $requestForm->id;
        $cm->save();

        $items = $request->has('item_id') ? $request->item_id : $request->passenger_id;
        foreach ($items as $key => $item) {
            $detail = new PurchasingProcessDetail();
            $detail->purchasing_process_id      = $requestForm->purchasingProcess->id;
            if($request->has('item_id')){
                $detail->item_request_form_id       = $item;
                $detail->supplier_run               = $request->supplier_run[$key];
                $detail->supplier_name              = $request->supplier_name[$key];
                $detail->supplier_specifications    = $request->supplier_specifications[$key];
            }else{ // passengers
                $detail->passenger_request_form_id  = $item;
            }
            $detail->immediate_purchase_id      = $cm->id;
            $detail->user_id                    = auth()->id();
            $detail->quantity                   = $request->quantity[$key];
            $detail->unit_value                 = $request->unit_value[$key];
            $detail->tax                        = $request->tax[$key];
            $detail->expense                    = $request->item_total[$key];
            $detail->charges                    = $request->charges[$key];
            $detail->discounts                  = $request->discounts[$key];
            $detail->status                     = 'total';
            $detail->save();
        }

        //Registrar archivos en attached_files
        $now = Carbon::now()->format('Y_m_d_H_i_s');
        $files = [
            'oc_file' => 'Orden de compra',
            'resol_supplementary_agree_file' => 'Resolución de acuerdo complementario',
            'resol_awarding_file' => 'Resolución de adjudicación',
            'resol_purchase_intention' => 'Resolución de intención de compra'
        ];

        foreach ($files as $key => $file) {
            if ($request->hasFile($key)) {
                $archivo = $request->file($key);
                $file_name = $now . '_' . $key . '_' . $cm->id;
                $attachedFile = new AttachedFile();
                $attachedFile->file = $archivo->storeAs('/ionline/request_forms/attached_files', $file_name . '.' . $archivo->extension(), 'gcs');
                $attachedFile->document_type = $file;
                $attachedFile->immediate_purchase_id = $cm->id;
                $attachedFile->save();
            }
        }

        $requestForm->load('purchasingProcess.details', 'purchasingProcess.detailsPassenger');
        if (round($requestForm->estimated_expense - $requestForm->purchasingProcess->getExpense()) == 0) { //Saldo total utilizado
            $requestForm->purchasingProcess()->update(['status' => Str::contains($requestForm->subtype, 'tiempo') ? 'finalized' : 'purchased']);
        }

        session()->flash('success', 'Convenio marco ha sido registrado exitosamente');
        return redirect()->route('request_forms.supply.purchase', compact('requestForm'));
    }

    public function create_direct_deal(Request $request, RequestForm $requestForm)
    {
        $requestForm->load('purchasingProcess.details', 'purchasingProcess.detailsPassenger');
        if ($this->estimated_expense_exceeded($requestForm)) {
            session()->flash('danger', 'Estimado Usuario/a: El monto total por los items que está seleccionando más los ya registrados sobrepasa el monto total del presupuesto.');
            return redirect()->back()->withInput();
        }
        if (!$requestForm->purchasingProcess) $requestForm->purchasingProcess = $this->create($requestForm);

        $directdeal = new DirectDeal($request->all());
        $directdeal->is_lower_amount = $request->has('is_lower_amount');
        $directdeal->save();

        $items = $request->has('item_id') ? $request->item_id : $request->passenger_id;
        foreach ($items as $key => $item) {
            $detail = new PurchasingProcessDetail();
            $detail->purchasing_process_id      = $requestForm->purchasingProcess->id;
            if($request->has('item_id')){
                $detail->item_request_form_id       = $item;
                $detail->supplier_run               = $request->supplier_run[$key];
                $detail->supplier_name              = $request->supplier_name[$key];
                $detail->supplier_specifications    = $request->supplier_specifications[$key];
            }else{ // passengers
                $detail->passenger_request_form_id  = $item;
            }
            $detail->direct_deal_id             = $directdeal->id;
            $detail->user_id                    = auth()->id();
            $detail->quantity                   = $request->quantity[$key];
            $detail->unit_value                 = $request->unit_value[$key];
            $detail->tax                        = $request->tax[$key];
            $detail->expense                    = $request->item_total[$key];
            $detail->charges                    = $request->charges[$key];
            $detail->discounts                  = $request->discounts[$key];
            $detail->status                     = 'total';
            $detail->save();
        }

        //Registrar oc del trato directo como compra inmediata
        if (!$requestForm->father && Str::contains($requestForm->subtype, 'inmediata')) {
            $oc = new ImmediatePurchase($request->all());
            $oc->request_form_id = $requestForm->id;
            $oc->description = $request->po_description;
            $oc->supplier_specifications = null; // Las especificaciones tecnicas del proveedor son propias del item y no de la OC
            $directdeal->oc()->save($oc);
        }

        //Registrar archivos en attached_files
        $now = Carbon::now()->format('Y_m_d_H_i_s');
        $files = [
            'resol_direct_deal_file' => 'Resolución de trato directo',
            'resol_contract_file' => 'Resolución de contrato',
            'guarantee_ticket_file' => 'Boleta de garantía',
            'oc_file' => 'Orden de compra'
        ];

        foreach ($files as $key => $file) {
            if ($request->hasFile($key)) {
                $archivo = $request->file($key);
                $file_name = $now . '_' . $key . '_' . $directdeal->id;
                $attachedFile = new AttachedFile();
                $attachedFile->file = $archivo->storeAs('/ionline/request_forms/attached_files', $file_name . '.' . $archivo->extension(), 'gcs');
                $attachedFile->document_type = $file;
                $attachedFile->direct_deal_id = $directdeal->id;
                $attachedFile->save();
            }
        }

        $requestForm->load('purchasingProcess.details', 'purchasingProcess.detailsPassenger');
        if (round($requestForm->estimated_expense - $requestForm->purchasingProcess->getExpense()) == 0) { //Saldo total utilizado
            $requestForm->purchasingProcess()->update(['status' => Str::contains($requestForm->subtype, 'tiempo') ? 'finalized' : 'purchased']);
        }

        session()->flash('success', 'El trato directo ha sido registrado exitosamente');
        return redirect()->route('request_forms.supply.purchase', compact('requestForm'));
    }

    public function update_direct_deal(Request $request, RequestForm $requestForm, DirectDeal $directDeal)
    {
        $directDeal->update($request->all());

        //Registrar archivos en attached_files
        $now = Carbon::now()->format('Y_m_d_H_i_s');
        $files = [
            'resol_direct_deal_file' => 'Resolución de trato directo',
            'resol_contract_file' => 'Resolución de contrato',
            'guarantee_ticket_file' => 'Boleta de garantía'
        ];

        foreach ($files as $key => $file) {
            if ($request->hasFile($key)) {
                $previousFile = $directDeal->findAttachedFile($key);
                if ($previousFile) {
                    $previousFile->delete();
                    Storage::disk('gcs')->delete($previousFile->file);
                }
                $archivo = $request->file($key);
                $file_name = $now . '_' . $key . '_' . $directDeal->id;
                $attachedFile = new AttachedFile();
                $attachedFile->file = $archivo->storeAs('/ionline/request_forms/attached_files', $file_name . '.' . $archivo->extension(), 'gcs');
                $attachedFile->document_type = $file;
                $attachedFile->direct_deal_id = $directDeal->id;
                $attachedFile->save();
            }
        }

        session()->flash('success', 'El trato directo ha sido modificado exitosamente');
        return redirect()->route('request_forms.supply.purchase', compact('requestForm'));
    }

    public function release_item(PurchasingProcessDetail $detail, Request $request)
    {
        $detail->update(['status' => 'desert', 'release_observation' => $request->release_observation]);
        PurchasingProcess::find($detail->purchasing_process_id)->update(['status' => 'in_process']);
        session()->flash('success', 'El item ha sido anulado exitosamente');
        return redirect()->back();
    }
}
