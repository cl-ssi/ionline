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
use App\Models\Documents\SignaturesFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Mail\RequestFormDirectorNotification;
use App\Models\RequestForms\EventRequestForm;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\File;
use PDF;
use Illuminate\Support\Facades\Storage;

use App\User;

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

        $my_pending_requests = RequestForm::with('eventRequestForms', 'user', 'userOrganizationalUnit', 'purchaseMechanism')
            ->where('request_user_id', Auth::user()->id)
            ->where('status', 'pending')
            ->orderBy('id', 'DESC')
            ->get();

        $my_requests = RequestForm::with('eventRequestForms', 'user', 'userOrganizationalUnit', 'purchaseMechanism')
            ->where('request_user_id', Auth::user()->id)
            ->whereIn('status', ['approved', 'rejected'])
            ->orderBy('id', 'DESC')
            ->get();

        return view('request_form.my_forms', compact('my_requests', 'my_pending_requests'));
    }

    public function get_event_type_user()
    {
        $manager = Authority::getAuthorityFromDate(Auth::user()->organizationalUnit->id, Carbon::now(), 'manager');
        // return $manager;

        //superchief?
        $result = RequestForm::whereHas('eventRequestForms', function($q){
            return $q->where('ou_signer_user', Auth::user()->organizationalUnit->id)->where('event_type', 'superior_leader_ship_event');
        })->count();

        // Permisos
        if($result > 0 && $manager->user_id == Auth::user()->id) $event_type = 'superior_leader_ship_event';
        elseif(!in_array(Auth::user()->organizationalUnit->id, [37, 40]) && $manager->user_id == Auth::user()->id) $event_type = 'leader_ship_event';
        elseif(Auth::user()->organizationalUnit->id == 40 && $manager->user_id != Auth::user()->id) $event_type = 'pre_finance_event';
        elseif(Auth::user()->organizationalUnit->id == 40 && $manager->user_id == Auth::user()->id) $event_type = 'finance_event';
        elseif(Auth::user()->organizationalUnit->id == 37 && $manager->user_id == Auth::user()->id) $event_type = 'supply_event';
        else $event_type = null;

        return $event_type;
    }

    public function pending_forms()
    {
        $my_pending_forms_to_signs = $approved_forms_pending_to_sign = $new_budget_pending_to_sign = $my_forms_signed = collect();

        $event_type = $this->get_event_type_user();

        if($event_type){
            $prev_event_type = $event_type == 'supply_event' ? 'finance_event' : ($event_type == 'finance_event' ? 'pre_finance_event' : ($event_type == 'pre_finance_event' ? ['superior_leader_ship_event', 'leader_ship_event'] : ($event_type == 'superior_leader_ship_event' ? 'leader_ship_event' : null)));
            // return $prev_event_type;
            $my_pending_forms_to_signs = RequestForm::where('status', 'pending')
                                                    ->whereHas('eventRequestForms', function($q) use ($event_type){
                                                        return $q->where('status', 'pending')->where('ou_signer_user', Auth::user()->organizationalUnit->id)->where('event_type', $event_type);
                                                    })->when($prev_event_type, function($q) use ($prev_event_type) {
                                                        return $q->whereDoesntHave('eventRequestForms', function ($f) use ($prev_event_type) {
                                                            return is_array($prev_event_type) ? $f->whereIn('event_type', $prev_event_type)->where('status', 'pending') : $f->where('event_type', $prev_event_type)->where('status', 'pending');
                                                        });
                                                    })->get();
        }

        if($event_type == 'finance_event'){
            $new_budget_pending_to_sign = RequestForm::where('status', 'approved')
                                                    ->whereHas('eventRequestForms', function($q){
                                                        return $q->where('status', 'pending')->where('ou_signer_user', Auth::user()->organizationalUnit->id)->where('event_type', 'budget_event');
                                                    })->get();

            $approved_forms_pending_to_sign = RequestForm::where('status', 'approved')->whereNull('signatures_file_id')->get();
        }

        $my_forms_signed = RequestForm::whereHas('eventRequestForms', $filter = function($q){
                                        return $q->where('signer_user_id', Auth::user()->id);
                                    })->get();

        return view('request_form.pending_forms', compact('my_pending_forms_to_signs', 'approved_forms_pending_to_sign', 'new_budget_pending_to_sign', 'my_forms_signed', 'event_type'));
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
        return  view('request_form.create', compact('requestForm'));
    }

    public function sign(RequestForm $requestForm, $eventType)
    {
        $eventTitles = ['superior_leader_ship_event' => 'Dirección', 'leader_ship_event' => 'Jefatura', 'pre_finance_event' => 'Refrendación Presupuestaria', 'finance_event' => 'Finanzas', 'supply_event' => 'Abastecimiento', 'budget_event' => 'Nuevo presupuesto'];

        $event_type_user = $this->get_event_type_user();
        if($event_type_user != $eventType){
            session()->flash('danger', 'Estimado Usuario/a: Ud. no tiene los permisos para la autorización como '.$eventTitles[$eventType].'.');
            return redirect()->route('request_forms.my_forms');
        }

        $requestForm->load('itemRequestForms');

        $title = 'Formularios de Requerimiento - Autorización ' . $eventTitles[$eventType];
        $manager              = Authority::getAuthorityFromDate($requestForm->userOrganizationalUnit->id, Carbon::now(), 'manager');
        $position             = $manager->position;
        $organizationalUnit   = $manager->organizationalUnit->name;
        if(is_null($manager))
            $manager = 'No se ha registrado una Autoridad en el módulo correspondiente!';
        else
            $manager = $manager->user->getFullNameAttribute();
        return view('request_form.sign', compact('requestForm', 'manager', 'position', 'organizationalUnit', 'eventType', 'title'));
    }

    public function create_new_budget(Request $request, RequestForm $requestForm)
    {
        $requestForm->newBudget = $request->newBudget;
        EventRequestForm::createNewBudgetEvent($requestForm);
        session()->flash('info', 'Se ha solicitado un nuevo presupuesto pendiente de su aprobación, mientras no tenga respuesta de esta solicitud no podrá registrar nuevas compras.');
        return redirect()->route('request_forms.supply.index');
    }

    public function create_form_document(RequestForm $requestForm){
        //dd($requestForm);

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('request_form.documents.form_document', compact('requestForm'));

        return $pdf->stream('mi-archivo.pdf');

        // $formDocumentFile = PDF::loadView('request_form.documents.form_document', compact('requestForm'));
        // return $formDocumentFile->download('pdf_file.pdf');
    }

    public function create(){
        $requestForm=null;
        return  view('request_form.create', compact('requestForm'));
    }


    public function destroy(RequestForm $requestForm)
    {
        $id = $requestForm->id;
        $requestForm->delete();
        session()->flash('info', 'El formulario de requerimiento ID '.$id.' ha sido eliminado correctamente.');
        return redirect()->route('request_forms.my_forms');
    }


    public function supervisorUserIndex()
    {
        if(auth()->user()->organizationalUnit->id != '37' ){
            session()->flash('danger', 'Usuario: '.auth()->user()->getFullNameAttribute().' no pertenece a '.OrganizationalUnit::getName('37').'.');
            return redirect()->route('request_forms.index');
        }else
          {
            $waitingRequestForms = RequestForm::where('status', 'in_progress')
                                   ->where('supervisor_user_id', auth()->user()->id)
                                   ->whereHas('eventRequestForms', function ($q) {
                                   $q->where('event_type','supply_event')
                                  ->where('status', 'approved');})
                                  ->get();
            $rejectedRequestForms    = RequestForm::where('status', 'rejected')->get();
            return view('request_form.supervisor_user_index', compact('waitingRequestForms', 'rejectedRequestForms'));
          }
    }

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
        $requestForm = RequestForm::find($modelId);

        if (!$signaturesFile) {
            session()->flash('danger', $message);
            return redirect()->route('request_forms.pending_forms');
        }
        $requestForm->signatures_file_id = $signaturesFile->id;
        $requestForm->save();
        session()->flash('success', $message);
        return redirect()->route('request_forms.pending_forms');
    }

    public function signedRequestFormPDF(RequestForm $requestForm)
    {
      return Storage::disk('gcs')->response($requestForm->signedRequestForm->signed_file);
    }

    public function create_provision(RequestForm $requestForm)
    {
        $requestForm->load('itemRequestForms');
        $newRequestForm = $requestForm->replicate();
        $newRequestForm->request_form_id = $requestForm->id;
        $newRequestForm->request_user_id = Auth::id();
        $newRequestForm->request_user_ou_id = Auth::user()->organizationalUnit->id;
        $newRequestForm->estimated_expense = 0;
        $newRequestForm->subtype = 'suministros';
        $newRequestForm->sigfe = null;
        $newRequestForm->status = 'pending';
        $newRequestForm->signatures_file_id = null;
        $newRequestForm->push();

        $total = 0;
        foreach($requestForm->getRelations() as $relation => $items){
            foreach($items as $item){
                unset($item->id);
                $item->request_form_id = $newRequestForm->id;
                $item->quantity = 1;
                $item->expense = $this->totalValueWithTaxes($item->tax, $item->unit_value);
                $total += $item->expense;
                $newRequestForm->{$relation}()->create($item->toArray());
            }
        }

        $newRequestForm->update(['estimated_expense' => $total]);

        EventRequestform::createLeadershipEvent($newRequestForm);
        EventRequestform::createPreFinanceEvent($newRequestForm);
        EventRequestform::createFinanceEvent($newRequestForm);
        EventRequestform::createSupplyEvent($newRequestForm);

        session()->flash('info', 'Formulario de requerimiento N° '.$newRequestForm->id.' fue creado con éxito. <br>
                                  Recuerde que es un formulario dependiente de ID N° '.$requestForm->id.'. <br>
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
