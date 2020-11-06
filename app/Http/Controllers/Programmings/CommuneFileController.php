<?php

namespace App\Http\Controllers\Programmings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Programmings\Programming;
use App\Models\Programmings\CommuneFile;
use App\Models\Commune;
use App\Establishment;
use App\User;

use Illuminate\Support\Facades\Storage;

class CommuneFileController extends Controller
{
    public function index()
    {
        
        $year = '';
        if(Auth()->user()->id == '15683706' || Auth()->user()->id == '12345678' || Auth()->user()->id == '13641014' || Auth()->user()->id == '17011541' || Auth()->user()->id == '15287582')
        {
        
        $communeFiles = CommuneFile::select(
                             'pro_commune_files.id'
                            ,'pro_commune_files.year'
                            ,'pro_commune_files.user_id'
                            ,'pro_commune_files.description'
                            ,'pro_commune_files.created_at'
                            ,'pro_commune_files.file_a'
                            ,'pro_commune_files.file_b'
                            ,'pro_commune_files.file_c'
                            ,'T2.name AS commune'
                            ,'T3.name' 
                            ,'T3.fathers_family'
                            ,'T3.mothers_family')
                ->leftjoin('communes AS T2', 'pro_commune_files.commune_id', '=', 'T2.id')
                ->leftjoin('users AS T3', 'pro_commune_files.user_id', '=', 'T3.id')
                ->Where('pro_commune_files.year','LIKE','%'.$year.'%')
                ->orderBy('T2.name','ASC')->get();
        }
        else {
            $communeFiles = CommuneFile::select(
                        'pro_commune_files.id'
                        ,'pro_commune_files.year'
                        ,'pro_commune_files.user_id'
                        ,'pro_commune_files.description'
                        ,'pro_commune_files.created_at'
                        ,'pro_commune_files.file_a'
                        ,'pro_commune_files.file_b'
                        ,'pro_commune_files.file_c'
                        ,'T2.name AS commune'
                        ,'T3.name' 
                        ,'T3.fathers_family'
                        ,'T3.mothers_family')
            ->leftjoin('communes AS T2', 'pro_commune_files.commune_id', '=', 'T2.id')
            ->leftjoin('users AS T3', 'pro_commune_files.user_id', '=', 'T3.id')
            ->Where('pro_commune_files.year','LIKE','%'.$year.'%')
            ->Where('pro_commune_files.access','LIKE','%'.Auth()->user()->id.'%')
            ->orderBy('T2.name','ASC')->get();
        }
        
        
        return view('programmings/communeFiles/index')->withCommuneFiles($communeFiles);
    }

    public function create() 
    {   
        $communes = Commune::get();
        $users = User::where('position', 'Funcionario Programación')->OrderBy('name')->get(); // Sólo Funcionario Programación
        return view('programmings/communeFiles/create')->withCommunes($communes)->withUsers($users);
    }

    public function store(Request $request)
    {
        $communeFileValid = CommuneFile::where('commune_id', $request->commune)
                                       ->where('year', $request->date)
                                       ->first();
        if($communeFileValid){
            session()->flash('warning', 'Ya se ha iniciado el registro adjunto para esta comuna el año ingresado');
        }
        else {
            $communeFile  = new CommuneFile($request->All());
            $communeFile->year = $request->date;
            $communeFile->description = $request->description;
            $communeFile->commune_id = $request->commune;
            $communeFile->user_id  = $request->user;
            $communeFile->access   = serialize($request->access);
        
            $communeFile->save();
           
            session()->flash('info', 'Se ha iniciado una nueva registro adjunto');
        }

        return redirect()->back();
    }

    public function show(CommuneFile $communeFiles, $id)
    {
        $communeFile = CommuneFile::with('commune')->find($id);
        //dd($comFile);
        $communes = Commune::get();
        $users = User::with('organizationalUnit')->where('position', 'Funcionario Programación')->OrderBy('name')->get(); // Sólo Funcionario Programación
        $access_list = unserialize($communeFile->access);
        $user = $communeFile->user;
        return view('programmings/communeFiles/show')->withCommuneFile($communeFile)->with('access_list', $access_list)->with('user', $user)->withCommunes($communes)->withUsers($users);
    }

    public function update(Request $request,$id)
    {
       // DD($request);

        $communeFile = CommuneFile::find($id);

        $communeFile->fill($request->all());
        if($request->description){
            $communeFile->description = $request->description;
        }
        if($request->date){
            $communeFile->year = $request->date;
        }
        if($request->user){
            $communeFile->user_id  = $request->user;
        }
        if($request->access){
            $communeFile->access   = serialize($request->access);
        }

        if($request->hasFile('file_a')){

            Storage::delete($communeFile->file_a);
            $communeFile->file_a = $request->file('file_a')->store('programmings');
        }
        if($request->hasFile('file_b')){
            Storage::delete($communeFile->file_b);
            $communeFile->file_b = $request->file('file_b')->store('programmings');
        }
        if($request->hasFile('file_c')){
            Storage::delete($communeFile->file_c);
            $communeFile->file_c = $request->file('file_c')->store('programmings');
        }
        
        $communeFile->save();

        return redirect()->back();
    }

    public function download(CommuneFile $file)
    {
        return Storage::response($file->file_a, mb_convert_encoding($file->name,'ASCII'));
    }
    public function downloadFileB(CommuneFile $file)
    {
        return Storage::response($file->file_b, mb_convert_encoding($file->name,'ASCII'));
    }

    public function downloadFileC(CommuneFile $file)
    {
        return Storage::response($file->file_c, mb_convert_encoding($file->name,'ASCII'));
    }

}
