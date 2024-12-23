<?php

namespace App\Livewire\RequestForm;

use Livewire\Component;
use App\Models\RequestForms\RequestForm;
use App\Models\RequestForms\EventRequestForm;
use App\Models\RequestForms\PurchasingProcess;
use App\Models\Parameters\PurchaseUnit;
use App\Models\Parameters\PurchaseType;
use App\Models\Parameters\PurchaseMechanism;
use App\Models\Rrhh\Authority;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\RequestFormSignNotification;
use App\Mail\RfEndNewBudgetSignNotification;
use App\Mail\RfEndSignNotification;
use App\Models\Parameters\Parameter;
use App\Models\Parameters\Program;
use App\Models\RequestForms\OldSignatureFile;
use App\Models\RequestForms\RequestFormFile;
use App\Models\Rrhh\OrganizationalUnit;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;

class Authorization extends Component
{
    use WithFileUploads;

    public $organizationalUnit, $userAuthority, $position, $requestForm, $eventType, $comment, $program, $program_id, $lstProgram;
    public $lstSupervisorUser, $supervisorUser, $title, $route, $sigfe, $financial_type;
    public $purchaseUnit, $purchaseType, $lstPurchaseType, $lstPurchaseUnit, $lstPurchaseMechanism, $purchaseMechanism;
    public $estimated_expense, $new_estimated_expense, $purchaser_observation, $files, $docSigned;

    protected $rules = [
        'comment' => 'required|min:6',
    ];

    protected $messages = [
        'comment.required'  => 'Debe ingresar un comentario antes de rechazar Formulario.',
        'comment.min'       => 'Mínimo 6 caracteres.',
    ];

    public function mount(RequestForm $requestForm, $eventType) {
      $this->route = 'request_forms.pending_forms';
      $this->eventType          = $eventType;
      $this->requestForm        = $requestForm;
      $this->comment            = '';
      $this->program            = $requestForm->program;
      $this->program_id         = $requestForm->program_id;
      
      $authorities = Authority::getAmIAuthorityFromOu(now(), 'manager', Auth::id());

      // dd($authorities);
      
      foreach ($authorities as $authority){
        $iam_authorities_in[] = $authority->organizational_unit_id;
      }
      
      $this->organizationalUnit = $this->requestForm->eventRequestForms->where('status', 'pending')->whereNull('deleted_at')->first()->signerOrganizationalUnit->name;
      
      $this->userAuthority      = auth()->user()->fullName;
      if(!empty($iam_authorities_in)){
        $this->position = $this->requestForm->eventRequestForms->where('status', 'pending')->whereNull('deleted_at')->first()->signerOrganizationalUnit->currentManager->position ?? auth()->user()->position;
      }
      else{
        $this->position = auth()->user()->position;
      }
      
      if($eventType=='supply_event'){
        // $ouSearch = Parameter::where('module', 'ou')->whereIn('parameter', ['AbastecimientoSSI', 'AdquisicionesHAH'])->pluck('value')->toArray();
        $estab_hetg = Parameter::get('establishment', 'HETG');
        if($this->requestForm->contractManager->organizationalUnit->establishment_id == $estab_hetg){
          $ouSearch = Parameter::get('Abastecimiento','purchaser_ou_id', $estab_hetg);
          $this->lstSupervisorUser = User::permission('Request Forms: purchaser')->whereHas('organizationalUnit', fn($q) => $q->where('establishment_id', $estab_hetg))->OrWhere('organizational_unit_id', $ouSearch)->orderBy('name','asc')->get();
        }else{
          $estab_others = Parameter::get('establishment', ['SSTarapaca', 'HospitalAltoHospicio']);
          $ouSearch = Parameter::get('Abastecimiento','purchaser_ou_id', $estab_others);
          $this->lstSupervisorUser = User::permission('Request Forms: purchaser')->whereHas('organizationalUnit', fn($q) => $q->whereIn('establishment_id', $estab_others))->OrWhereIn('organizational_unit_id', $ouSearch)->orderBy('name','asc')->get();
        }
        //$this->lstPurchaseType        = PurchaseType::all();
        $this->purchaseMechanism      = $requestForm->purchase_mechanism_id;
        $this->lstPurchaseType        = PurchaseMechanism::find($this->purchaseMechanism)->purchaseTypes()->get();
        $this->lstPurchaseUnit        = PurchaseUnit::all();
        $this->lstPurchaseMechanism   = PurchaseMechanism::all();
        $this->title = 'Autorización Abastecimiento';
      }elseif($eventType=='finance_event'){
        $this->title = 'Autorización Finanzas';
        $estab_hetg = Parameter::get('establishment', 'HETG');
        $this->lstProgram = Program::with('Subtitle')->where('establishment_id', auth()->user()->establishment_id == $estab_hetg ? $estab_hetg : NULL)->orderBy('alias_finance')->get();
        // if(auth()->user()->establishment_id == $estab_hetg){
        //   $this->lstProgram = Program::with('Subtitle')->where('establishment_id', $estab_hetg)->orderBy('alias_finance')->get();
        // }else{
        //   $this->lstProgram = Program::with('Subtitle')->orderBy('alias_finance')->get();
        // }
        $this->sigfe = $requestForm->associateProgram ? $requestForm->associateProgram->folio : $requestForm->sigfe;
        $this->financial_type = $requestForm->associateProgram->financing ?? '';
      }elseif($eventType=='leader_ship_event'){
          $this->title = 'Autorización Jefatura';
      }elseif($eventType=='superior_leader_ship_event'){
          $this->title = 'Autorización Dirección';
      }elseif(in_array($eventType, ['pre_budget_event', 'pre_finance_budget_event', 'budget_event'])){
          $this->title = 'Autorización nuevo presupuesto';
          $this->estimated_expense = $requestForm->symbol_currency.number_format($requestForm->estimated_expense, $requestForm->precision_currency, ',', '.');
          $this->new_estimated_expense = $requestForm->symbol_currency.number_format($requestForm->new_estimated_expense, $requestForm->precision_currency, ',', '.');
          $this->purchaser_observation = $requestForm->firstPendingEvent()->purchaser_observation;
          $this->files = $this->requestForm->firstPendingEvent()->files;
      }
    }

