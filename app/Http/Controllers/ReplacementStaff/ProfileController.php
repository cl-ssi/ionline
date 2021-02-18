<?php

namespace App\Http\Controllers\ReplacementStaff;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ReplacementStaff\Profile;

class ProfileController extends Controller
{

    public function store(Request $request, $replacementStaff)
    {
        foreach ($request->profession as $key => $req) {
            $profile = new Profile();
            if($request->hasFile('file')){
                foreach($request->file('file') as $key_file => $file) {
                    $profile->profession = $req;
                    $profile_filename = $file->getClientOriginalName();
                    // dd($profile_filename);
                    $profile->file = $profile_filename;
                    $profile->replacement_staff()->associate($replacementStaff);
                    //$profile->replacement_staff()->associate(Auth::user());
                    //$profile->file = $request->store('profile_docs');
                    $profile->save();
                    // dd($profile);
                }
            }
        }

        session()->flash('success', 'Su perfil profesional ha sido ingresado.');
        return redirect()->back();
    }
}
