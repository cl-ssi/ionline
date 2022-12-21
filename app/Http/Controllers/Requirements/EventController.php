<?php

namespace App\Http\Controllers\Requirements;

use App\Models\Documents\Document;
use App\Mail\RequirementEventNotification;
use App\Mail\RequirementNotification;
use App\Requirements\RequirementCategory;
use App\Requirements\Category;
use App\Requirements\Requirement;
use App\Requirements\Event;
use App\Requirements\File;
use App\Rrhh\Authority;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Rrhh\OrganizationalUnit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use App\User;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        //cuando es nulo, es porque el select viene disabled, y debe obtenerse nuevamente la info.
        if ($request->to_ou_id == null) {
            $lastEvent = Event::where('requirement_id', $request->requirement_id)
                ->where('from_user_id', '<>', Auth::user()->id)->get()->last();
            //si no existen respuestas de otras personas, se devuelve la ultima cualquiera.
            if ($lastEvent == null) {
                $lastEvent = Event::where('requirement_id', $request->requirement_id)->get()->last();
            }
            $firstEvent = Event::where('requirement_id', $request->requirement_id)
                //->where('from_user_id','<>',Auth::user()->id)->get()
                ->First();
            if ($request->status == 'respondido') {
                $request['to_ou_id'] = $lastEvent->from_user->organizationalUnit->id;
                $request['to_user_id'] = $lastEvent->from_user->id;
            } else {
                $request['to_ou_id'] = $firstEvent->from_user->organizationalUnit->id;
                $request['to_user_id'] = $firstEvent->from_user->id;
            }
        }

        // validación existencia autoridad en ou
        if (Authority::getAuthorityFromDate($request->to_ou_id, now(), 'manager') == null) {
          return redirect()->back()->with('warning', 'La unidad organizacional seleccionada no tiene asignada una autoridad. Favor contactar a secretaria de dicha unidad para regularizar.');
        }

        //cuando no se agregó derivación a tabla temporal
        if ($request->users == null) {
            //Si el usuario destino es autoridad, se marca el requerimiento
            $managerUserId = Authority::getAuthorityFromDate($request->to_ou_id, now(), 'manager')->user_id;
            $isManager = ($request->to_user_id == $managerUserId);

            //guarda evento.
            $requirementEvent = new Event($request->All());
            $requirementEvent->from_user()->associate(Auth::user());
            $requirementEvent->from_ou_id = Auth::user()->organizationalUnit->id;
            $requirementEvent->to_authority = $isManager;
            $requirementEvent->save();

            /* Asocia documentos al evento */
            if ($request->has('documents')) {
                $array_documents = explode(',', $request->input('documents'));
                foreach($array_documents as $doc_id) {
                    $requirementEvent->documents()->attach(Document::find($doc_id));
                }
            }

            //modifica estado del requerimiento
            $requirement = Requirement::find($request->requirement_id);
            //$requirement->user_id = Auth::user()->id;
            $requirement->status = $request->status;
            if(!$requirement->to_authority) $requirement->to_authority = $isManager;
            $requirement->save();

            //guarda archivos
            if ($request->hasFile('forfile')) {
                foreach ($request->file('forfile') as $file) {
                    $filename = $file->getClientOriginalName();
                    $fileModel = new File;
                    $fileModel->file = $file->store('requirements');
                    // $fileModel->file = $file->store('ionline/requirements',['disk' => 'gcs']);
                    $fileModel->name = $filename;
                    $fileModel->event_id = $requirementEvent->id;
                    //$fileModel->ticket()->associate($ticket);
                    $fileModel->save();
                }
            }
        } else {

            //encuentra cuales son usuarios para derivar, y cuales son en copia.
            $users_req = null;
            $users_enCopia = null;
            foreach ($request->enCopia as $key => $enCopia) {
                if ($enCopia == 0) {
                    $users_req[] = $request->users[$key];
                }
                if ($enCopia == 1) {
                    $users_enCopia[] = $request->users[$key];
                }
            }

            //dd($users_req, $users_enCopia);

            //guarda eventos en copia
            $isAnyManager = false;
            if ($users_enCopia <> null) {
                foreach ($users_enCopia as $key => $user_) {
                    //Si algún usuario destino es autoridad, se marca el requerimiento
                    $userModel = User::find($user_);
                    $managerUserId = Authority::getAuthorityFromDate($userModel->organizationalUnit->id, now(), 'manager')->user_id;
                    $isManager = ($user_ == $managerUserId);
                    if ($isManager) $isAnyManager = true;

                    //guarda evento.
                    $user_aux = User::where('id', $user_)->get();
                    $requirementEvent = new Event($request->All());
                    $requirementEvent->to_ou_id = $user_aux->first()->organizational_unit_id;
                    $requirementEvent->to_user_id = $user_;
                    $requirementEvent->status = "en copia";
                    $requirementEvent->from_user()->associate(Auth::user());
                    $requirementEvent->from_ou_id = Auth::user()->organizationalUnit->id;
                    $requirementEvent->to_authority = $isManager;
                    $requirementEvent->save();
                    $requirementEvent->requirement()->update(['to_authority' => $isAnyManager]);
                }
            }

            //guarda otros eventos
            if ($users_req != null) {
                foreach ($users_req as $key => $user_) {
                    //Si algún usuario destino es autoridad, se marca el requerimiento
                    $userModel = User::find($user_);
                    $managerUserId = Authority::getAuthorityFromDate($userModel->organizationalUnit->id, now(), 'manager')->user_id;
                    $isManager = ($user_ == $managerUserId);
                    if ($isManager) $isAnyManager = true;

                    //guarda evento.
                    $user_aux = User::where('id', $user_)->get();
                    $requirementEvent = new Event($request->All());
                    $requirementEvent->to_ou_id = $user_aux->first()->organizational_unit_id;
                    $requirementEvent->to_user_id = $user_;
                    $requirementEvent->from_user()->associate(Auth::user());
                    $requirementEvent->from_ou_id = Auth::user()->organizationalUnit->id;
                    $requirementEvent->to_authority = $isManager;
                    $requirementEvent->save();
                    $requirementEvent->requirement()->update(['to_authority' => $isAnyManager]);

                    /* Asocia documentos al evento */
                    if ($request->has('documents')) {
                        $array_documents = explode(',', $request->input('documents'));
                        foreach($array_documents as $doc_id) {
                            $requirementEvent->documents()->attach(Document::find($doc_id));
                        }
                    }

                    //modifica estado del requerimiento
                    $requirement = Requirement::find($request->requirement_id);
                    $requirement->status = $request->status;
                    $requirement->save();

                    //guarda archivos
                    if ($request->hasFile('forfile')) {
                        foreach ($request->file('forfile') as $file) {
                            $filename = $file->getClientOriginalName();
                            $fileModel = new File;
                            $fileModel->file = $file->store('requirements');
                            // $fileModel->file = $file->store('ionline/requirements',['disk' => 'gcs']);
                            $fileModel->name = $filename;
                            $fileModel->event_id = $requirementEvent->id;
                            //$fileModel->ticket()->associate($ticket);
                            $fileModel->save();
                        }
                    }
                }
            }

        }

        //Envía correo si destinatario es director
        $directorAuthority = Authority::getAuthorityFromDate(1, date('Y-m-d'), 'manager');
        if ($request->to_user_id == $directorAuthority->user_id) {
            Mail::to($directorAuthority->user->email)
                ->send(new RequirementEventNotification($requirementEvent));
        }

        session()->flash('info', 'El evento ' . $requirementEvent->id . ' ha sido ingresado.');
        return redirect()->route('requirements.show', $requirementEvent->requirement);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Requirements\RequirementEvent $requirementEvent
     * @return \Illuminate\Http\Response
     */
    public function show(RequirementEvent $requirementEvent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Requirements\RequirementEvent $requirementEvent
     * @return \Illuminate\Http\Response
     */
    public function edit(RequirementEvent $requirementEvent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Requirements\RequirementEvent $requirementEvent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RequirementEvent $requirementEvent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Requirements\RequirementEvent $requirementEvent
     * @return \Illuminate\Http\Response
     */
    public function destroy(RequirementEvent $requirementEvent)
    {
        //
    }

    public function download(File $file)
    {
        // dd($file);
        // return Storage::response($file->file, mb_convert_encoding($file->name, 'ASCII'));
        // $file = $dispatch->files->first();
        return Storage::disk('gcs')->response($file->file, mb_convert_encoding($file->name,'ASCII'));
    }
}
