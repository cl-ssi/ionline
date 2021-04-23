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
        $files = $request->file('file');

        if($request->hasFile('file'))
        {
            foreach ($files as $key_file => $file) {
                /* BB.DD. */
                $profile = new Profile();
                $profile->profile_manage_id = $request->input('profile.'.$key_file.'');
                $profile->profession_manage_id = $request->input('profession.'.$key_file.'');
                $profile->degree_date = $request->input('degree_date.'.$key_file.'');
                $profile->replacement_staff()->associate($replacementStaff);
                //$profile->replacement_staff()->associate(Auth::user());
                foreach ($request->profession as $key_profession => $req) {
                    /* FILE */
                    $key_profession++;
                    $now = Carbon::now()->format('Y_m_d_H_i_s');
                    $file_name = $now.'_'.$key_profession.'_'.$replacementStaff->run;
                    $profile->file = $file->storeAs('/ionline/replacement_staff/profile_docs/', $file_name.'.'.$file->extension(), 'gcs');
                    $profile->save();
                }
            }
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