    private function createPurchasingProcesses(){
      foreach($this->requestForm->itemRequestForms as $item){
        $purchasingProcess = new PurchasingProcess([
          'status'                  =>        'in_progress',
          'purchase_mechanism_id'   =>        $this->purchaseMechanism,
          'purchase_type_id'        =>        $this->purchaseType,
          'purchase_unit_id'        =>        $this->purchaseUnit,
        ]);
        $item->purchasingProcesses()->save($purchasingProcess);
      }
    }

    public function changePurchaseMechanism(){
      if($this->purchaseMechanism != "")
        $this->lstPurchaseType = PurchaseMechanism::find($this->purchaseMechanism)->purchaseTypes()->get();
      $this->purchaseType = "";
    }

    public function resetError(){
      $this->resetErrorBag();
    }

    public function updatedProgram($value){
        $this->requestForm->update(['program' => $value]);
    }

    public function updatedProgramId($value){
      $this->sigfe = $this->financial_type = null;
      if($value){
        $programTemp = $this->lstProgram->where('id', $value)->first();
        $this->sigfe = $programTemp->folio;
        $this->financial_type = $programTemp->financing;
        $this->requestForm->update(['program_id' => $value]);
      }
    }

    public function acceptRequestForm()
    {
      if($this->eventType=='supply_event'){
        $this->validate(
          [ 'supervisorUser'    =>  'required',
            'purchaseUnit'      =>  'required',
            'purchaseType'      =>  'required',
            'purchaseMechanism' =>  'required',
         ],
          [ 'supervisorUser.required'     =>  'Seleccione Usuario.',
            'purchaseUnit.required'       =>  'Seleccione U. de compra.',
            'purchaseType.required'       =>  'Seleccione T. de compra.',
            'purchaseMechanism.required'  =>  'Seleccione M. de compra.',
         ]
        );
        // $this->requestForm->supervisor_user_id      =  $this->supervisorUser;
        $this->requestForm->purchase_unit_id        =  $this->purchaseUnit;
        $this->requestForm->purchase_type_id        =  $this->purchaseType;
        $this->requestForm->purchase_mechanism_id   =  $this->purchaseMechanism;
        $this->requestForm->purchasers()->attach($this->supervisorUser);
        $this->requestForm->approved_at = now();
        $this->requestForm->status = 'approved';
        $this->requestForm->save();
        // $this->createPurchasingProcesses();
      }

      if($this->eventType=='budget_event'){
        $this->requestForm->update(['estimated_expense' => $this->purchaser_amount]);
      }

      $event = $this->requestForm->eventRequestForms()->where('event_type', $this->eventType)->where('status', 'pending')->first();
      if(!is_null($event)){
          $event->signature_date = Carbon::now();
          //$amIAuthorityFromOu = Authority::getAmIAuthorityFromOu(Carbon::now(), 'manager', auth()->id());
          $event->position_signer_user = $this->position;
          $event->status  = 'approved';
          $event->comment = $this->comment;
          $event->signerUser()->associate(auth()->user());
          $event->save();

          // if($event->isLast()) $this->requestForm->update(['approved_at', now()]);

          $nextEvent = $event->requestForm->eventRequestForms->where('cardinal_number', $event->cardinal_number + 1);

          if(!$nextEvent->isEmpty()){
              //Envío de notificación para visación.
              $now = Carbon::now();
              //manager
              $type = 'manager';
              $mail_notification_ou_manager = Authority::getAuthorityFromDate($nextEvent->first()->ou_signer_user, Carbon::now(), $type);

              //secretary
              // $type_adm = 'secretary';
              // $mail_notification_ou_secretary = Authority::getAuthorityFromDate($nextEvent->first()->ou_signer_user, Carbon::now(), $type_adm);

              
              if($mail_notification_ou_manager){
                $emails = [$mail_notification_ou_manager->user->email];
                if($nextEvent->first()->event_type == 'pre_finance_event'){
                  Mail::to($emails)
                    ->cc([env('APP_RF_MAIL'), 'yazmin.galleguillos@redsalud.gob.cl'])
                    ->send(new RequestFormSignNotification($event->requestForm, $nextEvent->first()));
                }
                // elseif($nextEvent->event_type = 'supply_event'){
                //   Mail::to($mail_notification_ou_manager)
                //     ->cc(env('APP_RF_MAIL'))
                //     ->send(new RequestFormSignNotification($event->requestForm, $nextEvent->first()));
                // }
                else{
                  Mail::to($emails)
                    ->cc(env('APP_RF_MAIL'))
                    ->send(new RequestFormSignNotification($event->requestForm, $nextEvent->first()));
                }
              }
          }
          else{
              if($event->event_type == 'supply_event'){
                  $this->requestForm->load('purchasers');
                  $emails = [$this->requestForm->user->email,
                      $this->requestForm->contractManager->email,
                      $this->requestForm->purchasers->first()->email
                  ];
                  Mail::to($emails)
                    ->cc(env('APP_RF_MAIL'))
                    ->send(new RfEndSignNotification($event->requestForm));
              }
          }
          session()->flash('info', 'Formulario de Requerimientos Nro.'.$this->requestForm->folio.' AUTORIZADO correctamente!');
          return redirect()->route($this->route);
      }
      session()->flash('danger', 'Formulario de Requerimientos Nro.'.$this->requestForm->folio.' NO se puede Autorizar!');
      return redirect()->route($this->route);
    }

