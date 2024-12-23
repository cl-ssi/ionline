<?php

namespace App\Http\Controllers\RequestForms;

use App\Exports\RequestForms\RequestFormsExport;
use App\Models\RequestForms\RequestForm;
use App\Models\RequestForms\Item;
use App\RequestForms\Passage;
use App\RequestForms\RequestFormEvent;
use App\RequestForms\RequestFormItemCode;
use App\Models\Rrhh\OrganizationalUnit;
use App\Models\Rrhh\Authority;
use App\Http\Controllers\Controller;
use App\Mail\NewRequestFormNotification;
use App\Models\Documents\SignaturesFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Mail\RequestFormSignNotification;
use App\Models\RequestForms\EventRequestForm;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\File;
use PDF;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\User;
use App\Mail\PurchaserNotification;
use App\Mail\RfEndNewBudgetSignNotification;
use App\Models\Parameters\Parameter;
use App\Models\PurchasePlan\PurchasePlan;
use App\Models\RequestForms\ItemChangedRequestForm;
use App\Models\RequestForms\ItemRequestForm;
use App\Models\RequestForms\OldSignatureFile;
use App\Models\RequestForms\Passenger;
use App\Models\RequestForms\PassengerChanged;
use App\Models\RequestForms\RequestFormFile;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Maatwebsite\Excel\Facades\Excel;

class RequestFormController extends Controller {

    public function my_forms() 
    {
        $my_pending_requests = RequestForm::with('user', 'userOrganizationalUnit', 'purchaseMechanism', 'eventRequestForms.signerOrganizationalUnit', 'father:id,folio,has_increased_expense', 'signedOldRequestForms')
            ->where('request_user_id', auth()->id())
            ->where(function ($q){
                $q->where('status', 'pending')
                ->OrWhere('status', 'saved');
            })
            ->latest('id')
            ->get();

        $my_requests = RequestForm::with('user', 'userOrganizationalUnit', 'purchaseMechanism', 'eventRequestForms.signerOrganizationalUnit', 'father:id,folio,has_increased_expense', 'signedOldRequestForms', 'purchasers')
            ->where('request_user_id', auth()->id())
            ->whereIn('status', ['approved', 'rejected'])
            ->latest('id')
            ->paginate(30, ['*'], 'p1');

        $my_ou = RequestForm::with('user', 'userOrganizationalUnit', 'purchaseMechanism', 'eventRequestForms.signerOrganizationalUnit', 'father:id,folio,has_increased_expense', 'signedOldRequestForms', 'purchasers')
            ->where('request_user_ou_id', auth()->user()->OrganizationalUnit->id)
            ->latest('id')
            ->paginate(30, ['*'], 'p2');

        return view('request_form.my_forms', compact('my_requests', 'my_pending_requests','my_ou'));
    }

    public function own_index()
    {
        // $ouSearch = Parameter::where('module', 'ou')->whereIn('parameter', ['FinanzasSSI', 'RefrendacionHAH', 'FinanzasHAH'])->pluck('value')->toArray();
        /*
        $ouSearch = array_unique(Parameter::get('Abastecimiento',['prefinance_ou_id','finance_ou_id']));
        if(!auth()->user()->hasPermissionTo('Request Forms: all') && !in_array(auth()->user()->organizational_unit_id, $ouSearch)){
            session()->flash('danger', 'Estimado Usuario/a: no tiene los permisos necesarios para ver todos los formularios.');
            return redirect()->route('request_forms.my_forms');
        }
        */

        return view('request_form.own_index');
    }

    public function all_forms()
    {
        // $ouSearch = Parameter::where('module', 'ou')->whereIn('parameter', ['FinanzasSSI', 'RefrendacionHAH', 'FinanzasHAH'])->pluck('value')->toArray();
        $ouSearch = array_unique(Parameter::get('Abastecimiento',['prefinance_ou_id','finance_ou_id']));
        if(!auth()->user()->hasPermissionTo('Request Forms: all') && !in_array(auth()->user()->organizational_unit_id, $ouSearch)){
            session()->flash('danger', 'Estimado Usuario/a: no tiene los permisos necesarios para ver todos los formularios.');
            return redirect()->route('request_forms.my_forms');
        }

        return view('request_form.all_forms');
    }

    public function get_events_type_user()
    {
        $events_type = [];

        $authorities = Authority::getAmIAuthorityFromOu(now(), 'manager', Auth::id());

        if($authorities->isNotEmpty()){
          foreach ($authorities as $authority){
              $iam_authorities_in[] = $authority->organizational_unit_id;
          }

          //superchief?
          $result = RequestForm::whereHas('eventRequestForms', function($q) use ($iam_authorities_in){
              return $q->whereIn('ou_signer_user', $iam_authorities_in)->where('event_type', 'superior_leader_ship_event');
          })->count();

          if($result > 0) $events_type[] = 'superior_leader_ship_event';
          $events_type[] = 'leader_ship_event';

        //   $ouSearch = Parameter::where('module', 'ou')->whereIn('parameter', ['FinanzasSSI', 'FinanzasHAH'])->pluck('value')->toArray();
          $ouSearch = array_unique(Parameter::get('Abastecimiento',['finance_ou_id']));
          foreach($ouSearch as $ou_id)
          if(in_array($ou_id, $iam_authorities_in)){
              $events_type[] = 'finance_event';
              break;
            }
            
        //   $ouSearch = Parameter::where('module', 'ou')->whereIn('parameter', ['AbastecimientoSSI', 'AbastecimientoHAH'])->pluck('value')->toArray();
            $ouSearch = array_unique(Parameter::get('Abastecimiento',['supply_ou_id']));
          foreach($ouSearch as $ou_id)
            if(in_array($ou_id, $iam_authorities_in)){
                $events_type[] = 'supply_event';
                break;
            }

        //   $ouSearch = Parameter::where('module', 'ou')->where('parameter', ['RefrendacionHAH'])->first()->value;
          $ouSearch = array_unique(Parameter::get('Abastecimiento',['prefinance_ou_id'], Parameter::get('establishment', ['HospitalAltoHospicio', 'HETG'])));
          if(in_array(auth()->user()->organizational_unit_id, $ouSearch)) $events_type[] = 'pre_finance_event';
        }
        else {
            /* FIX: @mirandaljorge si no hay manager en Authority, se va a caer*/
          $manager = Authority::getAuthorityFromDate(auth()->user()->organizationalUnit->id, now(), 'manager');
        //   $ouSearch = Parameter::where('module', 'ou')->whereIn('parameter', ['FinanzasSSI', 'RefrendacionHAH'])->pluck('value')->toArray();
          $ouSearch = array_unique(Parameter::get('Abastecimiento',['prefinance_ou_id']));
          if(in_array(auth()->user()->organizational_unit_id, $ouSearch) && $manager->user_id != auth()->id()) $events_type[] = 'pre_finance_event';
        }
        $ouTechnicalReview = EventRequestForm::where('event_type', 'technical_review_event')
            ->where('ou_signer_user', auth()->user()->organizationalUnit->id)
            ->count();
        if($ouTechnicalReview > 0) $events_type[] = 'technical_review_event';

        return $events_type;
    }

