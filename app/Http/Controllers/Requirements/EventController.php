<?php

namespace App\Http\Controllers\Requirements;

use App\Http\Controllers\Controller;
use App\Mail\RequirementEventNotification;
use App\Models\Documents\Document;
use App\Models\Requirements\Event;
use App\Models\Requirements\File;
use App\Models\Requirements\Requirement;
use App\Models\Rrhh\Authority;
use App\Models\User;
use App\Notifications\Requirements\NewSgr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        //cuando es nulo, es porque el select viene disabled, y debe obtenerse nuevamente la info.
        if ($request->to_ou_id == null) {
            $lastEvent = Event::where('requirement_id', $request->requirement_id)
                ->where('from_user_id', '<>', auth()->id())->get()->last();
            //si no existen respuestas de otras personas, se devuelve la ultima cualquiera.
            if ($lastEvent == null) {
                $lastEvent = Event::where('requirement_id', $request->requirement_id)->get()->last();
            }
            $firstEvent = Event::where('requirement_id', $request->requirement_id)
                //->where('from_user_id','<>',auth()->id())->get()
                ->First();
            if ($request->status == 'respondido') {
                $request['to_ou_id'] = $lastEvent->from_user->organizationalUnit->id;
                $request['to_user_id'] = $lastEvent->from_user->id;
            } else {
                $request['to_ou_id'] = $firstEvent->from_user->organizationalUnit->id;
                $request['to_user_id'] = $firstEvent->from_user->id;
            }
        }

        /* FIX: @sickiqq, esto está en el EVENT Controller, que pasó si se creo el REQ? tiene un return.
         * Se crea el req y no se crean los eventos?
         * Porque mejor validar en el req y no dentro de los eventos, ya que por ejemplo
         * podría crear eventos para usuarios que si tengan manager
         * y el último no tener, que pasaría ahí? se crearian todos los primero y el último no?
         * o se cae la creación completa del Req? */
        // validación existencia autoridad en ou
        if (Authority::getAuthorityFromDate($request->to_ou_id, now(), 'manager') == null) {
            return redirect()->back()->with('warning', 'La unidad organizacional seleccionada no tiene asignada una autoridad. Favor contactar a secretaria de dicha unidad para regularizar.');
        }

        //cuando no se agregó derivación a tabla temporal
        if ($request->users == null) {
            //Si el usuario destino es autoridad, se marca el requerimiento
            $managerUserId = Authority::getAuthorityFromDate($request->to_ou_id, now(), 'manager')->user_id ?? null;
            $isManager = ($request->to_user_id == $managerUserId);

            //guarda evento.
            $requirementEvent = new Event($request->All());
            $requirementEvent->from_user()->associate(auth()->user());
            $requirementEvent->from_ou_id = auth()->user()->organizationalUnit->id;
            $requirementEvent->to_authority = $isManager;
            $requirementEvent->save();

            /* Asocia documentos al evento */
            if ($request->has('documents')) {
                $array_documents = explode(',', $request->input('documents'));
                foreach ($array_documents as $doc_id) {
                    $requirementEvent->documents()->attach(Document::find($doc_id));
                }
            }

            //modifica estado del requerimiento
            $requirement = Requirement::find($request->requirement_id);
            //$requirement->user_id = auth()->id();
            $requirement->status = $request->status;

            // Si es un reabierto gatilla un mail a los responsables
            if ($request->status == 'reabierto') {
                $toUser = User::find($requirementEvent->to_user_id);
                $toUser->notify(new NewSgr($requirement, $requirementEvent));
            }
            if (! $requirement->to_authority) {
                $requirement->to_authority = $isManager;
            }
            $requirement->save();

            //guarda archivos
            if ($request->hasFile('forfile')) {
                foreach ($request->file('forfile') as $file) {
                    $filename = $file->getClientOriginalName();
                    $fileModel = new File;
                    // $fileModel->file = $file->store('requirements');
                    $fileModel->file = $file->store('ionline/requirements', ['disk' => 'gcs']);
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
            if ($users_enCopia != null) {
                foreach ($users_enCopia as $key => $user_) {
                    //Si algún usuario destino es autoridad, se marca el requerimiento
                    $userModel = User::find($user_);

                    /** Hice esta modificación para que no se caiga si no tienen manager la OU */
                    $manager = Authority::getAuthorityFromDate($userModel->organizationalUnit->id, now(), 'manager');
                    $isManager = null;
                    if ($manager) {
                        $isManager = ($user_ == $manager->user_id);
                    }
                    if ($isManager) {
                        $isAnyManager = true;
                    }

                    //guarda evento.
                    $user_aux = User::where('id', $user_)->get();
                    $requirementEvent = new Event($request->All());
                    $requirementEvent->to_ou_id = $user_aux->first()->organizational_unit_id;
                    $requirementEvent->to_user_id = $user_;
                    $requirementEvent->status = 'en copia';
                    $requirementEvent->from_user()->associate(auth()->user());
                    $requirementEvent->from_ou_id = auth()->user()->organizationalUnit->id;
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
                    $managerUserId = Authority::getAuthorityFromDate($userModel->organizationalUnit->id, now(), 'manager')->user_id ?? null;
                    $isManager = ($user_ == $managerUserId);
                    if ($isManager) {
                        $isAnyManager = true;
                    }

                    //guarda evento.
                    $user_aux = User::where('id', $user_)->get();
                    $requirementEvent = new Event($request->All());
                    $requirementEvent->to_ou_id = $user_aux->first()->organizational_unit_id;
                    $requirementEvent->to_user_id = $user_;
                    $requirementEvent->from_user()->associate(auth()->user());
                    $requirementEvent->from_ou_id = auth()->user()->organizationalUnit->id;
                    $requirementEvent->to_authority = $isManager;
                    $requirementEvent->save();
                    $requirementEvent->requirement()->update(['to_authority' => $isAnyManager]);

                    /* Asocia documentos al evento */
                    if ($request->has('documents')) {
                        $array_documents = explode(',', $request->input('documents'));
                        foreach ($array_documents as $doc_id) {
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
                            // $fileModel->file = $file->store('requirements');
                            $fileModel->file = $file->store('ionline/requirements', ['disk' => 'gcs']);
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
        $directorAuthority = Authority::getAuthorityFromDate(1, today(), 'manager');
        if ($request->to_user_id == $directorAuthority->user_id) {
            Mail::to($directorAuthority->user->email)
                ->send(new RequirementEventNotification($requirementEvent));
        }

        //session()->flash('info', 'El evento ' . $requirementEvent->id . ' ha sido ingresado.');
        //return redirect()->route('requirements.show', $requirementEvent->requirement);
        //requerimiento de Mariela Romero
        session()->flash('info', 'El evento '.$requirementEvent->id.' ha sido ingresado.');

        return redirect()->route('requirements.inbox');
    }

    public function download(File $file)
    {
        // dd($file);
        // return Storage::response($file->file, mb_convert_encoding($file->name, 'ASCII'));
        // $file = $dispatch->files->first();

        if (Storage::exists($file->file)) {
            return Storage::response($file->file, mb_convert_encoding($file->name, 'ASCII'));
        } else {
            return redirect()->back()->with('warning', 'El archivo no se ha encontrado.');
        }

        // return Storage::disk('gcs')->response($file->file, mb_convert_encoding($file->name,'ASCII'));

    }

    public function deleteFile(File $file)
    {
        Storage::delete($file);

        $file->delete();

        return redirect()->back()->with('success', 'Se eliminó el archivo adjunto.');
    }
}
