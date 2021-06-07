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
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Mail\RequestFormDirectorNotification;
use Illuminate\Database\Eloquent\Builder;

use App\User;

class RequestFormController extends Controller {

    public function index() {
        $createdRequestForms    = auth()->user()->applicantRequestForms()->where('status', 'created')->get();
        $inProgressRequestForms = auth()->user()->applicantRequestForms()->where('status', 'in_progress')->get();
        $approvedRequestForms   = auth()->user()->applicantRequestForms()->where('status', 'approved')->get();
        $rejectedRequestForms   = auth()->user()->applicantRequestForms()->where('status', 'rejected')->orWhere('status', 'closed')->get();
        $empty = false;
        if(count($rejectedRequestForms) == 0 && count($createdRequestForms) == 0 && count($inProgressRequestForms) == 0 && count($approvedRequestForms) ==  0){
            $empty=true;
            return view('request_form.index', compact('empty'));}
        return view('request_form.index', compact('createdRequestForms', 'inProgressRequestForms', 'rejectedRequestForms','approvedRequestForms', 'empty'));
    }


    public function edit(RequestForm $requestForm) {
        if($requestForm->applicant_user_id != auth()->user()->id){
          session()->flash('danger', 'Formulario de Requerimiento N° '.$requestForm->id.' NO pertenece a Usuario: '.auth()->user()->getFullNameAttribute());
          return redirect()->route('request_forms.index');
        }
        if($requestForm->status != 'created'){
          session()->flash('danger', 'Formulario de Requerimiento N° '.$requestForm->id.' NO puede ser Modificado!');
          return redirect()->route('request_forms.index');
        }
        //Obtiene la Autoridad de la Unidad Organizacional del usuario registrado, en la fecha actual.
        $manager = Authority::getAuthorityFromDate(auth()->user()->organizationalUnit->id, Carbon::now(), 'manager');
        if(is_null($manager))
            $manager= '<h6 class="text-danger">'.auth()->user()->organizationalUnit->name.', no registra una Autoridad.</h6>';
        else
            $manager = $manager->user->getFullNameAttribute();
        $requestForms = RequestForm::all();
        return view('request_form.edit', compact('requestForm', 'manager', 'requestForms'));
    }

    public function leadershipIndex() {
        $ou = Authority::getAmIAuthorityFromOu(Carbon::now(),'manager',auth()->user()->id);
        if(empty($ou)) {
            session()->flash('danger','Usuario: '.auth()->user()->getFullNameAttribute().' no es Autoridad en su U.O. ('.auth()->user()->organizationalUnit->name.')');
            return redirect()->route('request_forms.index');
        } else {
              $createdRequestForms   = RequestForm::where('applicant_ou_id', $ou[0]->organizational_unit_id)->Where('status','created')->get();
              $inProgresRequestForms = RequestForm::where('applicant_ou_id', $ou[0]->organizational_unit_id)->Where('status','in_progress')->get();
              $approvedRequestForms  = RequestForm::where('applicant_ou_id', $ou[0]->organizational_unit_id)->Where('status','approved')->get();
              $rejectedRequestForms  = RequestForm::where('applicant_ou_id', $ou[0]->organizational_unit_id)->Where('status','rejected')
                                                  ->orWhere('status','closed')->get();
        }
        return view('request_form.leadership_index', compact('createdRequestForms', 'inProgresRequestForms', 'approvedRequestForms', 'rejectedRequestForms'));
    }

    public function leadershipSign(RequestForm $requestForm) {
        $manager              = Authority::getAuthorityFromDate($requestForm->organizationalUnit->id, Carbon::now(), 'manager');
        $position             = $manager->position;
        $organizationalUnit   = $manager->organizationalUnit->name;
        if(is_null($manager))
            $manager = 'No se ha registrado una Autoridad en el módulo correspondiente!';
        else
            $manager = $manager->user->getFullNameAttribute();
        $eventType = 'leader_ship_event';
        return view('request_form.leadership_sign', compact('requestForm', 'manager', 'position', 'organizationalUnit', 'eventType'));
    }