    public function pending_forms()
    {
        $my_pending_forms_to_signs = $pending_forms_to_signs_manager = $not_pending_forms = $new_budget_pending_to_sign = $my_forms_signed = collect();

        $events_type = $this->get_events_type_user();
        // dd($events_type);
        $iam_authorities_in = $iam_secretaries_in = [];

        $authorities = Authority::getAmIAuthorityFromOu(now(), 'manager', Auth::id());
        $secretaries = Authority::getAmIAuthorityFromOu(now(), 'secretary', Auth::id());

        // if($authorities->isNotEmpty()){
          foreach ($authorities as $authority){
              $iam_authorities_in[] = $authority->organizational_unit_id;
          }

          foreach ($secretaries as $secretary){
              $iam_secretaries_in[] = $secretary->organizational_unit_id;
          }

          foreach($events_type as $event_type){
              $prev_event_type = $event_type == 'supply_event' ? 'finance_event' : ($event_type == 'finance_event' ? 'pre_finance_event' : ($event_type == 'pre_finance_event' ? ['superior_leader_ship_event', 'leader_ship_event', 'technical_review_event'] : ($event_type == 'superior_leader_ship_event' ? 'leader_ship_event' : ($event_type == 'leader_ship_event' ? 'technical_review_event' : null))));
            //   return $prev_event_type;
              $result = RequestForm::with('user', 'userOrganizationalUnit', 'purchaseMechanism', 'eventRequestForms.signerOrganizationalUnit')
                  ->where('status', 'pending')
                  ->whereHas('eventRequestForms', function($q) use ($event_type, $iam_authorities_in){
                      return $q->where('status', 'pending')->whereIn('ou_signer_user', (count($iam_authorities_in) > 0 ? $iam_authorities_in : [auth()->user()->organizationalUnit->id]))->where('event_type', $event_type);
                  })->when($prev_event_type, function($q) use ($prev_event_type) {
                      return $q->whereDoesntHave('eventRequestForms', function ($f) use ($prev_event_type) {
                          return is_array($prev_event_type) ? $f->whereIn('event_type', $prev_event_type)->where('status', 'pending') : $f->where('event_type', $prev_event_type)->where('status', 'pending');
                      });
                  })->get();
              $my_pending_forms_to_signs = $my_pending_forms_to_signs->concat($result);
          }
        // }

        // return $my_pending_forms_to_signs;

        if(count($secretaries) > 0){
          foreach(['superior_leader_ship_event', 'leader_ship_event'] as $event_type){
              $prev_event_type = $event_type == 'supply_event' ? 'finance_event' : ($event_type == 'finance_event' ? 'pre_finance_event' : ($event_type == 'pre_finance_event' ? ['superior_leader_ship_event', 'leader_ship_event'] : ($event_type == 'superior_leader_ship_event' ? 'leader_ship_event' : null)));
              // return $prev_event_type;
              $result = RequestForm::with('user', 'userOrganizationalUnit', 'purchaseMechanism', 'eventRequestForms.signerOrganizationalUnit')
                  ->where('status', 'pending')
                  ->whereHas('eventRequestForms', function($q) use ($event_type, $iam_secretaries_in){
                      return $q->where('status', 'pending')->whereIn('ou_signer_user', (count($iam_secretaries_in) > 0 ? $iam_secretaries_in : [auth()->user()->organizationalUnit->id]))->where('event_type', $event_type);
                  })->when($prev_event_type, function($q) use ($prev_event_type) {
                      return $q->whereDoesntHave('eventRequestForms', function ($f) use ($prev_event_type) {
                          return is_array($prev_event_type) ? $f->whereIn('event_type', $prev_event_type)->where('status', 'pending') : $f->where('event_type', $prev_event_type)->where('status', 'pending');
                      });
                  })->get();
              $pending_forms_to_signs_manager = $pending_forms_to_signs_manager->concat($result);
          }
          
        //   return $pending_forms_to_signs_manager;
        }

        foreach($events_type as $event_type){
            if(in_array($event_type, ['pre_finance_event', 'finance_event', 'supply_event'])){
                $prev_event_type = $event_type == 'finance_event' ? 'pre_finance_budget_event' : ($event_type == 'pre_finance_event' ? 'pre_budget_event' : null);
                $result = RequestForm::with('user', 'userOrganizationalUnit', 'purchaseMechanism', 'eventRequestForms.signerOrganizationalUnit')
                    ->where('status', 'approved')
                    ->whereHas('eventRequestForms', function($q) use ($event_type){
                        return $q->where('status', 'pending')->where('ou_signer_user', auth()->user()->organizationalUnit->id)->where('event_type', $event_type == 'finance_event' ? 'budget_event' : ($event_type == 'supply_event' ? 'pre_budget_event' : 'pre_finance_budget_event'));
                    })->when($prev_event_type, function($q) use ($prev_event_type) {
                        return $q->whereDoesntHave('eventRequestForms', function ($f) use ($prev_event_type) {
                            return $f->where('event_type', $prev_event_type)->where('status', 'pending');
                        });
                    })
                    ->get();
                $new_budget_pending_to_sign = $new_budget_pending_to_sign->concat($result);
            }
        }

        // return $new_budget_pending_to_sign;
        // $ouSearch = Parameter::where('module', 'ou')->whereIn('parameter', ['AbastecimientoSSI', 'AbastecimientoHAH'])->pluck('value')->toArray();
        $ouSearch = Parameter::get('Abastecimiento',['supply_ou_id']);
        foreach($events_type as $event_type){
            if(in_array($event_type, ['pre_finance_event', 'finance_event', 'supply_event']) || in_array(auth()->user()->organizationalUnit->id, $ouSearch)){
                $not_pending_forms = RequestForm::with('user', 'userOrganizationalUnit', 'purchaseMechanism', 'eventRequestForms.signerOrganizationalUnit')
                        ->whereNotIn('status', ['saved', 'pending'])->latest('id')->paginate(15, ['*'], 'p1');
            }
        }

        // return $not_pending_forms;

        $my_forms_signed = RequestForm::with('user', 'userOrganizationalUnit', 'purchaseMechanism', 'eventRequestForms.signerOrganizationalUnit')
            ->whereHas('eventRequestForms', $filter = function($q){
                return $q->where('signer_user_id', auth()->id())
                    ->orWhere('ou_signer_user', auth()->user()->organizationalUnit->id);
            })->latest('id')->paginate(15, ['*'], 'p2');
//            })->orderBy('approved_at', 'desc')->paginate(15, ['*'], 'p2');

        return view('request_form.pending_forms', compact('my_pending_forms_to_signs', 'pending_forms_to_signs_manager', 'secretaries', 'not_pending_forms', 'new_budget_pending_to_sign', 'my_forms_signed', 'events_type'));
    }