    public function acceptRequestFormByFinance()
    {
      $this->validate(
        [ 'docSigned' => 'required|mimes:pdf'], [ 'docSigned.required' => 'Seleccione archivo PDF.' ]
      );

      if($this->eventType == 'budget_event'){ // Form. solicitud aumento de presupuesto
        $this->requestForm->load('eventRequestForms', 'itemRequestForms.latestPendingItemChangedRequestForms', 'passengers.latestPendingPassengerChanged');
        // Modificar items
        if($this->requestForm->itemRequestForms){
          foreach($this->requestForm->itemRequestForms as $item){
            if($item->latestPendingItemChangedRequestForms){
                $fieldsToChange = array_filter($item->latestPendingItemChangedRequestForms->only(['quantity', 'unit_value', 'specification', 'tax', 'expense']));
                $item->update($fieldsToChange);
                $item->latestPendingItemChangedRequestForms->update(['status' => 'approved']);
            }
          }
        }
        //Modificar pasajeros
        if($this->requestForm->passengers){
          foreach($this->requestForm->passengers as $passenger){
            if($passenger->latestPendingPassengerChanged){
                $fieldsToChange = array_filter($passenger->latestPendingPassengerChanged->only(['unit_value']));
                $passenger->update($fieldsToChange);
                $passenger->latestPendingPassengerChanged->update(['status' => 'approved']);
            }
          }
        }

        //ACTUALIZAO EVENTO DE FINANZAS
        $event = $this->requestForm->eventRequestForms->where('event_type', 'budget_event')->where('status', 'pending')->first();
        $event->update([
          'signature_date'       => Carbon::now(),
          'position_signer_user' => $this->position,
          'status'               => 'approved',
          'signer_user_id'       => auth()->id(),
          'comment'              => $this->comment
        ]);

        $oldSignatureFile = new OldSignatureFile();
        $oldSignatureFile->request_form_id = $this->requestForm->id;
        $oldSignatureFile->old_signature_file_id = $this->requestForm->signatures_file_id;
        $oldSignatureFile->save();

        $this->requestForm->has_increased_expense = true;
        $this->requestForm->estimated_expense = $this->requestForm->estimated_expense + $event->purchaser_amount;
        // $requestForm->old_signatures_file_id = $requestForm->signatures_file_id;
        $this->requestForm->signatures_file_id = 11;
        $this->requestForm->save();

        //Subir al storage archivo pdf con firmas a mano
        $reqFile = new RequestFormFile();
        $file_name = Carbon::now()->format('Y_m_d_H_i_s')."_FR_".$this->requestForm->folio;
        $reqFile->name = $file_name;
        $reqFile->file = $this->docSigned->storeAs('/ionline/request_forms/request_files', $file_name.'.'.$this->docSigned->extension(), 'gcs');
        $reqFile->request_form_id = $this->requestForm->id;
        $reqFile->user_id = auth()->user()->id;
        $reqFile->save();

        $emails = [$this->requestForm->user->email,
                  $this->requestForm->contractManager->email,
                  $this->requestForm->eventPurchaserNewBudget()->email
              ];

        Mail::to($emails)
        ->cc(env('APP_RF_MAIL'))
        ->send(new RfEndNewBudgetSignNotification($this->requestForm));

        session()->flash('info', 'Formulario de Requerimientos Nro.'.$this->requestForm->folio.' AUTORIZADO correctamente!');
        return redirect()->route($this->route);
        
      }else{ // Form. normal
        $event = $this->requestForm->eventRequestForms()->where('event_type', 'finance_event')->where('status', 'pending')->first();
        if(!is_null($event)){
          $event->signature_date = Carbon::now();
          $event->position_signer_user = $this->position;
          $event->status  = 'approved';
          $event->comment = $this->comment;
          $event->signerUser()->associate(auth()->user());
          $event->save();

          //Subir al storage archivo pdf con firmas a mano
          $reqFile = new RequestFormFile();
          $file_name = Carbon::now()->format('Y_m_d_H_i_s')."_FR_".$this->requestForm->folio;
          $reqFile->name = $file_name;
          $reqFile->file = $this->docSigned->storeAs('/ionline/request_forms/request_files', $file_name.'.'.$this->docSigned->extension(), 'gcs');
          $reqFile->request_form_id = $this->requestForm->id;
          $reqFile->user_id = auth()->user()->id;
          $reqFile->save();

          $this->requestForm->signatures_file_id = 11;
          $this->requestForm->save();
      
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
                  ->send(new RequestFormSignNotification($this->requestForm, $nextEvent->first()));
              }
            }
          }