    public function prefinanceIndex() {
      if(auth()->user()->organizationalUnit->id != '40' ){
          session()->flash('danger', 'Usuario: '.auth()->user()->getFullNameAttribute().' no pertenece a '.OrganizationalUnit::getName('40').'.');
          return redirect()->route('request_forms.index');
      }else{
          $waitingRequestForms = RequestForm::where('status', 'in_progress')
                                 ->whereHas('eventRequestForms', function ($q) {
                                 $q->where('event_type','leader_ship_event')
                                ->where('status', 'approved');})

                                ->whereDoesntHave('eventRequestForms', function ($f) {
                                $f->where('event_type','pre_finance_event')
                                ->where('status', 'approved');

                                })->get();
          $approvedRequestForms = RequestForm::where('status', 'in_progress')
                                 ->whereHas('eventRequestForms', function ($q) {
                                 $q->where('event_type','pre_finance_event')
                                 ->where('status', 'approved');})->get();
          $rejectedRequestForms    = RequestForm::where('status', 'rejected')->get();

          return view('request_form.prefinance_index', compact('waitingRequestForms', 'rejectedRequestForms', 'approvedRequestForms'));}
    }


    public function prefinanceSign(RequestForm $requestForm) {
      $eventType = 'pre_finance_event';
      return view('request_form.prefinance_sign', compact('requestForm', 'eventType'));
    }


    public function financeIndex(){
        $ou = Authority::getAmIAuthorityFromOu(Carbon::now(), 'manager', auth()->user()->id);
        if(empty($ou)){
            session()->flash('danger','Usuario: '.auth()->user()->getFullNameAttribute().' no es autoridad.');
            return redirect()->route('request_forms.index');
        }elseif($ou[0]->organizational_unit_id != '40' ){
            session()->flash('danger', 'Usuario: '.auth()->user()->getFullNameAttribute().' no pertenece a '.OrganizationalUnit::getName('40').'.');
            return redirect()->route('request_forms.index');
        }else{
            $waitingRequestForms = RequestForm::where('status', 'in_progress')
                                       ->whereHas('eventRequestForms', function ($q) {
                                                    $q->where('event_type','pre_finance_event')
                                                      ->where('status', 'approved');})
                                       ->whereDoesntHave('eventRequestForms', function ($f) {
                                                  $f->where('event_type','finance_event')
                                                  ->where('status', 'approved');

                                                    })->get();
            $rejectedRequestForms    = RequestForm::where('status', 'rejected')->get();
            $createdRequestForms     = RequestForm::all();
            $approvedRequestForms    = RequestForm::where('status', 'in_progress')
                                       ->whereHas('eventRequestForms', function ($q) {
                                                    $q->where('event_type','finance_event')
                                                      ->where('status', 'approved');
                                                    })->get();
            return view('request_form.finance_index', compact('waitingRequestForms', 'rejectedRequestForms', 'approvedRequestForms', 'createdRequestForms'));
          }
    }


    public function financeSign(RequestForm $requestForm){
      $manager              = Authority::getAuthorityFromDate($requestForm->organizationalUnit->id, Carbon::now(), 'manager');
      $position             = $manager->position;
      $organizationalUnit   = $manager->organizationalUnit->name;
      if(is_null($manager))
          $manager = 'No se ha registrado una Autoridad en el módulo correspondiente!';
      else
          $manager = $manager->user->getFullNameAttribute();
      $eventType = 'finance_event';
      return view('request_form.finance_sign', compact('requestForm', 'manager', 'position', 'organizationalUnit', 'eventType'));
    }


    public function supplyIndex()
    {
      $ou = Authority::getAmIAuthorityFromOu(Carbon::now(), 'manager', auth()->user()->id);
      if(empty($ou)){
          session()->flash('danger','Usuario: '.auth()->user()->getFullNameAttribute().' no es autoridad.');
          return redirect()->route('request_forms.index');
      }elseif($ou[0]->organizational_unit_id != '37' ){
          session()->flash('danger', 'Usuario: '.auth()->user()->getFullNameAttribute().' no pertenece a '.OrganizationalUnit::getName('37').'.');
          return redirect()->route('request_forms.index');
      }else{
          $waitingRequestForms = RequestForm::where('status', 'in_progress')
                                     ->whereHas('eventRequestForms', function ($q) {
                                                  $q->where('event_type','finance_event')
                                                    ->where('status', 'approved');})

                                     ->whereDoesntHave('eventRequestForms', function ($f) {
                                                $f->where('event_type','supply_event')
                                                ->where('status', 'approved');

                                                  })->get();

          $rejectedRequestForms    = RequestForm::where('status', 'rejected')->get();

          $approvedRequestForms    = RequestForm::where('status', 'in_progress')
                                     ->whereHas('eventRequestForms', function ($q) {
                                                  $q->where('event_type','supply_event')
                                                    ->where('status', 'approved');
                                                  })->get();

          return view('request_form.supply_index', compact('waitingRequestForms', 'rejectedRequestForms', 'approvedRequestForms'));
    }
  }

    public function supplySign(RequestForm $requestForm){
      $eventType = 'supply_event';
      return view('request_form.supply_sign', compact('requestForm', 'eventType'));
    }