    public function contract_manager_forms() {

        $contract_manager_forms = RequestForm::with('user', 'userOrganizationalUnit', 'purchaseMechanism', 'eventRequestForms.signerOrganizationalUnit', 'father:id,folio,has_increased_expense')
            ->where('contract_manager_id', auth()->id())
            ->latest('id')
            ->paginate(30);

        return view('request_form.contract_manager_forms', compact('contract_manager_forms'));
    }

    public function contract_manager_index()
    {
        return view('request_form.contract_manager_index');
    }

    // public function edit(RequestForm $requestForm) {
    //     if($requestForm->request_user_id != auth()->user()->id){
    //       session()->flash('danger', 'Formulario de Requerimiento N° '.$requestForm->id.' NO pertenece a Usuario: '.auth()->user()->fullName);
    //       return redirect()->route('request_forms.my_forms');
    //     }
    //     if($requestForm->eventRequestForms->first()->status != 'pending'){
    //       session()->flash('danger', 'Formulario de Requerimiento N° '.$requestForm->id.' NO puede ser Modificado!');
    //       return redirect()->route('request_forms.my_forms');
    //     }
    //     //Obtiene la Autoridad de la Unidad Organizacional del usuario registrado, en la fecha actual.
    //     $manager = Authority::getAuthorityFromDate(auth()->user()->organizationalUnit->id, Carbon::now(), 'manager');
    //     if(is_null($manager))
    //         $manager= '<h6 class="text-danger">'.auth()->user()->organizationalUnit->name.', no registra una Autoridad.</h6>';
    //     else
    //         $manager = $manager->user->fullName;
    //     $requestForms = RequestForm::all();
    //     return view('request_form.edit', compact('requestForm', 'manager', 'requestForms'));
    // }

    public function edit(RequestForm $requestForm){
        // $requestForm=null;
        // $ouSearch = Parameter::where('module', 'ou')->whereIn('parameter', ['FinanzasSSI', 'RefrendacionHAH', 'FinanzasHAH'])->pluck('value')->toArray();
        $ouSearch = array_unique(Parameter::get('Abastecimiento', ['prefinance_ou_id', 'finance_ou_id']));
        if(!auth()->user()->hasPermissionTo('Request Forms: all') && !in_array(auth()->user()->organizational_unit_id, $ouSearch) && $requestForm->request_user_id != auth()->user()->id){
            session()->flash('danger', 'Estimado Usuario/a: no tiene los permisos necesarios para editar formulario N° '.$requestForm->folio);
            return redirect()->back();
        }

        if(!$requestForm->canEdit()){
            session()->flash('danger', 'Estimado Usuario/a: no se cumplen los criterios para editar formulario N° '.$requestForm->folio);
            return redirect()->back();
        }
        
        return  view('request_form.create', compact('requestForm'));
    }

