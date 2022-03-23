<?php

namespace App\Http\Controllers\RequestForms;

use App\Models\RequestForms\RequestForm;
use App\Models\RequestForms\Item;
use App\RequestForms\Passage;
use App\RequestForms\RequestFormEvent;
use App\RequestForms\RequestFormItemCode;
use App\Rrhh\OrganizationalUnit;
use App\Rrhh\Authority;
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
use App\User;
use App\Mail\PurchaserNotification;
use App\Mail\RfEndNewBudgetSignNotification;
use Illuminate\Http\Response;

class RequestFormController extends Controller {

    public function my_forms() {
        // $createdRequestForms    = auth()->user()->requestForms()->where('status', 'created')->get();
        // $inProgressRequestForms = auth()->user()->requestForms()->where('status', 'pending')->get();
        // $approvedRequestForms   = auth()->user()->requestForms()->where('status', 'approved')->get();
        // $rejectedRequestForms   = auth()->user()->requestForms()->where('status', 'rejected')->orWhere('status', 'closed')->get();
        // $empty = false;
        // if(count($rejectedRequestForms) == 0 && count($createdRequestForms) == 0 && count($inProgressRequestForms) == 0 && count($approvedRequestForms) ==  0){
        //     $empty=true;
        //     return view('request_form.index', compact('empty'));}
        // return view('request_form.index', compact('createdRequestForms', 'inProgressRequestForms', 'rejectedRequestForms','approvedRequestForms', 'empty'));

        $my_pending_requests = RequestForm::with('user', 'userOrganizationalUnit', 'purchaseMechanism', 'eventRequestForms.signerOrganizationalUnit', 'father:id,folio,has_increased_expense')
            ->where('request_user_id', Auth::user()->id)
            ->where(function ($q){
                $q->where('status', 'pending')
                ->OrWhere('status', 'saved');
            })
            // ->where('status', 'pending')
            // ->OrWhere('status', 'saved')
            ->latest('id')
            ->get();

        $my_requests = RequestForm::with('user', 'userOrganizationalUnit', 'purchaseMechanism', 'eventRequestForms.signerOrganizationalUnit', 'father:id,folio,has_increased_expense')
            ->where('request_user_id', Auth::user()->id)
            ->whereIn('status', ['approved', 'rejected'])
            ->latest('id')
            ->get();

        return view('request_form.my_forms', compact('my_requests', 'my_pending_requests'));
    }

    public function all_forms()
    {
        if(!Auth()->user()->hasPermissionTo('Request Forms: all') && Auth()->user()->organizational_unit_id != 40){
            session()->flash('danger', 'Estimado Usuario/a: no tiene los permisos necesarios para ver todos los formularios.');
            return redirect()->route('request_forms.my_forms');
        }

        $request_forms = RequestForm::with('user', 'userOrganizationalUnit', 'purchaseMechanism', 'eventRequestForms.signerOrganizationalUnit', 'purchasers', 'father:id,folio,has_increased_expense')->latest('id')->paginate(30);

        return view('request_form.all_forms', compact('request_forms'));
    }