          session()->flash('info', 'Formulario de Requerimientos Nro.'.$this->requestForm->folio.' AUTORIZADO correctamente!');
          return redirect()->route($this->route);
        }
      }

      session()->flash('danger', 'Formulario de Requerimientos Nro.'.$this->requestForm->folio.' NO se puede Autorizar!');
      return redirect()->route($this->route);
    }


    public function rejectRequestForm() {
      $this->validate();
      $event = $this->requestForm->eventRequestForms()->where('event_type', $this->eventType)->where('status', 'pending')->first();
      if(!is_null($event)){
          if(!in_array($this->eventType, ['pre_budget_event', 'pre_finance_budget_event', 'budget_event'])){
            $this->requestForm->status = 'rejected';
            $this->requestForm->save();
          } else {
            $this->requestForm->load('itemRequestForms.latestPendingItemChangedRequestForms');
            foreach($this->requestForm->itemRequestForms as $item)
              if($item->latestPendingItemChangedRequestForms)
                $item->latestPendingItemChangedRequestForms->update(['status' => 'rejected']);
            $nextEvent = $event->requestForm->eventRequestForms->where('cardinal_number', $event->cardinal_number + 1);
            if(!$nextEvent->isEmpty()) $nextEvent->last()->update(['status' => 'does_not_apply']);
            $nextEvent = $event->requestForm->eventRequestForms->where('cardinal_number', $event->cardinal_number + 2);
            if(!$nextEvent->isEmpty()) $nextEvent->last()->update(['status' => 'does_not_apply']);
          }
           $event->signature_date = Carbon::now();
           $event->comment = $this->comment;
           $event->position_signer_user = $this->position;
           $event->status = 'rejected';
           $event->signerUser()->associate(auth()->user());
           $event->save();
           session()->flash('info', 'Formulario de Requerimientos Nro.'.$this->requestForm->folio.' fue RECHAZADO!');
           return redirect()->route($this->route);
          }
      session()->flash('danger', 'Formulario de Requerimientos Nro.'.$this->requestForm->folio.' NO se puede Rechazar!');
      return redirect()->route($this->route);
    }

    public function updatedDocSigned($value)
    {
      $this->docSigned = $value;
    }

    public function render() {
        return view('livewire.request-form.authorization');
    }
}