    public function sign(RequestForm $requestForm, $eventType)
    {
        $eventTypeBudget = null;
        if(in_array($eventType, ['pre_budget_event', 'pre_finance_budget_event', 'budget_event'])){
            $manager = Authority::getAuthorityFromDate(auth()->user()->organizationalUnit->id, now(), 'manager');

            // if(auth()->user()->organizationalUnit->establishment_id == Parameter::where('module', 'establishment')->where('parameter', 'SSTarapaca')->first()->value){
            //     $ouSearch = Parameter::where('module', 'ou')->where('parameter', 'FinanzasSSI')->first()->value;
            // }

            // if(auth()->user()->organizationalUnit->establishment_id == Parameter::where('module', 'establishment')->where('parameter', 'HospitalAltoHospicio')->first()->value){
            //     $ouSearch = Parameter::where('module', 'ou')->where('parameter', 'FinanzasHAH')->first()->value;
            // }

            $ouSearch = Parameter::get('Abastecimiento', ['finance_ou_id']);

            $eventTypeBudget = $eventType == 'pre_budget_event' ? 'supply_event' : (in_array(auth()->user()->organizational_unit_id, $ouSearch) && $manager->user_id == auth()->id() ? 'finance_event' : 'pre_finance_event');
            // $eventTypeBudget = $eventType == 'pre_budget_event' ? 'supply_event' : (auth()->user()->organizational_unit_id == $ouSearch && $manager->user_id == auth()->id() ? 'finance_event' : 'pre_finance_event');
            // dd($eventTypeBudget);
            $requestForm->has_increased_expense = true;
            $requestForm->new_estimated_expense = $requestForm->estimated_expense + $requestForm->eventRequestForms()->where('status', 'pending')->where('event_type', 'budget_event')->first()->purchaser_amount;
            $requestForm->load('itemRequestForms.latestPendingItemChangedRequestForms', 'passengers.latestPendingPassengerChanged');
        }

        $eventTitles = [
            'superior_leader_ship_event'    => 'Dirección', 
            'leader_ship_event'             => 'Jefatura', 
            'pre_finance_event'             => 'Refrendación Presupuestaria', 
            'finance_event'                 => 'Finanzas', 
            'supply_event'                  => 'Abastecimiento', 
            'pre_budget_event'              => 'Nuevo presupuesto', 
            'pre_finance_budget_event'      => 'Nuevo presupuesto', 
            'budget_event'                  => 'Nuevo presupuesto',
            'technical_review_event'        => 'Revisión técnica'
        ];

        $events_type_user = $this->get_events_type_user();

        // return $events_type_user;
        $countEventsType = count($events_type_user);
        foreach($events_type_user as $event_type_user){
            if($event_type_user != $eventType && $event_type_user != $eventTypeBudget){
                $countEventsType--;
            }
        }

        if(!$countEventsType){
            session()->flash('danger', 'Estimado Usuario/a: Ud. no tiene los permisos para la autorización como '.$eventTitles[$eventType].'.');
            return redirect()->route('request_forms.my_forms');
        }

        $requestForm->load('itemRequestForms', 'user', 'userOrganizationalUnit', 'purchaseMechanism', 'eventRequestForms.signerOrganizationalUnit');
        $requestForm->load(['eventRequestForms' => fn($q) => $q->withTrashed()]);

        $title = 'Formularios de Requerimiento - Autorización ' . $eventTitles[$eventType];

        //$manager              = Authority::getAuthorityFromDate(auth()->user()->organizationalUnit->id, Carbon::now(), 'manager');

        // $position             = $manager->position;
        // $organizationalUnit   = $manager->organizationalUnit->name;
        // if(is_null($manager))
        //     $manager = 'No se ha registrado una Autoridad en el módulo correspondiente!';
        // else
        //     $manager = $manager->user->fullName;
        return view('request_form.sign', compact('requestForm', 'eventType', 'title'));
    }

    public function create_new_budget(Request $request, RequestForm $requestForm)
    {
        if(!$request->has('item_request_form_id') && !$request->has('passenger_request_form_id')){
            session()->flash('danger', 'Estimado Usuario/a: no hay items de bienes y/o servicios o pasajeros asociados al formulario de requerimiento para solicitar cambio de presupuesto');
            return redirect()->route('request_forms.supply.purchase', compact('requestForm'));
        }
        $requestForm->newBudget = $request->new_amount;
        $itemsChangedCount = 0;
        // return $request;
        if($request->has('item_request_form_id')){
            foreach ($request->item_request_form_id as $key => $item) {
                $valuesChangedCount = 0; $itemChanged = null;
                $itemToChange = ItemRequestForm::findorFail($item);
                $itemChanged = new ItemChangedRequestForm();
                if(trim($itemToChange->specification) !== $request->new_specification[$key]) { $itemChanged->specification = $request->new_specification[$key]; $valuesChangedCount++; }
                if($itemToChange->quantity != $request->new_quantity[$key]){ $itemChanged->quantity = $request->new_quantity[$key]; $valuesChangedCount++; }
                if($itemToChange->unit_value != $request->new_unit_value[$key]){ $itemChanged->unit_value = $request->new_unit_value[$key]; $valuesChangedCount++; }
                if($itemToChange->tax != $request->new_tax[$key]){ $itemChanged->tax = $request->new_tax[$key]; $valuesChangedCount++; }
                if($itemToChange->expense != $request->new_item_total[$key]){ $itemChanged->expense = $request->new_item_total[$key]; $valuesChangedCount++; }
                if($valuesChangedCount > 0){
                    $itemChanged->item_request_form_id = $item;
                    $itemChanged->status = 'pending';
                    $itemChanged->save();
                    $itemsChangedCount++;
                }
            }
        }

        if($request->has('passenger_request_form_id')){
            foreach ($request->passenger_request_form_id as $key => $passenger) {
                $valuesChangedCount = 0; $passengerChanged = null;
                $passengerToChange = Passenger::findorFail($passenger);
                $passengerChanged = new PassengerChanged();
                if($passengerToChange->unit_value != $request->new_item_total[$key]){ $passengerChanged->unit_value = $request->new_item_total[$key]; $valuesChangedCount++; }
                if($valuesChangedCount > 0){
                    $passengerChanged->passenger_id = $passenger;
                    $passengerChanged->status = 'pending';
                    $passengerChanged->save();
                    $itemsChangedCount++;
                }
            }
        }

        if (!$itemsChangedCount) {
            session()->flash('danger', 'Estimado Usuario/a: para solicitar un nuevo presupuesto se requiere realizar cambios en al menos un item o pasajero.');
            return redirect()->back()->withInput();
        }
        EventRequestForm::createNewBudgetEvent($requestForm);
        session()->flash('info', 'Se ha solicitado un nuevo presupuesto pendiente de su aprobación, mientras no tenga respuesta de esta solicitud no podrá registrar nuevas compras.');
        return redirect()->route('request_forms.supply.index');
    }

