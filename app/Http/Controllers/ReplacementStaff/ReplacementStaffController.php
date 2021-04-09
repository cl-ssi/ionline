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

class ReplacementStaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $replacementStaff = ReplacementStaff::search($request->input('search'),
                                                     $request->input('profile_search'),
                                                     $request->input('profession_search'))
            ->paginate(15);

        $professionManage = ProfessionManage::orderBy('name', 'ASC')->get();
        $profileManage = ProfileManage::orderBy('name', 'ASC')->get();

        return view('replacement_staff.index', compact('replacementStaff', 'request', 'professionManage', 'profileManage'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        //$replacementStaff = ReplacementStaff::where('run',$user_cu->RolUnico->numero)->first();
        $replacementStaff = ReplacementStaff::where('run',Auth::guard('external')->user()->id)->first();
        if($replacementStaff == null)
        {
            $userexternal = UserExternal::where('id',Auth::guard('external')->user()->id)->first();
            dd($userexternal);
            return view('replacement_staff.create',compact('userexternal'));

        }
        else{
            return $this->edit($replacementStaff);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->hasFile('cv_file'))
        {
            $replacementStaff = new ReplacementStaff($request->All());
            $now = Carbon::now()->format('Y_m_d_H_i_s');
            $file_name = $now.'_cv_'.$replacementStaff->run;
            $file = $request->file('cv_file');
            // dd($file);
            //$upload = $request->file('arquivo')->storeAs('products', 'novonomeaffffff.jpg');
            $replacementStaff->cv_file = $file->storeAs('replacement_staff/cv_docs', $file_name.'.'.$file->extension());
            $replacementStaff->save();
        }

        session()->flash('success', 'Se ha creado el postulante exitosamente');
        //return redirect()->back();
        return redirect()->route('replacement_staff.edit', $replacementStaff);
    }

    public function edit(ReplacementStaff $replacementStaff)
    {
        $professionManage = ProfessionManage::orderBy('name', 'ASC')->get();
        $profileManage = ProfileManage::orderBy('name', 'ASC')->get();
        // dd(Auth()->user());
        if($replacementStaff->run == Auth()->user()->id){
          return view('replacement_staff.edit', compact('replacementStaff', 'professionManage', 'profileManage'));
        }
        else{
            return redirect()->back();
        }
    }

    public function update(Request $request, ReplacementStaff $replacementStaff)
    {

        if($request->hasFile('cv_file'))
        {
            $replacementStaff->fill($request->all());
            $now = Carbon::now()->format('Y_m_d_H_i_s');
            $file_name = $now.'_cv_'.$replacementStaff->run;
            $file = $request->file('cv_file');
            $replacementStaff->cv_file = $file->storeAs('replacement_staff/cv_docs', $file_name.'.'.$file->extension());
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
}
