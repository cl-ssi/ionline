<?php

namespace App\Http\Controllers\ReplacementStaff;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ReplacementStaff\ReplacementStaff;
use App\Models\ReplacementStaff\ProfessionManage;
use App\Models\ReplacementStaff\ProfileManage;
use App\Models\ReplacementStaff\Profile;
use App\Models\UserExternal;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewStaffNotificationUser;
use App\Models\ReplacementStaff\Applicant;

class ReplacementStaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('replacement_staff.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $replacementStaff = ReplacementStaff::where('run',Auth::guard('external')->user()->id)->first();
        if($replacementStaff == null)
        {
            $userexternal = UserExternal::where('id',Auth::guard('external')->user()->id)->first();
            return view('replacement_staff.create',compact('userexternal'));

        }
        else{
            return $this->edit($replacementStaff);
        }
    }

    public function internal_create()
    {
        return view('replacement_staff.internal_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /*
    public function store(Request $request)
    {
        if($request->hasFile('cv_file') && $request->hasFile('file')){
            //SE GUARDA STAFF
            $replacementStaff = new ReplacementStaff($request->All());
            $now = Carbon::now()->format('Y_m_d_H_i_s');
            $file_name = $now.'_cv_'.$replacementStaff->run;
            $file = $request->file('cv_file');
            $replacementStaff->cv_file = $file->storeAs('/ionline/replacement_staff/cv_docs/', $file_name.'.'.$file->extension(), 'gcs');
            $replacementStaff->save();

            //SE GUARDA PERFIL OBLIGATORIO
            $profile = new Profile();
            $profile->degree_date = $request->degree_date;
            $profile->profile_manage_id = $request->profile;
            $profile->profession_manage_id = $request->profession;
            if($request->profile == 3 or $request->profile == 4){
                $profile->experience = $request->experience;
            }
            $profile->replacement_staff()->associate($replacementStaff);
            $now = Carbon::now()->format('Y_m_d_H_i_s');
            $file = $request->file('file');
            $file_name = $now.'_'.$replacementStaff->run;
            $profile->file = $file->storeAs('/ionline/replacement_staff/profile_docs/', $file_name.'.'.$file->extension(), 'gcs');
            $profile->save();

            Mail::to($replacementStaff->email)
                ->cc(env('APP_RYS_MAIL'))
                ->send(new NewStaffNotificationUser($replacementStaff));

            session()->flash('success', 'Se ha creado el postulante exitosamente');
            return redirect()->route('replacement_staff.edit', $replacementStaff);
        }
        else{
            session()->flash('danger', 'Error al cargar los archivos');
            return redirect()->back()->withInput();
        }
    }
    */

    public function store(Request $request)
    {
        if ($request->hasFile('cv_file') && $request->hasFile('file')) {
            // SE GUARDA O ACTUALIZA STAFF
            $replacementStaff = ReplacementStaff::updateOrCreate(
                ['run' => $request->run], // Condición para identificar si ya existe
                $request->all() // Datos para insertar o actualizar
            );

            $now = Carbon::now()->format('Y_m_d_H_i_s');
            $file_name = $now.'_cv_'.$replacementStaff->run;
            $file = $request->file('cv_file');
            $replacementStaff->cv_file = $file->storeAs('/ionline/replacement_staff/cv_docs/', $file_name.'.'.$file->extension(), 'gcs');
            $replacementStaff->save();

            // SE GUARDA PERFIL OBLIGATORIO
            $profile = new Profile();
            $profile->degree_date = $request->degree_date;
            $profile->profile_manage_id = $request->profile;
            $profile->profession_manage_id = $request->profession;
            if ($request->profile == 3 || $request->profile == 4) {
                $profile->experience = $request->experience;
            }
            $profile->replacement_staff()->associate($replacementStaff);
            $file_name = $now.'_'.$replacementStaff->run;
            $file = $request->file('file');
            $profile->file = $file->storeAs('/ionline/replacement_staff/profile_docs/', $file_name.'.'.$file->extension(), 'gcs');
            $profile->save();

            Mail::to($replacementStaff->email)
                ->cc(env('APP_RYS_MAIL'))
                ->send(new NewStaffNotificationUser($replacementStaff));

            session()->flash('success', 'Se ha creado el postulante exitosamente');
            return redirect()->route('replacement_staff.edit', $replacementStaff);
        } else {
            session()->flash('danger', 'Error al cargar los archivos');
            return redirect()->back()->withInput();
        }
    }

    public function internal_store(Request $request)
    {
        $exist = ReplacementStaff::where('run', $request->run)->get();
        if($exist->count() > 0){
            session()->flash('warning', 'Estimado Usuario: El RUN ya se encuentra en registrado');
            return redirect()->back()->withInput();
        }
        else{
            if($request->hasFile('cv_file')){
                //SE GUARDA STAFF
                $replacementStaff = new ReplacementStaff($request->All());
                $now = Carbon::now()->format('Y_m_d_H_i_s');
                $file_name = $now.'_cv_'.$replacementStaff->run;
                $file = $request->file('cv_file');
                $replacementStaff->cv_file = $file->storeAs('/ionline/replacement_staff/cv_docs/', $file_name.'.'.$file->extension(), 'gcs');
                $replacementStaff->save();
    
                Mail::to($replacementStaff->email)
                    ->cc(env('APP_RYS_MAIL'))
                    ->send(new NewStaffNotificationUser($replacementStaff));
    
                session()->flash('success', 'Se ha creado el postulante exitosamente');
                return redirect()->route('replacement_staff.index', $replacementStaff);
            }
            else{
                session()->flash('danger', 'Error al cargar los archivos');
                return redirect()->back()->withInput(Input::all());
            }
        }
    }

    public function edit(ReplacementStaff $replacementStaff)
    {
        //$professionManage = ProfessionManage::orderBy('name', 'ASC')->get();
        $profileManage = ProfileManage::orderBy('name', 'ASC')->get();
        // dd(auth()->user());
        if($replacementStaff->run == auth()->user()->id){
          return view('replacement_staff.edit', compact('replacementStaff'));
        }
        else{
            return redirect()->back();
        }
    }

    public function update(Request $request, ReplacementStaff $replacementStaff)
    {
        if($request->hasFile('cv_file'))
        {
            //DELETE LAST CV
            Storage::delete($replacementStaff->cv_file);

            $replacementStaff->fill($request->all());
            $now = Carbon::now()->format('Y_m_d_H_i_s');
            $file_name = $now.'_cv_'.$replacementStaff->run;
            $file = $request->file('cv_file');
            $replacementStaff->cv_file = $file->storeAs('/ionline/replacement_staff/cv_docs/', $file_name.'.'.$file->extension(), 'gcs');
            $replacementStaff->save();
        }
        else{
            $replacementStaff->fill($request->all());
            $replacementStaff->save();
        }
        session()->flash('success', 'Sus datos personales han sido correctamente actualizados.');
        return redirect()->route('replacement_staff.edit', $replacementStaff);
    }

    public function destroy($id)
    {
        //
    }

    public function show_file(ReplacementStaff $replacementStaff)
    {
        return Storage::response($replacementStaff->cv_file);
    }

    public function download(ReplacementStaff $replacementStaff)
    {
        return Storage::download($replacementStaff->cv_file);
    }

    public function show_replacement_staff(ReplacementStaff $replacementStaff){
        $professionManage = ProfessionManage::orderBy('name', 'ASC')->get();
        $profileManage = ProfileManage::orderBy('name', 'ASC')->get();

        return view('replacement_staff.show_replacement_staff', compact('replacementStaff', 'professionManage', 'profileManage'));
    }

    public function replacement_staff_historical(Request $request){
        $replacementStaff = ReplacementStaff::where('run', $request->run)->first();

        if($replacementStaff){
            $applicants = Applicant::where('replacement_staff_id', $replacementStaff->id)
                ->where('selected', 1)
                ->get();
            return view('replacement_staff.reports.replacement_staff_historical', compact('request', 'replacementStaff', 'applicants'));
        }
        return view('replacement_staff.reports.replacement_staff_historical', compact('request', 'replacementStaff'));
    }
}
