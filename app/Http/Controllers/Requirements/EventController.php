<?php

namespace App\Http\Controllers\Requirements;

use App\Documents\Document;
use App\Requirements\RequirementCategory;
use App\Requirements\Category;
use App\Requirements\Requirement;
use App\Requirements\Event;
use App\Requirements\File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Rrhh\OrganizationalUnit;
use Illuminate\Support\Facades\Auth;
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

    // public function create_event($req_id)
    // {
    //   $ous = OrganizationalUnit::all()->sortBy('name');
    //   $organizationalUnit = OrganizationalUnit::Find(1);
    //   $requirement = Requirement::find($req_id);
    //   $requirementCategories = RequirementCategory::where('requirement_id',$req_id)->get();
    //   $categories = Category::where('user_id',Auth::user()->id)->get();
    //   $lastEvent = Event::where('requirement_id',$req_id)
    //                     ->where('to_user_id','<>',Auth::user()->id)->get()->last();
    //   //si no existen respuestas de otras personas, se devuelve la ultima cualquiera.
    //   if($lastEvent == null){
    //     $lastEvent = Event::where('requirement_id',$req_id)->get()->last();
    //   }
    //   $firstEvent = Event::where('requirement_id',$req_id)
    //                      ->First();
    //
    //   return view('requirements.events.create', compact('ous','organizationalUnit','requirement','categories','requirementCategories','lastEvent','firstEvent'));
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //cuando es nulo, es porque el select viene disabled, y debe obtenerse nuevamente la info.
        if($request->to_ou_id == null){
          $lastEvent = Event::where('requirement_id',$request->requirement_id)
                            ->where('from_user_id','<>',Auth::user()->id)->get()->last();
          //si no existen respuestas de otras personas, se devuelve la ultima cualquiera.
          if($lastEvent == null){
            $lastEvent = Event::where('requirement_id',$request->requirement_id)->get()->last();
          }
          $firstEvent = Event::where('requirement_id',$request->requirement_id)
                             //->where('from_user_id','<>',Auth::user()->id)->get()
                             ->First();
          if($request->status == 'respondido'){
            $request['to_ou_id'] = $lastEvent->from_user->organizationalUnit->id;
            $request['to_user_id'] = $lastEvent->from_user->id;
          }else{
            $request['to_ou_id'] = $firstEvent->from_user->organizationalUnit->id;
            $request['to_user_id'] = $firstEvent->from_user->id;
          }
        }

        //dd($request->users);
        //cuando no se agregó derivación a tabla temporal
        if($request->users == null){

          //guarda evento.
          $requirementEvent = new Event($request->All());
          $requirementEvent->from_user()->associate(Auth::user());
          $requirementEvent->from_ou_id = Auth::user()->organizationalUnit->id;
          $requirementEvent->save();

          //asocia evento con documentos
          if($request->documents <> null){
            foreach ($request->documents as $key => $document_aux) {
              $document = Document::find($document_aux);
              $requirementEvent->documents()->attach($document);
            }
          }

          //modifica estado del requerimiento
          $requirement = Requirement::find($request->requirement_id);
          //$requirement->user_id = Auth::user()->id;
          $requirement->status = $request->status;
          $requirement->save();

          //guarda archivos
          if($request->hasFile('forfile')){
            foreach($request->file('forfile') as $file) {
              $filename = $file->getClientOriginalName();
              $fileModel = New File;
              $fileModel->file = $file->store('requirements');
              $fileModel->name = $filename;
              $fileModel->event_id = $requirementEvent->id;
              //$fileModel->ticket()->associate($ticket);
              $fileModel->save();
            }
          }
        }

        else{

          //encuentra cuales son usuarios para derivar, y cuales son en copia.
          $users_req = null;
          $users_enCopia = null;
          foreach ($request->enCopia as $key => $enCopia) {
            if($enCopia == 0){
              $users_req[] = $request->users[$key];
            }
            if($enCopia == 1){
              $users_enCopia[] = $request->users[$key];
            }
          }

          //dd($users_req, $users_enCopia);

          //guarda eventos en copia
          if ($users_enCopia <> null) {
            foreach ($users_enCopia as $key => $user_) {
              //guarda evento.
              $user_aux = User::where('id',$user_)->get();
              $requirementEvent = new Event($request->All());
              $requirementEvent->to_ou_id = $user_aux->first()->organizational_unit_id;
              $requirementEvent->to_user_id = $user_;
              $requirementEvent->status = "en copia";
              $requirementEvent->from_user()->associate(Auth::user());
              $requirementEvent->from_ou_id = Auth::user()->organizationalUnit->id;
              $requirementEvent->save();
            }
          }

          //guarda otros eventos
          if($users_req != null){
            foreach ($users_req as $key => $user_) {
              //guarda evento.
              $user_aux = User::where('id',$user_)->get();
              $requirementEvent = new Event($request->All());
              $requirementEvent->to_ou_id = $user_aux->first()->organizational_unit_id;
              $requirementEvent->to_user_id = $user_;
              $requirementEvent->from_user()->associate(Auth::user());
              $requirementEvent->from_ou_id = Auth::user()->organizationalUnit->id;
              $requirementEvent->save();

              //asocia evento con documentos
              if($request->documents <> null){
                foreach ($request->documents as $key => $document_aux) {
                  $document = Document::find($document_aux);
                  $requirementEvent->documents()->attach($document);
                }
              }

              //modifica estado del requerimiento
              $requirement = Requirement::find($request->requirement_id);
              $requirement->status = $request->status;
              $requirement->save();

              //guarda archivos
              if($request->hasFile('forfile')){
                foreach($request->file('forfile') as $file) {
                  $filename = $file->getClientOriginalName();
                  $fileModel = New File;
                  $fileModel->file = $file->store('requirements');
                  $fileModel->name = $filename;
                  $fileModel->event_id = $requirementEvent->id;
                  //$fileModel->ticket()->associate($ticket);
                  $fileModel->save();
                }
              }
            }
          }

        }

        session()->flash('info', 'El evento '.$requirementEvent->id.' ha sido ingresado.');

        /*$requirementEvent->requirement->status = $requirementEvent->status;
        $requirementEvent->requirement->save();

        if($requirementEvent->status == 'abierto') {
            return redirect()->route('requirements.show', $requirementEvent->requirement);
        }
        else {
            return redirect()->route('requirements.index');
        }*/
        return redirect()->route('requirements.show', $requirementEvent->requirement);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Requirements\RequirementEvent  $requirementEvent
     * @return \Illuminate\Http\Response
     */
    public function show(RequirementEvent $requirementEvent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Requirements\RequirementEvent  $requirementEvent
     * @return \Illuminate\Http\Response
     */
    public function edit(RequirementEvent $requirementEvent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Requirements\RequirementEvent  $requirementEvent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RequirementEvent $requirementEvent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Requirements\RequirementEvent  $requirementEvent
     * @return \Illuminate\Http\Response
     */
    public function destroy(RequirementEvent $requirementEvent)
    {
        //
    }

    public function download(File $file)
    {
        return Storage::response($file->file, mb_convert_encoding($file->name,'ASCII'));
    }
}
