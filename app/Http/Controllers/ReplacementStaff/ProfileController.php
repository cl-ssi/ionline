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

        session()->flash('success', 'Su perfil profesional ha sido ingresado.');
        return redirect()->back();
    }

    public function download(Profile $profile)
    {
        return Storage::download($profile->file);
    }

    public function show_file(Profile $profile)
    {
        return Storage::response($profile->file);
    }

    public function destroy(Profile $profile)
    {
        $profile->delete();
        Storage::delete($profile->file);

        session()->flash('danger', 'Su perfil profesional ha sido eliminado.');
        return redirect()->back();
    }


}