    public function get_events_type_user()
    {
        $events_type = [];

        $authorities = Authority::getAmIAuthorityFromOu(Carbon::now(), 'manager', Auth::id());

        if(count($authorities) > 0){
          foreach ($authorities as $authority){
              $iam_authorities_in[] = $authority->organizational_unit_id;
          }

          //superchief?
          $result = RequestForm::whereHas('eventRequestForms', function($q) use ($iam_authorities_in){
              return $q->whereIn('ou_signer_user', $iam_authorities_in)->where('event_type', 'superior_leader_ship_event');
          })->count();

          // if($result > 0 && in_array(Auth::user()->organizationalUnit->id, $iam_authorities_in)) $events_type[] = 'superior_leader_ship_event';
          // if(in_array(Auth::user()->organizationalUnit->id, $iam_authorities_in)) $events_type[] = 'leader_ship_event';
          // if(Auth::user()->organizationalUnit->id == 40 && in_array(Auth::user()->organizationalUnit->id, $iam_authorities_in)) $events_type[] = 'finance_event';
          // if(Auth::user()->organizationalUnit->id == 37 && in_array(Auth::user()->organizationalUnit->id, $iam_authorities_in)) $events_type[] = 'supply_event';

          if($result > 0) $events_type[] = 'superior_leader_ship_event';
          $events_type[] = 'leader_ship_event';
          if(in_array(40, $iam_authorities_in)) $events_type[] = 'finance_event';
          if(in_array(37, $iam_authorities_in)) $events_type[] = 'supply_event';

        }
        else{
          $manager = Authority::getAuthorityFromDate(Auth::user()->organizationalUnit->id, Carbon::now(), 'manager');
          if(Auth::user()->organizationalUnit->id == 40 && $manager->user_id != Auth::user()->id) $events_type[] = 'pre_finance_event';
        }

        return $events_type;
    }

