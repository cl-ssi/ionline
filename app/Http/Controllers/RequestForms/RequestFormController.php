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
use App\Mail\RequestFormDirectorNotification;
use Illuminate\Database\Eloquent\Builder;

use App\User;

class RequestFormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //MIS FORMULARIOS DE REQUERIMIENTO
        //$myRequestForms = RequestForm::where('creator_user_id', auth()->user()->id)->get();
        $myRequestForms = auth()->user()->applicantRequestForms()->where('status', 'created')->get();
        return view('request_form.index', compact('myRequestForms'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$users = User::all()->sortBy('fathers_family');
        //return view('request_form.create', compact('users'));
        //$user = auth()->user();
        //$user = User::find(auth()->user())
        //$user = User::where('id', Auth::user()->id);
        //return  view('request_form.create', compact('user'));
        return  view('request_form.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Display the specified resource.
     *
     * @param  \App\RequestForm  $requestForm
     * @return \Illuminate\Http\Response
     */
    public function show(RequestForm $requestForm)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RequestForm  $requestForm
     * @return \Illuminate\Http\Response
     */
    public function edit(RequestForm $requestForm)
    {
        $users = User::all()->sortBy('fathers_family');
        $item_codes = RequestFormItemCode::all();
        $flag_finance = 0;

        if($requestForm->type_form == 'item'){
          foreach($requestForm->requestformevents as $key => $event){
            if($event->type == 'status' && $event->StatusName == 'Aprobado por jefatura'){
              $flag_finance = 1;
            }
            if($event->type == 'message' && $event->status == 'item_record'){
              $flag_finance = 2;
            }
          }
        return view('request_form.edit', compact('requestForm', 'users', 'item_codes', 'flag_finance'));
        }
        else {
          return view('request_form.edit', compact('requestForm', 'users', 'item_codes', 'flag_finance'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RequestForm  $requestForm
     * @return \Illuminate\Http\Response
     */
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

        // if($requestForm->type_form = 'passage'){
        //     /*Envío de correo al Manage de sistema.*/
        //     Mail::to('jorge.mirandal@redsalud.gob.cl')->send(new RequestFormDirectorNotification($requestForm));
        // }

        $id = $requestForm->id;
        session()->flash('info', 'Su formulario de requrimiento fue ingresado con exito, N°: '.$id);
        return redirect()->route('request_forms.edit', compact('id'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RequestForm  $requestForm
     * @return \Illuminate\Http\Response
     */
    public function destroy(RequestForm $requestForm)
    {
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