    public function create(){
        $requestForm=null;
        return  view('request_form.create', compact('requestForm'));
    }


    public function destroy(RequestForm $requestForm)
    {
        $id = $requestForm->id;
        RequestForm::find($requestForm)->first()->delete();
        //dd($req);
        session()->flash('info', 'El formulario de requerimiento N°'.$id.' ha sido eliminado correctamente.');
        return redirect()->route('request_forms.index');
        //Implementar Eliminar request form pasado por  argumento.... usar pop.up de confiración...
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






/************************ CODIGO PACHA *************************************/
/************************ CODIGO PACHA *************************************/
/************************ CODIGO PACHA *************************************/

public function show(RequestForm $requestForm)
{
    //
}

    public function store(Request $request)
    {
        $requestForm = new RequestForm($request->All());
        //ASOCIAR ID USUARIO que crea.
        $requestForm->user()->associate(Auth::user());
        //ASOCIAR ID USUARIO admin de contrato.
        $requestForm->admin()->associate($request->admin_id);
        $requestForm->save();

        //AGREGAR EVENTO DE INGRESA QUIEN SOLICITA.
        $event = new RequestFormEvent();
        $event->comment = 'Estimado/a,
                           Su requerimiento ha sido correctamente creado por el usuario que registra.';
        $event->type = 'message';
        $event->status = 'create';
        $event->request_form()->associate($requestForm->id);
        $event->user()->associate(Auth::user());
        $event->save();

        $id = $requestForm->id;
        session()->flash('info', 'Su formulario de requrimiento fue ingresado con exito, N°: '.$id);
        return redirect()->route('request_forms.edit', compact('requestForm'));
    }


    public function update(Request $request, RequestForm $requestForm)
    {
        //ASIGNAR UO DE QUIEN SOLICITA.
        $user = User::find($request->whorequest_id);
        $uo = $user->organizationalUnit;
        $requestForm->whorequest()->associate($request->whorequest_id);
        $requestForm->whorequest_unit()->associate($uo->id);
        $requestForm->whorequest_position=$user->position." ".$user->OrganizationalUnit->name;
        //$requestForm->status = 'new';

        $user_unit = $user->organizationalUnit;

        $authorities = Authority::getAmIAuthorityFromOu(Carbon::today(), 'manager', $user->id);
        //dd($authorities);
        if($authorities == null){
            $requestForm->whoauthorize_unit()->associate($user_unit->id);
            //AGREGAR EVENTO DE INGRESA QUIEN SOLICITA.
            $event = new RequestFormEvent();
            $event->comment = 'Estimado/a,
                               Su requerimiento ha sido correctamente solicitado';
            $event->type = 'status';
            $event->status = 'new';
            $event->request_form()->associate($requestForm->id);
            $event->user()->associate(Auth::user());

            $requestForm->update($request->all());
            $event->save();
        }
        else{
            foreach ($authorities as $key => $authority) {
                //SI SOY JEFATURA Y  NO DEPENDO DEL DIR.
                if($authority->organizational_unit_id == $user->organizationalUnit->id && $authority->organizationalUnit->organizational_unit_id != 1){
                    $requestForm->whoauthorize_unit()->associate($authority->organizationalUnit->organizational_unit_id);
                    $requestForm->whorequest_position=$authority->position." ".$authority->OrganizationalUnit->name;
                    //AGREGAR EVENTO DE INGRESA QUIEN SOLICITA.
                    $event = new RequestFormEvent();
                    $event->comment = 'Estimado/a,
                                       Su requerimiento ha sido correctamente solicitado';
                    $event->type = 'status';
                    $event->status = 'new';
                    $event->request_form()->associate($requestForm->id);
                    $event->user()->associate(Auth::user());

                    $requestForm->update($request->all());
                    $event->save();
                }
                //SI SOY JEFATURA Y DEPENDO DEL DIR -> SOLO AUTORIZA SOLICITANTE.
                if($authority->organizational_unit_id == $user->organizationalUnit->id && $authority->organizationalUnit->organizational_unit_id  == 1){
                    $requestForm->whoauthorize_unit()->associate($authority->organizational_unit_id);
                    $requestForm->whorequest_position=$authority->position." ".$authority->OrganizationalUnit->name;
                    //AGREGAR EVENTO DE INGRESA QUIEN SOLICITA.
                    $event = new RequestFormEvent();
                    $event->comment = 'Estimado/a,
                                       Su requerimiento ha sido correctamente solicitado';
                    $event->type = 'status';
                    $event->status = 'new';
                    $event->request_form()->associate($requestForm->id);
                    $event->user()->associate(Auth::user());
                    $event->save();

                    //AGREGAR EVENTO DE INGRESA QUIEN SOLICITA.
                    $event2 = new RequestFormEvent();
                    $event2->comment = 'Estimado/a,
                                       Su requerimiento ha sido correctamente solicitado';
                    $event2->type = 'status';
                    $event2->status = 'approved_petitioner';
                    $event2->request_form()->associate($requestForm->id);
                    $event2->user()->associate(Auth::user());

                    $requestForm->update($request->all());
                    $event2->save();
                }
            }
        }
        $id = $requestForm->id;
        session()->flash('info', 'Su formulario de requrimiento fue ingresado con exito, N°: '.$id);
        return redirect()->route('request_forms.edit', compact('id'));
    }


    public function myRequestInbox()
    {
        $myRequestForms = RequestForm::with(['items','passages', 'requestformfiles', 'requestformevents'])
            ->where('whorequest_id', Auth::user()->id)->get();
        //dd($myRequestForms);

        $pending = array();
        foreach($myRequestForms as $myRequestForm){
          foreach($myRequestForm->requestformevents as $key => $event){
            if($event->type == 'message' && $event->status == 'create' ||
              $event->type == 'status' && $event->StatusName == 'Nuevo'){
              $pending[$key] = $event->request_form_id;
            }
          }
        }
        $pending_rfs = array_unique($pending);
        //dd($pending_rfs);

        $authorize = array();
        foreach($myRequestForms as $myRequestForm){
          foreach($myRequestForm->requestformevents as $key => $event){
            if($event->type == 'status' && $event->StatusName == 'Aprobado por solicitante'){
              $authorize[$key] = $event->request_form_id;
            }
          }
        }

        $authorize_rfs = array_unique($authorize);
        //dd($authorize_rfs);

        return view('request_form.my_request_inbox', compact('myRequestForms', 'pending_rfs'));
    }

    public function storeApprovedRequest(Request $request, RequestForm $requestForm)
    {
        //AGREGAR EVENTO DE INGRESA QUIEN SOLICITA.
        $event = new RequestFormEvent();
        $event->comment = 'Estimado/a,
                           Su formulario de requerimiento ha sido aprobado por el solicitante.';
        $event->type = 'status';
        $event->status = 'approved_petitioner';
        $event->request_form()->associate($requestForm->id);
        $event->user()->associate(Auth::user());

        $requestForm->update($request->all());
        $event->save();

        $id=$requestForm->id;
        session()->flash('info', 'Su solicitud de formulario de requerimiento fue aprobado con exito, N°: '.$id);
        return redirect()->route('request_forms.edit', compact('id'));
    }


    public function directorPassageInbox()
    {
        $rfs = RequestForm::with(['items','passages', 'requestformfiles', 'requestformevents'])->
            where('status', 'new')->
            where('type_form', 'passage')->get();
        return view('request_form.director_inbox', compact('rfs'));
    }

    public function authorizeInbox()
    {
        $authorities = Authority::getAmIAuthorityFromOu(Carbon::today(), 'manager', Auth::user()->id);

        $label = array();
        foreach ($authorities as $key => $authority) {
          $label['uo_id'] = $authority->organizational_unit_id;
        }

        $myRequestForms = RequestForm::with(['items','passages', 'requestformfiles', 'requestformevents'])
            ->whereIn('whoauthorize_unit_id', $label)->get();

        return view('request_form.authorize_inbox', compact('myRequestForms'));
    }

    public function storeApprovedChief(Request $request, RequestForm $requestForm)
    {
        //AGREGAR EVENTO DE INGRESA QUIEN SOLICITA.
        $event = new RequestFormEvent();
        $event->comment = 'Estimado/a,
                           Se formulario requerimiento ha sido aprobado por la jefatura.';
        $event->type = 'status';
        $event->status = 'approved_chief';
        $event->request_form()->associate($requestForm->id);
        $event->user()->associate(Auth::user());

        $requestForm->whoauthorize()->associate(Auth::user());

        $authorities = Authority::getAmIAuthorityFromOu(Carbon::today(), 'manager', Auth::user()->id);
        foreach ($authorities as $key => $authority) {
            $chief_position = $authority->position." ".$authority->OrganizationalUnit->name;
        }

        $requestForm->whoauthorize_position = $chief_position;
        $requestForm->update($request->all());
        $event->save();

        $id=$requestForm->id;
        session()->flash('info', 'Su solicitud de formulario de requerimiento fue aprobado con exito, N°: '.$id);
        return redirect()->route('request_forms.edit', compact('id'));
    }

    public function financeInbox()
    {
        $myRequestForms = RequestForm::with(['items','passages', 'requestformfiles', 'requestformevents'])->
            whereHas('requestformevents', function (Builder $query) {
              $query->where('status', 'approved_chief');
            })->get();

        return view('request_form.finance_inbox', compact('myRequestForms'));
    }

    public function storeApprovedFinance(Request $request, RequestForm $requestForm)
    {
        //$requestForm->status = 'approved_finance';
        $requestForm->whoauthorize_finance()->associate(Auth::user());

        $authorities = Authority::getAmIAuthorityFromOu(Carbon::today(), 'manager', Auth::user()->id);
        foreach ($authorities as $key => $authority) {
            $finance_position = $authority->position." ".$authority->OrganizationalUnit->name;
        }
        $requestForm->finance_position = $finance_position;

        //AGREGAR EVENTO DE INGRESA QUIEN SOLICITA.
        $event = new RequestFormEvent();
        $event->comment = 'Estimado/a,
                           Se formulario requerimiento ha sido aprobado por: '. $finance_position. '.';
        $event->type = 'status';
        $event->status = 'approved_finance';
        $event->request_form()->associate($requestForm->id);
        $event->user()->associate(Auth::user());
        $requestForm->update($request->all());
        $event->save();

        $id=$requestForm->id;
        session()->flash('info', 'Su solicitud de formulario de requerimiento fue aprobado con exito, N°: '.$id);
        return redirect()->route('request_forms.edit', compact('id'));
    }

    public function addItemForm(Request $request, RequestForm $requestForm)
    {
        //AGREGAR EVENTO DE INGRESA QUIEN SOLICITA.
        $event = new RequestFormEvent();
        $event->comment = 'Estimado/a,
            Se ha agregado al formulario requerimiento el Item Presupuestario.';
        $event->type = 'message';
        $event->status = 'item_record';
        $event->request_form()->associate($requestForm->id);
        $event->user()->associate(Auth::user());

        foreach ($request->ids as $key => $id) {
            $item = Item::find($id);
            $item->request_form_item_codes_id = $request->request_form_items_code_ids[$key];
            $item->save();
        }
        $event->save();

        $idf=$requestForm->id;
        session()->flash('info', 'Su información fue agregado con exito formulario de requerimiento, N°: '.$idf);
        //return back();
        return redirect()->route('request_forms.edit', compact('idf'));
    }

    public function storeFinanceData(Request $request, RequestForm $requestForm)
    {
          //AGREGAR EVENTO DE INGRESA QUIEN SOLICITA.
          $event = new RequestFormEvent();
          $event->comment = 'Estimado/a,
                              Se ha agregado al formulario requerimiento el Certificado Refrendación Presupuestaria.';
          $event->type = 'message';
          $event->status = 'crp_record';
          $event->request_form()->associate($requestForm->id);
          $event->user()->associate(Auth::user());

          $requestForm->finance_unit_id=40;
          $requestForm->finance_program=$request->finance_program;
          $requestForm->folio_sigfe=$request->folio_sigfe;
          $requestForm->folio_sigfe_id_oc=$request->folio_sigfe_id_oc;
          $requestForm->finance_expense=$request->finance_expense;
          $requestForm->available_balance=$request->available_balance;
          $requestForm->program_balance=$request->program_balance;
          $requestForm->update();
          $event->save();

          $id=$requestForm->id;
          session()->flash('info', 'Su información fue agregado con exito formulario de requerimiento, N°: '.$id);
          return redirect()->route('request_forms.edit', compact('id'));
    }

    public function storeReject(Request $request, RequestForm $requestForm)
    {
          //AGREGAR EVENTO DE INGRESA QUIEN SOLICITA.
          $event = new RequestFormEvent();
          $event->comment = $request->comment;
          $event->type = 'status';
          $event->status = 'reject';
          $event->request_form()->associate($requestForm->id);
          $event->user()->associate(Auth::user());

          $requestForm->whoauthorize_finance()->associate(Auth::user());

          $authorities = Authority::getAmIAuthorityFromOu(Carbon::today(), 'manager', Auth::user()->id);
          foreach ($authorities as $key => $authority) {
              $finance_position = $authority->position." ".$authority->OrganizationalUnit->name;
          }
          $requestForm->finance_position = $finance_position;

          $requestForm->update();
          $event->save();

          $id=$requestForm->id;
          session()->flash('info', 'Su información fue agregado con exito formulario de requerimiento, N°: '.$id);
          return redirect()->route('request_forms.edit', compact('id'));
    }

    public function record(RequestForm $requestForm)
    {
        return view('request_form.record', compact('requestForm'));
    }
}