    public function pending_forms()
    {
        $my_pending_forms_to_signs = $not_pending_forms = $new_budget_pending_to_sign = $my_forms_signed = collect();

        $events_type = $this->get_events_type_user();

        // return $events_type;

        $iam_authorities_in = [];

        $authorities = Authority::getAmIAuthorityFromOu(Carbon::now(), 'manager', Auth::id());

        // if(count($authorities) > 0){
          foreach ($authorities as $authority){
              $iam_authorities_in[] = $authority->organizational_unit_id;
          }

          foreach($events_type as $event_type){
              $prev_event_type = $event_type == 'supply_event' ? 'finance_event' : ($event_type == 'finance_event' ? 'pre_finance_event' : ($event_type == 'pre_finance_event' ? ['superior_leader_ship_event', 'leader_ship_event'] : ($event_type == 'superior_leader_ship_event' ? 'leader_ship_event' : null)));
              // return $prev_event_type;
              $result = RequestForm::with('user', 'userOrganizationalUnit', 'purchaseMechanism', 'eventRequestForms.signerOrganizationalUnit')
                  ->where('status', 'pending')
                  ->whereHas('eventRequestForms', function($q) use ($event_type, $iam_authorities_in){
                      return $q->where('status', 'pending')->whereIn('ou_signer_user', (count($iam_authorities_in) > 0 ? $iam_authorities_in : [Auth::user()->organizationalUnit->id]))->where('event_type', $event_type);
                  })->when($prev_event_type, function($q) use ($prev_event_type) {
                      return $q->whereDoesntHave('eventRequestForms', function ($f) use ($prev_event_type) {
                          return is_array($prev_event_type) ? $f->whereIn('event_type', $prev_event_type)->where('status', 'pending') : $f->where('event_type', $prev_event_type)->where('status', 'pending');
                      });
                  })->get();
              $my_pending_forms_to_signs = $my_pending_forms_to_signs->concat($result);
          }
        // }

        // return $my_pending_forms_to_signs;

        foreach($events_type as $event_type){
            if(in_array($event_type, ['finance_event', 'supply_event'])){
                $prev_event_type = $event_type == 'finance_event' ? 'pre_budget_event' : null;
                $result = RequestForm::with('user', 'userOrganizationalUnit', 'purchaseMechanism', 'eventRequestForms.signerOrganizationalUnit')
                    ->where('status', 'approved')
                    ->whereHas('eventRequestForms', function($q) use ($event_type){
                        return $q->where('status', 'pending')->where('ou_signer_user', Auth::user()->organizationalUnit->id)->where('event_type', $event_type == 'finance_event' ? 'budget_event' : 'pre_budget_event');
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

        foreach($events_type as $event_type){
            if(in_array($event_type, ['pre_finance_event', 'finance_event', 'supply_event']) || Auth::user()->organizationalUnit->id == 37){
                $not_pending_forms = RequestForm::with('user', 'userOrganizationalUnit', 'purchaseMechanism', 'eventRequestForms.signerOrganizationalUnit')
                        ->where('status', '!=', 'pending')->latest('id')->paginate(15, ['*'], 'p1');
            }
        }

        // return $not_pending_forms;

        $my_forms_signed = RequestForm::with('user', 'userOrganizationalUnit', 'purchaseMechanism', 'eventRequestForms.signerOrganizationalUnit')
            ->whereHas('eventRequestForms', $filter = function($q){
                return $q->where('signer_user_id', Auth::user()->id);
            })->latest('id')->paginate(15, ['*'], 'p2');

        return view('request_form.pending_forms', compact('my_pending_forms_to_signs', 'not_pending_forms', 'new_budget_pending_to_sign', 'my_forms_signed', 'events_type'));
    }

    public function contract_manager_forms() {

        $contract_manager_forms = RequestForm::with('user', 'userOrganizationalUnit', 'purchaseMechanism', 'eventRequestForms.signerOrganizationalUnit', 'father:id,folio,has_increased_expense')
            ->where('contract_manager_id', Auth::user()->id)
            ->latest('id')
            ->paginate(30);

        return view('request_form.contract_manager_forms', compact('contract_manager_forms'));
    }


    // public function edit(RequestForm $requestForm) {
    //     if($requestForm->request_user_id != auth()->user()->id){
    //       session()->flash('danger', 'Formulario de Requerimiento N° '.$requestForm->id.' NO pertenece a Usuario: '.auth()->user()->getFullNameAttribute());
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
    //         $manager = $manager->user->getFullNameAttribute();
    //     $requestForms = RequestForm::all();
    //     return view('request_form.edit', compact('requestForm', 'manager', 'requestForms'));
    // }

    public function edit(RequestForm $requestForm){
        // $requestForm=null;
        if(!Auth()->user()->hasPermissionTo('Request Forms: all') && Auth()->user()->organizational_unit_id != 40 && $requestForm->request_user_id != auth()->user()->id){
            session()->flash('danger', 'Estimado Usuario/a: no tiene los permisos necesarios para editar formulario N° '.$requestForm->folio);
            return redirect()->route('request_forms.my_forms');
        }
        return  view('request_form.create', compact('requestForm'));
    }

    public function sign(RequestForm $requestForm, $eventType)
    {
        $eventTypeBudget = null;
        if(in_array($eventType, ['pre_budget_event', 'budget_event'])){
            $eventTypeBudget = $eventType == 'pre_budget_event' ? 'supply_event' : 'finance_event';
            $requestForm->has_increased_expense = true;
            $requestForm->new_estimated_expense = $requestForm->estimated_expense + $requestForm->eventRequestForms()->where('status', 'pending')->where('event_type', 'budget_event')->first()->purchaser_amount;
        }

        $eventTitles = ['superior_leader_ship_event' => 'Dirección', 'leader_ship_event' => 'Jefatura', 'pre_finance_event' => 'Refrendación Presupuestaria', 'finance_event' => 'Finanzas', 'supply_event' => 'Abastecimiento', 'pre_budget_event' => 'Nuevo presupuesto', 'budget_event' => 'Nuevo presupuesto'];

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

        $requestForm->load('itemRequestForms');

        $title = 'Formularios de Requerimiento - Autorización ' . $eventTitles[$eventType];

        //$manager              = Authority::getAuthorityFromDate(Auth::user()->organizationalUnit->id, Carbon::now(), 'manager');

        // $position             = $manager->position;
        // $organizationalUnit   = $manager->organizationalUnit->name;
        // if(is_null($manager))
        //     $manager = 'No se ha registrado una Autoridad en el módulo correspondiente!';
        // else
        //     $manager = $manager->user->getFullNameAttribute();
        return view('request_form.sign', compact('requestForm', 'eventType', 'title'));
    }

    public function create_new_budget(Request $request, RequestForm $requestForm)
    {
        $requestForm->newBudget = $request->newBudget;
        EventRequestForm::createNewBudgetEvent($requestForm);
        session()->flash('info', 'Se ha solicitado un nuevo presupuesto pendiente de su aprobación, mientras no tenga respuesta de esta solicitud no podrá registrar nuevas compras.');
        return redirect()->route('request_forms.supply.index');
    }

    public function create_form_document(RequestForm $requestForm, $has_increased_expense){
        //dd($requestForm);

        if($has_increased_expense){
            $requestForm->has_increased_expense = true;
            $requestForm->new_estimated_expense = $requestForm->estimated_expense + $requestForm->eventRequestForms()->where('status', 'pending')->where('event_type', 'budget_event')->first()->purchaser_amount;
        }

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('request_form.documents.form_document', compact('requestForm'));

        return $pdf->stream('mi-archivo.pdf');

        // $formDocumentFile = PDF::loadView('request_form.documents.form_document', compact('requestForm'));
        // return $formDocumentFile->download('pdf_file.pdf');
    }

    public function create_view_document(RequestForm $requestForm, $has_increased_expense){

        if($has_increased_expense){
            $requestForm->has_increased_expense = true;
            $requestForm->new_estimated_expense = $requestForm->estimated_expense + $requestForm->eventRequestForms()->where('status', 'pending')->where('event_type', 'budget_event')->first()->purchaser_amount;
        }

        $pdf = app('dompdf.wrapper');

        $pdf->loadView('request_form.documents.form_document', compact('requestForm'));

        $output = $pdf->output();

        return new Response($output, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' =>  'inline; filename="formulario_requerimiento.pdf"']
        );
    }

    public function create(){
        $requestForm=null;
        return  view('request_form.create', compact('requestForm'));
    }


    public function destroy(RequestForm $requestForm)
    {
        $requestForm->delete();
        session()->flash('info', 'El formulario de requerimiento N° '.$requestForm->folio.' ha sido eliminado correctamente.');
        return redirect()->route('request_forms.my_forms');
    }


    // public function supervisorUserIndex()
    // {
    //     if(auth()->user()->organizationalUnit->id != '37' ){
    //         session()->flash('danger', 'Usuario: '.auth()->user()->getFullNameAttribute().' no pertenece a '.OrganizationalUnit::getName('37').'.');
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
        return view('request_form.show', compact('requestForm', 'eventType'));
    }

    public function callbackSign($message, $modelId, SignaturesFile $signaturesFile = null)
    {
        if (!$signaturesFile) {
            session()->flash('danger', $message);
            return redirect()->route('request_forms.pending_forms');
        }
        else{
            $requestForm = RequestForm::find($modelId);

            //ACTUALIZAO EVENTO DE FINANZAS
            $requestForm->eventRequestForms->where('event_type', 'finance_event')->first()->update([
              'signature_date'       => Carbon::now(),
              'position_signer_user' => auth()->user()->position,
              'status'               => 'approved',
              'signer_user_id'       => auth()->id()
            ]);

            $nextEvent = $requestForm->eventRequestForms->where('cardinal_number', $requestForm->eventRequestForms->where('event_type', 'finance_event')->first()->cardinal_number + 1);

            if(!$nextEvent->isEmpty()){
                //Envío de notificación para visación.
                $now = Carbon::now();
                //manager
                $type = 'manager';
                $mail_notification_ou_manager = Authority::getAuthorityFromDate($nextEvent->first()->ou_signer_user, Carbon::now(), $type);

                $emails = [$mail_notification_ou_manager->user->email];

                if($mail_notification_ou_manager){
                    Mail::to($emails)
                      ->cc(env('APP_RF_MAIL'))
                      ->send(new RequestFormSignNotification($requestForm, $nextEvent->first()));
                }
            }

            $requestForm->signatures_file_id = $signaturesFile->id;
            $requestForm->save();

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
            $requestForm = RequestForm::find($modelId);

            //ACTUALIZAO EVENTO DE FINANZAS
            $requestForm->eventRequestForms->where('event_type', 'budget_event')->first()->update([
              'signature_date'       => Carbon::now(),
              'position_signer_user' => auth()->user()->position,
              'status'               => 'approved',
              'signer_user_id'       => auth()->id()
            ]);

            $requestForm->has_increased_expense = true;
            $requestForm->estimated_expense = $requestForm->estimated_expense + $requestForm->eventRequestForms()->where('status', 'approved')->where('event_type', 'budget_event')->first()->purchaser_amount;
            $requestForm->old_signatures_file_id = $requestForm->signatures_file_id;
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

    public function create_provision(RequestForm $requestForm)
    {
        $requestForm->load('purchasingProcess.details', 'children.purchasingProcess.details');
        // Validar que el formulario req padre esté finalizado.
        if(!$requestForm->purchasingProcess || $requestForm->purchasingProcess->status != 'finalized'){
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
        $newRequestForm->request_user_id = Auth::id();
        $newRequestForm->request_user_ou_id = Auth::user()->organizationalUnit->id;
        $newRequestForm->estimated_expense = 0;
        $newRequestForm->has_increased_expense = null;
        $newRequestForm->subtype = Str::contains($requestForm->subtype, 'bienes') ? 'bienes ejecución inmediata' : 'servicios ejecución inmediata';
        $newRequestForm->sigfe = null;
        $newRequestForm->status = 'pending';
        $newRequestForm->signatures_file_id = null;
        $newRequestForm->old_signatures_file_id = null;
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

        EventRequestform::createLeadershipEvent($newRequestForm);
        EventRequestform::createPreFinanceEvent($newRequestForm);
        EventRequestform::createFinanceEvent($newRequestForm);
        EventRequestform::createSupplyEvent($newRequestForm);

        //Envío de notificación a Adm de Contrato y abastecimiento.
        $mail_contract_manager = User::select('email')
        ->where('id', $newRequestForm->contract_manager_id)
        ->first();

        if($mail_contract_manager){
            $emails = [$mail_contract_manager];
            Mail::to($emails)
                ->cc(env('APP_RF_MAIL'))
                ->send(new NewRequestFormNotification($newRequestForm));
        }
        //---------------------------------------------------------

        //Envío de notificación para visación.
        //manager
        $type = 'manager';
        $mail_notification_ou_manager = Authority::getAuthorityFromDate($newRequestForm->eventRequestForms->first()->ou_signer_user, Carbon::now(), $type);

        $emails = [$mail_notification_ou_manager->user->email];

        if($mail_notification_ou_manager){
            Mail::to($emails)
                ->cc(env('APP_RF_MAIL'))
                ->send(new RequestFormSignNotification($newRequestForm, $newRequestForm->eventRequestForms->first()));
        }
        //---------------------------------------------------------

        session()->flash('info', 'Formulario de requerimiento N° '.$newRequestForm->folio.' fue creado con éxito. <br>
                                  Recuerde que es un formulario dependiente de ID N° '.$requestForm->folio.'. <br>
                                  Se solicita que modifique y guarde los cambios en los items para el nuevo gasto estimado de su formulario de requerimiento.');
        return redirect()->route('request_forms.edit', $newRequestForm);
    }

    public function totalValueWithTaxes($tax, $value)
    {
        // Porcentaje retención boleta de honorarios según el año vigente
        $withholding_tax = [2021 => 0.115, 2022 => 0.1225, 2023 => 0.13, 2024 => 0.1375, 2025 => 0.145, 2026 => 0.1525, 2027 => 0.16, 2028 => 0.17];

        if($tax == 'iva') return $value * 1.19;
        if($tax == 'bh') return isset($withholding_tax[date('Y')]) ? round($value / (1 - $withholding_tax[date('Y')])) : round($value / (1 - end($withholding_tax)));
        return $value;
    }
}