    public function create_form_document(RequestForm $requestForm, $has_increased_expense){
        //dd($requestForm);

        if($has_increased_expense){
            $requestForm->has_increased_expense = true;
            $requestForm->new_estimated_expense = $requestForm->estimated_expense + $requestForm->eventRequestForms()->where('status', 'pending')->where('event_type', 'budget_event')->first()->purchaser_amount;
            $requestForm->load('itemRequestForms.latestPendingItemChangedRequestForms', 'passengers.latestPendingPassengerChanged');
        }

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('request_form.documents.form_document', compact('requestForm'));

        return $pdf->stream('mi-archivo.pdf');

        // $formDocumentFile = PDF::loadView('request_form.documents.form_document', compact('requestForm'));
        // return $formDocumentFile->download('pdf_file.pdf');
    }

    public function create_view_document(RequestForm $requestForm, $has_increased_expense){

        if($has_increased_expense && $has_increased_expense != 11){ // has_increased_expense = 11 => upload by user
            $requestForm->has_increased_expense = true;
            $requestForm->new_estimated_expense = $requestForm->estimated_expense + $requestForm->eventRequestForms()->where('status', 'pending')->where('event_type', 'budget_event')->first()->purchaser_amount;
            $requestForm->load('itemRequestForms.latestPendingItemChangedRequestForms', 'passengers.latestPendingPassengerChanged');
        }

        $pdf = app('dompdf.wrapper');

        $pdf->loadView('request_form.documents.form_document', compact('requestForm'));

        $output = $pdf->output();

        return new Response($output, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' =>  'inline; filename="formulario_requerimiento.pdf"']
        );
    }

    public function create(PurchasePlan $purchasePlan = null){
        $requestForm=null;
        return  view('request_form.create', compact('requestForm', 'purchasePlan'));
    }


    public function destroy(RequestForm $requestForm)
    {
        $requestForm->delete();
        session()->flash('info', 'El formulario de requerimiento N° '.$requestForm->folio.' ha sido eliminado correctamente.');
        return redirect()->back();
    }


    // public function supervisorUserIndex()
    // {
    //     if(auth()->user()->organizationalUnit->id != '37' ){
    //         session()->flash('danger', 'Usuario: '.auth()->user()->fullName.' no pertenece a '.OrganizationalUnit::getName('37').'.');
    //         return redirect()->route('request_forms.index');
    //     }else
    //       {
    //         $waitingRequestForms = RequestForm::where('status', 'in_progress')
    //                                ->where('supervisor_user_id', auth()->user()->id)
    //                                ->whereHas('eventRequestForms', function ($q) {
    //                                $q->where('event_type','supply_event')
    //                               ->where('status', 'approved');})
    //                               ->get();
    //         $rejectedRequestForms    = RequestForm::where('status', 'rejected')->get();
    //         return view('request_form.supervisor_user_index', compact('waitingRequestForms', 'rejectedRequestForms'));
    //       }
    // }

    public function purchasingProcess(RequestForm $requestForm){
      $eventType = 'supply_event';
      return view('request_form.purchasing_process', compact('requestForm', 'eventType'));
    }

    public function show(RequestForm $requestForm)
    {
        $eventType = 'supply_event';
        $requestForm->load('user', 'userOrganizationalUnit', 'contractManager', 'requestFormFiles', 'purchasingProcess.details', 'purchasingProcess.detailsPassenger', 'eventRequestForms.signerOrganizationalUnit', 'eventRequestForms.signerUser', 'purchaseMechanism', 'purchaseType', 'children', 'father.requestFormFiles', 'associateProgram');
        $requestForm->load(['eventRequestForms' => fn($q) => $q->withTrashed()]);
        // return $requestForm;
        return view('request_form.show', compact('requestForm', 'eventType'));
    }

    public function callbackSign($message, $modelId, SignaturesFile $signaturesFile = null)
    {
        if (!$signaturesFile) {
            session()->flash('danger', $message);
            return redirect()->route('request_forms.pending_forms');
        }
        else{
            $requestForm = RequestForm::with('eventRequestForms')->find($modelId);

            //ACTUALIZAO EVENTO DE FINANZAS
            $event = $requestForm->eventRequestForms->where('event_type', 'finance_event')->first();
            $event->update([
              'signature_date'       => Carbon::now(),
              'position_signer_user' => OrganizationalUnit::find($event->ou_signer_user)->currentManager->position,
              'status'               => 'approved',
              'signer_user_id'       => auth()->id(),
              'comment'              => request()->comment
            ]);

            $nextEvent = $requestForm->eventRequestForms->where('cardinal_number', $requestForm->eventRequestForms->where('event_type', 'finance_event')->first()->cardinal_number + 1);

            if(!$nextEvent->isEmpty()){
                //Envío de notificación para visación.
                $now = Carbon::now();
                //manager
                $type = 'manager';
                /* FIX: @mirandaljorge si no hay manager en Authority, se va a caer */
                $mail_notification_ou_manager = Authority::getAuthorityFromDate($nextEvent->first()->ou_signer_user, Carbon::now(), $type);

                if (env('APP_ENV') == 'production' OR env('APP_ENV') == 'testing') {
                    if($mail_notification_ou_manager){
                        $emails = [$mail_notification_ou_manager->user->email];
                        Mail::to($emails)
                        ->cc(env('APP_RF_MAIL'))
                        ->send(new RequestFormSignNotification($requestForm, $nextEvent->first()));
                    }
                }
            }

            $requestForm->signatures_file_id = $signaturesFile->id;
            $requestForm->save();

            /* Crear el CDP */
            $requestForm->createCdp();

            session()->flash('success', $message);
            return redirect()->route('request_forms.pending_forms');
        }

    }

