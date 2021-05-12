<?php

namespace App\Http\Controllers\ReplacementStaff;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ReplacementStaff\Profile;
use App\Models\ReplacementStaff\ReplacementStaff;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{

    public function store(Request $request, ReplacementStaff $replacementStaff)
    {
        // ID (1,3)
        if($request->profile == 1 or $request->profile == 3){
            $profile = new Profile();
            $profile->profile_manage_id = $request->profile;
            $profile->replacement_staff()->associate($replacementStaff);
            $now = Carbon::now()->format('Y_m_d_H_i_s');
            $file = $request->file('file');
            $file_name = $now.'_'.$replacementStaff->run;
            $profile->file = $file->storeAs('/ionline/replacement_staff/profile_docs/', $file_name.'.'.$file->extension(), 'gcs');
            $profile->save();
        }
        else{
            $profile = new Profile();
            $profile->degree_date = $request->degree_date;
            $profile->profile_manage_id = $request->profile;
            $profile->profession_manage_id = $request->profession;
            $profile->experience = $request->experience;
            $profile->replacement_staff()->associate($replacementStaff);
            $now = Carbon::now()->format('Y_m_d_H_i_s');
            $file = $request->file('file');
            $file_name = $now.'_'.$replacementStaff->run;
            $profile->file = $file->storeAs('/ionline/replacement_staff/profile_docs/', $file_name.'.'.$file->extension(), 'gcs');
            $profile->save();
        }

        session()->flash('success', 'Su perfil profesional ha sido ingresado.');
        return redirect()->back();
    }

    public function download(Profile $profile)
    {
        return Storage::disk('gcs')->download($profile->file);
    }

    public function show_file(Profile $profile)
    {
        return Storage::disk('gcs')->response($profile->file);
    }

    public function destroy(Profile $profile)
    {
        $profile->delete();
        Storage::disk('gcs')->delete($profile->file);

        session()->flash('danger', 'Su perfil profesional ha sido eliminado.');
        return redirect()->back();
    }


}
