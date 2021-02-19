<?php

namespace App\Http\Controllers\ReplacementStaff;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ReplacementStaff\Profile;
use App\Models\ReplacementStaff\ReplacementStaff;
use Carbon\Carbon;

class ProfileController extends Controller
{

    public function store(Request $request, ReplacementStaff $replacementStaff)
    {
        $files = $request->file('file');
        //dd($files);
        if($request->hasFile('file'))
        {
            $profile = new Profile();
            $i = 1;
            foreach ($files as $file) {

                //$file->store('users/' . $this->user->id . '/messages');
                //$profile_filename = $file->getClientOriginalName();
                $profile->profession = 'enfermera';
                $now = Carbon::now()->format('Y_m_d_H_i_s');
                $profile->file_name = $now.'_'.$i.'_'.$replacementStaff->run;
                $profile->file = $file->storeAs('replacement_staff/profile_docs', $profile->file_name);
                $profile->replacement_staff()->associate($replacementStaff);
                $profile->save();
                $i++;
            }
        }

        //dd();
        //foreach ($request->profession as $key => $req) {
            /*dd($request);
            $profile = new Profile();
            if($request->hasFile('file')){
                foreach($request->file('file') as $key_file => $file) {
                    $profile->profession = 'enfermera';
                    $profile_filename = $file->getClientOriginalName();

                    $profile->file = $profile_filename;
                    $profile->replacement_staff()->associate($replacementStaff);
                    //$profile->replacement_staff()->associate(Auth::user());
                    $profile->save();

                }
            }*/
        //}

        session()->flash('success', 'Su perfil profesional ha sido ingresado.');
        return redirect()->back();
    }
}