    public function callbackSignNewBudget($message, $modelId, SignaturesFile $signaturesFile = null)
    {
        if (!$signaturesFile) {
            session()->flash('danger', $message);
            return redirect()->route('request_forms.pending_forms');
        }
        else{
            $requestForm = RequestForm::with('eventRequestForms', 'itemRequestForms.latestPendingItemChangedRequestForms', 'passengers.latestPendingPassengerChanged')->find($modelId);

            // Modificar items
            if($requestForm->itemRequestForms)
                foreach($requestForm->itemRequestForms as $item){
                    if($item->latestPendingItemChangedRequestForms){
                        $fieldsToChange = array_filter($item->latestPendingItemChangedRequestForms->only(['quantity', 'unit_value', 'specification', 'tax', 'expense']));
                        $item->update($fieldsToChange);
                        $item->latestPendingItemChangedRequestForms->update(['status' => 'approved']);
                    }
                }

            //Modificar pasajeros
            if($requestForm->passengers)
                foreach($requestForm->passengers as $passenger){
                    if($passenger->latestPendingPassengerChanged){
                        $fieldsToChange = array_filter($passenger->latestPendingPassengerChanged->only(['unit_value']));
                        $passenger->update($fieldsToChange);
                        $passenger->latestPendingPassengerChanged->update(['status' => 'approved']);
                    }
                }

            //ACTUALIZAO EVENTO DE FINANZAS
            $event = $requestForm->eventRequestForms->where('event_type', 'budget_event')->where('status', 'pending')->first();
            $event->update([
              'signature_date'       => Carbon::now(),
              'position_signer_user' => OrganizationalUnit::find($event->ou_signer_user)->currentManager->position,
              'status'               => 'approved',
              'signer_user_id'       => auth()->id(),
              'comment'              => request()->comment 
            ]);

            $oldSignatureFile = new OldSignatureFile();
            $oldSignatureFile->request_form_id = $requestForm->id;
            $oldSignatureFile->old_signature_file_id = $requestForm->signatures_file_id;
            $oldSignatureFile->save();

            $requestForm->has_increased_expense = true;
            $requestForm->estimated_expense = $requestForm->estimated_expense + $event->purchaser_amount;
            // $requestForm->old_signatures_file_id = $requestForm->signatures_file_id;
            $requestForm->signatures_file_id = $signaturesFile->id;
            $requestForm->save();

            $emails = [$requestForm->user->email,
                      $requestForm->contractManager->email,
                      $requestForm->eventPurchaserNewBudget()->email
                  ];

            Mail::to($emails)
            ->cc(env('APP_RF_MAIL'))
            ->send(new RfEndNewBudgetSignNotification($requestForm));

            session()->flash('success', $message);
            return redirect()->route('request_forms.pending_forms');
        }

    }

    public function signedRequestFormPDF(RequestForm $requestForm, $original)
    {
      return Storage::disk('gcs')->response($original ? $requestForm->signedRequestForm->signed_file : $requestForm->signedOldRequestForm->signed_file);
    }

    public function signedOldRequestFormPDF(OldSignatureFile $oldSignatureFile)
    {
        return Storage::disk('gcs')->response($oldSignatureFile->signedFile->signed_file);
    }

