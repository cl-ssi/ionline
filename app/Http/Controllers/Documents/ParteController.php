<?php

namespace App\Http\Controllers\Documents;

use App\Http\Controllers\Controller;
use App\Models\Documents\Document;
use App\Models\Documents\Parte;
use App\Models\Documents\ParteEvent;
use App\Models\Documents\ParteFile;
use App\Rrhh\OrganizationalUnit;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ParteController extends Controller
{
    /**
     * Bandeja de Entrada
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $partes = Parte::query()
            ->whereEstablishmentId(auth()->user()->organizationalUnit->establishment->id)
            ->search($request)
            ->with(['requirements','files','requirements.events','requirements.events.to_user'])
            ->latest()->paginate('100');
        //$d->events()->doesntHave('father')->get()
        // $partes = Parte::whereHas('events', function ($query) {
        //     $query->where('active', 1)
        //           ->where('user_id', Auth::id());
        // })->get();
        return view('documents.partes.index', compact('partes', 'request'));
    }

    /**
     * Bandeja de Salida
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function outbox(Request $request)
    {
        $documents = Document::query()
            ->whereEstablishmentId(auth()->user()->organizationalUnit->establishment->id)
            ->search($request)
            ->where('type',['Ordinario','Circular'])
            ->latest()
            ->paginate('100');
        $users = User::orderBy('name')->orderBy('fathers_family')->get();
        return view('documents.partes.outbox', compact('documents', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $today = date("Y-m-j\T00:00:00");
        return view('documents.partes.create', compact('today'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //$request->entered_at = date("Y-m-d H:i:s",strtotime($request->entered_at));
        //dd($request);
        $parte = new Parte($request->All());
        $parte->establishment()->associate(auth()->user()->organizationalUnit->establishment);
        $parte->save();

        //dd($parte);

        $evento = new ParteEvent();
        $evento->user()->associate(Auth::user());
        $evento->organizationalUnit()->associate(Auth::user()->organizationalUnit);

        if($request->hasFile('forfile')){
            foreach($request->file('forfile') as $file) {
                $filename = $file->getClientOriginalName();
                $fileModel = New ParteFile;
                $fileModel->file = $file->store('ionline/documents/partes',['disk' => 'gcs']);
                $fileModel->name = $filename;
                $fileModel->parte_id = $parte->id;
                $fileModel->save();
            }
        }

        $parte->events()->save($evento);

        session()->flash('info', 'El documento ha sido ingresado.');
        return redirect()->route('documents.partes.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Documents\Parte  $parte
     * @return \Illuminate\Http\Response
     */
    public function show(Parte $parte)
    {
        $files = ParteFile::where('parte_id',$parte->id)->get();
        $ous = OrganizationalUnit::all()->sortBy('name');
        $organizationalUnit = OrganizationalUnit::find(1);
        //$leafs = $parte->events()->doesntHave('childs')->get();
        return view('documents.partes.show', compact('parte','leafs','ous','organizationalUnit','files'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Documents\Parte  $parte
     * @return \Illuminate\Http\Response
     */
    public function edit(Parte $parte)
    {
        return view('documents.partes.edit', compact('parte'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Documents\Parte  $parte
     * @return \Illuminate\Http\Response
     */
    public function update(Parte $parte, Request $request)
    {
        $parte->fill($request->All());

        $parte->save();

        if($request->hasFile('forfile')){
            foreach($request->file('forfile') as $file) {
                $filename = $file->getClientOriginalName();
                $fileModel = New ParteFile;
                $fileModel->file = $file->store('ionline/documents/partes',['disk'=>'gcs']);
                $fileModel->name = $filename;
                $fileModel->parte_id = $parte->id;
                $fileModel->save();
            }
        }

        session()->flash('info', 'El documento ha sido actualizado.');
        return redirect()->route('documents.partes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Documents\Parte  $parte
     * @return \Illuminate\Http\Response
     */
    public function destroy(Parte $parte)
    {
        if($parte->requirements->count() == 0)
        {
            foreach($parte->events as $event) {
                $event->forceDelete();
            }
            foreach($parte->files as $file) {
                Storage::disk('gcs')->delete($file->file);
                //$file->delete();
                $file->forceDelete();
            }

            $parte->forceDelete();
            return redirect()->route('documents.partes.index');
        }
        else
        {
            session()->flash('danger', 'El parte no puede ser eliminado, existen requerimientos asociados.');
            return redirect()->route('documents.partes.edit', $parte);
        }

    }

    public function inbox()
    {
        return view('documents.partes.inbox');
    }

    public function view(Parte $parte)
    {
        $parte->viewed_at = Carbon::now()->toDateTimeString();
        $parte->save();
        return back();
    }

    public function admin()
    {
        $ous = OrganizationalUnit::all()->sortBy('name');
        return view('documents.partes.admin')->withOus($ous);
    }

    public function download(ParteFile $file)
    {

        if(Storage::disk('gcs')->exists($file->file))
        {
            return Storage::disk('gcs')->response($file->file, mb_convert_encoding($file->name,'ASCII'));
        }
        else
        {
            //logger('No se encontró el archivo '.$file->file);
            session()->flash('danger', 'No se encontró el archivo '.$file->file);
            return redirect()->route('documents.partes.index');
        }
    }
}
