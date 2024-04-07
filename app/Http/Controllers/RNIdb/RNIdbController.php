<?php

namespace App\Http\Controllers\RNIdb;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Establishment;
use App\Models\RNIdb\File;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RNIdbController extends Controller
{
    public function index()
    {
        // $files = Storage::disk('gcs')->listContents('ionline/rni_db');
        $establishments = Establishment::orderBy('name')->get();
        $files = File::with('establishment.commune', 'users')->get();
        return view('rni_db.index', compact('files', 'establishments'));
    }

    public function update(Request $request)
    {
        if($request->hasFile('file')){
            $file = File::firstOrNew(['establishment_id' => $request->establishment_id]);
            Storage::disk('gcs')->delete($file->file);
            $originalname = $request->file('file')->getClientOriginalName();
            $file->file = $request->file->storeAs('ionline/rni_db', $originalname, ['disk' => 'gcs']);
            $file->filename = $originalname;
            $file->size = number_format($request->file->getSize()/1024, 2).' KB';
            $file->user_id = Auth::id();
            $file->save();
        }
        return redirect()->route('indicators.rni_db.index')->with('success', 'Base de datos RNI se actualiza satisfactoriamente.');
    }

    public function download(File $file)
    {
        if($file->users()->where('user_id', Auth::id())->count() == 0 && !auth()->user()->hasPermissionTo('RNI Database: admin'))
            return redirect()->route('indicators.index')->with('warning', 'El usuario no tiene los permisos necesarios para descargar base datos RNI.');
        return Storage::disk('gcs')->download($file->file);
    }

    public function add_user(File $file, Request $request)
    {
        if($file->users()->where('user_id', $request->user_id)->count() > 0)
            return redirect()->route('indicators.rni_db.index')->with('info', 'Funcionario ya se encuentra registrado.');

        User::findOrFail($request->user_id)->givePermissionTo('RNI Database: view');
        $file->users()->attach($request->user_id);

        return redirect()->route('indicators.rni_db.index')->with('success', 'Funcionario se ha registrado satisfactoriamente.');
    }

    public function revoke_user(File $file, Request $request)
    {
        if($file->users()->where('user_id', $request->user_id)->count() == 0)
            return redirect()->route('indicators.rni_db.index')->with('info', 'Funcionario no se encuentra registrado.');

        User::findOrFail($request->user_id)->revokePermissionTo('RNI Database: view');
        $file->users()->detach($request->user_id);
        return redirect()->route('indicators.rni_db.index')->with('success', 'Funcionario se ha quitado del listado satisfactoriamente.');
    }

}