    public function create_provision(RequestForm $requestForm, Request $request)
    {
        if($requestForm->isBlocked()){ // FR ids con restricción de No generar suministros
            session()->flash('danger', 'No se puede generar un nuevo suministro para el formulario de requerimiento N° '.$requestForm->folio.'.');
            return redirect()->back();
        }

        $requestForm->load('purchasingProcess.details', 'children.purchasingProcess.details');
        // Validar que el formulario req padre esté finalizado.
        if(!$requestForm->purchasingProcess || $requestForm->purchasingProcess->status->value != 'finalized'){
            session()->flash('danger', 'No se puede generar un nuevo suministro, el formulario de requerimiento N° '.$requestForm->folio.' no ha finalizado su proceso de compra.');
            return redirect()->back();
        }
        // Validar que la suma de total adjudicado de suministros registrados no sobrepase de lo adjudicado en el form req
        if($requestForm->purchasingProcess->getExpense() - $requestForm->getTotalExpense() <= 0){ // Ya no me queda saldo que gastar
            session()->flash('danger', 'No se puede generar un nuevo suministro, el formulario de requerimiento N° '.$requestForm->folio.' ya no le queda saldo disponible del monto total de la compra adjudicada.');
            return redirect()->back();
        }

        $requestForm->load('itemRequestForms');
        $newRequestForm = $requestForm->replicate();
        $newRequestForm->folio = $requestForm->folio.'-'.($requestForm->children()->withTrashed()->count() + 1);
        $newRequestForm->request_form_id = $requestForm->id;
        $newRequestForm->name = $newRequestForm->name . ($request->month ? ' MES '.$request->month : '') . ($request->year ? ' '.$request->year : '');
        $newRequestForm->request_user_id = Auth::id();
        $newRequestForm->request_user_ou_id = Auth::user()->organizational_unit_id;
        $newRequestForm->contract_manager_ou_id = User::withTrashed()->find($requestForm->contract_manager_id)->organizational_unit_id;
        $newRequestForm->estimated_expense = 0;
        // $ouSearch = Parameter::where('module', 'ou')->where('parameter', 'DireccionSSI')->first()->value;
        $ouSearch = Parameter::get('ou', 'DireccionSSI');
        if($requestForm->eventRequestForms()->where('event_type', 'superior_leader_ship_event')->where('ou_signer_user', $ouSearch)->count() > 0) $newRequestForm->superior_chief = null;
        $newRequestForm->has_increased_expense = null;
        $newRequestForm->subtype = Str::contains($requestForm->subtype, 'bienes') ? 'bienes ejecución inmediata' : 'servicios ejecución inmediata';
        $newRequestForm->sigfe = null;
        $newRequestForm->status = 'saved';
        $newRequestForm->signatures_file_id = null;
        $newRequestForm->old_signatures_file_id = null;
        $newRequestForm->approved_at = null;
        $newRequestForm->push();

        $total = 0;
        foreach($requestForm->getRelations() as $relation => $items){
            if($relation == 'itemRequestForms'){
                foreach($items as $item){
                    unset($item->id);
                    $item->request_form_id = $newRequestForm->id;
                    $item->quantity = 1;
                    $item->expense = $this->totalValueWithTaxes($item->tax, $item->unit_value);
                    $total += $item->expense;
                    $newRequestForm->{$relation}()->create($item->toArray());
                }
            }
        }

        $newRequestForm->update(['estimated_expense' => $total]);

        // EventRequestform::createLeadershipEvent($newRequestForm);
        // EventRequestform::createPreFinanceEvent($newRequestForm);
        // EventRequestform::createFinanceEvent($newRequestForm);
        // EventRequestform::createSupplyEvent($newRequestForm);

        // //Envío de notificación a Adm de Contrato y abastecimiento.
        // $mail_contract_manager = User::select('email')
        // ->where('id', $newRequestForm->contract_manager_id)
        // ->first();


        // if (env('APP_ENV') == 'production' OR env('APP_ENV') == 'testing') {
        //     if($mail_contract_manager){
        //         $emails = [$mail_contract_manager];
        //         Mail::to($emails)
        //             ->cc(env('APP_RF_MAIL'))
        //             ->send(new NewRequestFormNotification($newRequestForm));
        //     }
        // }
        // //---------------------------------------------------------

        // //Envío de notificación para visación.
        // //manager
        // $type = 'manager';
        // $mail_notification_ou_manager = Authority::getAuthorityFromDate($newRequestForm->eventRequestForms->first()->ou_signer_user, Carbon::now(), $type);

        // $emails = [$mail_notification_ou_manager->user->email];

        // if (env('APP_ENV') == 'production' OR env('APP_ENV') == 'testing') {
        //     if($mail_notification_ou_manager){
        //         Mail::to($emails)
        //             ->cc(env('APP_RF_MAIL'))
        //             ->send(new RequestFormSignNotification($newRequestForm, $newRequestForm->eventRequestForms->first()));
        //     }
        // }
        // //---------------------------------------------------------

        session()->flash('info', 'Formulario de requerimiento N° '.$newRequestForm->folio.' fue creado con éxito. <br>
                                  Recuerde que es un formulario dependiente de ID N° '.$requestForm->folio.'. <br>
                                  Se solicita que modifique y guarde los cambios en los items para el nuevo gasto estimado de su formulario de requerimiento. <br>
                                  Guarde y envíe su formulario cuando esté listo para su tramitación en los departamentos correspondientes.');
        return redirect()->route('request_forms.edit', $newRequestForm);
    }

    public function totalValueWithTaxes($tax, $value)
    {
        /* TODO: Pasar valores fijos a single parameter */
        // Porcentaje retención boleta de honorarios según el año vigente
        $withholding_tax = [2021 => 0.115, 2022 => 0.1225, 2023 => 0.13, 2024 => 0.1375, 2025 => 0.145, 2026 => 0.1525, 2027 => 0.16, 2028 => 0.17];

        if($tax == 'iva') return $value * 1.19;
        if($tax == 'bh') return isset($withholding_tax[date('Y')]) ? round($value / (1 - $withholding_tax[date('Y')])) : round($value / (1 - end($withholding_tax)));
        return $value;
    }

    public function export(Request $request)
    {
        return Excel::download(new RequestFormsExport($request), 'requestFormsExport_'.Carbon::now().'.xlsx');
    }

    public function copy(RequestForm $requestForm)
    {
        $requestForm->load('itemRequestForms', 'requestFormFiles', 'passengers');
        $newRequestForm = $requestForm->replicate();
        $newRequestForm->folio = $this->createFolio();
        $newRequestForm->request_form_id = null;
        // $newRequestForm->estimated_expense = 0;
        $newRequestForm->has_increased_expense = null;
        $newRequestForm->sigfe = null;
        $newRequestForm->status = 'saved';
        $newRequestForm->signatures_file_id = null;
        $newRequestForm->old_signatures_file_id = null;
        $newRequestForm->approved_at = null;
        $newRequestForm->push();

        // $total = 0;
        foreach($requestForm->getRelations() as $relation => $items){
            if($relation == 'itemRequestForms'){ 
                foreach($items as $item){
                    unset($item->id);
                    $item->request_form_id = $newRequestForm->id;
                    // $item->expense = $this->totalValueWithTaxes($item->tax, $item->unit_value);
                    // $total += $item->expense;
                    $newRequestForm->{$relation}()->create($item->toArray());
                }
            }
            if($relation == 'passengers'){
                foreach($items as $passenger){
                    unset($passenger->id);
                    $passenger->request_form_id = $newRequestForm->id;
                    // $total += $passenger->unit_value;
                    $newRequestForm->{$relation}()->create($passenger->toArray());
                }
            }
            if($relation == 'requestFormFiles'){
                foreach($items as $requestFormFile){
                    unset($requestFormFile->id);
                    $requestFormFile->request_form_id = $newRequestForm->id;
                    $newRequestForm->{$relation}()->create($requestFormFile->toArray());
                }
            }
        }
        // $newRequestForm->update(['estimated_expense' => $total]);

        session()->flash('info', 'Formulario de requerimiento N° '.$newRequestForm->folio.' fue creado con éxito. <br>
                                  Recuerde que es un formulario copiado a partir de otro formulario N° '.$requestForm->folio.'. <br>
                                  Se solicita que modifique y guarde los cambios en los items para el nuevo gasto estimado de su formulario de requerimiento. <br>
                                  Guarde y envíe su formulario cuando esté listo para su tramitación en los departamentos correspondientes.');
        return redirect()->route('request_forms.edit', $newRequestForm);
    }

    public function rollback(RequestForm $requestForm)
    {
        if($requestForm->status->value != 'approved'){
            session()->flash('danger', 'No se puede revertir firmas para el formulario de requerimiento N° '.$requestForm->folio.'.');
            return redirect()->back();
        }

        $requestForm->load('eventRequestForms');
        $counter = $requestForm->has_increased_expense ? -1 : -2;
        foreach($requestForm->eventRequestForms->take($counter) as $event){
            $event->update(['signer_user_id' => null, 'position_signer_user' => null, 'status' => 'pending', 'signature_date' => null]);
        }
        
        if($requestForm->has_increased_expense){
            $requestForm->has_increased_expense = null;
            $requestForm->estimated_expense -= $requestForm->eventRequestForms->last()->purchaser_amount;
            $requestForm->signatures_file_id = $requestForm->old_signatures_file_id;
            $requestForm->old_signatures_file_id = null;
        }else{
            // $requestForm->purchasers()->detach();
            $requestForm->signatures_file_id = null;
            $requestForm->status->value = 'pending';
            $requestForm->approved_at = null;
        }

        $requestForm->save();
        session()->flash('info', 'El formulario de requerimiento N° '.$requestForm->folio.' se ha sido revertido las firmas correctamente.');
        return redirect()->route('request_forms.show', $requestForm);
    }

    private function createFolio(){
        $startOfYear = Carbon::now()->startOfYear();
        $endOfYear = Carbon::now()->endOfYear();
        $counter = RequestForm::withTrashed()->whereNull('request_form_id')->where('created_at', '>=' , $startOfYear)->where('created_at', '<=', $endOfYear)->count() + 1;
        return Carbon::now()->year.'-'.$counter;
    }

    public function show_form_items($type){
        return view('request_form.reports.show_form_items', compact('type'));
    }

    public function show_amounts_by_program(){
        return view('request_form.reports.show_amounts_by_program');
    }

    public function upload_form_document(Request $request, RequestForm $requestForm){
        // return $requestForm;
        $requestForm->load('eventRequestForms');
        $event = $requestForm->eventRequestForms->where('event_type', 'finance_event')->where('status', 'pending')->first();
        $currentFinanceManager = OrganizationalUnit::find($event->ou_signer_user)->currentManager;
        if(!is_null($event)){
          $event->signature_date = Carbon::now();
          $event->position_signer_user = $currentFinanceManager->position;
          $event->status  = 'approved';
          $event->comment = 'Formulario cargado por el solicitante';
          $event->signerUser()->associate($currentFinanceManager->user_id);
          $event->save();

          //Subir al storage archivo pdf con firmas a mano
          $reqFile = new RequestFormFile();
          $file_name = Carbon::now()->format('Y_m_d_H_i_s')." FR_".$requestForm->folio;
          $reqFile->name = $file_name;
          $reqFile->file = $request->docSigned->storeAs('/ionline/request_forms/request_files', $file_name.'.'.$request->docSigned->extension(), 'gcs');
          $reqFile->request_form_id = $requestForm->id;
          $reqFile->user_id = auth()->user()->id;
          $reqFile->save();

          $requestForm->signatures_file_id = 11;
          $requestForm->save();
      
          $nextEvent = $event->requestForm->eventRequestForms->where('cardinal_number', $event->cardinal_number + 1);

          if(!$nextEvent->isEmpty()){
            //Envío de notificación para visación.
            $now = Carbon::now();
            //manager
            $type = 'manager';
            /* FIX: @mirandaljorge si no hay manager en Authority, se va a caer */
            $mail_notification_ou_manager = Authority::getAuthorityFromDate($nextEvent->first()->ou_signer_user, Carbon::now(), $type);

            
            if (env('APP_ENV') == 'production' OR env('APP_ENV') == 'testing') {
                if($mail_notification_ou_manager){
                  $emails = [$mail_notification_ou_manager->user->email];
                  Mail::to($emails)
                  ->cc(env('APP_RF_MAIL'))
                  ->send(new RequestFormSignNotification($requestForm, $nextEvent->first()));
              }
            }
          }

          session()->flash('info', 'Formulario de Requerimientos Nro.'.$requestForm->folio.' AUTORIZADO correctamente!');
          return redirect()->route('request_forms.my_forms');
        }

      session()->flash('danger', 'Formulario de Requerimientos Nro.'.$requestForm->folio.' NO se puede Autorizar!');
      return redirect()->route('request_forms.my_forms');
    }

}
