<?php

namespace App\Http\Controllers\ReplacementStaff;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ReplacementStaff\ReplacementStaff;
use App\Models\ReplacementStaff\Profile;
use App\Models\UserExternal;
use Illuminate\Support\Facades\DB;
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
        $replacementStaff = ReplacementStaff::paginate(15);
        return view('replacement_staff.index', compact('replacementStaff'));
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

            $replacementStaff = new ReplacementStaff();
            $replacementStaff->run = $userexternal->id;

            return view('replacement_staff.create',compact('replacementStaff'));

        }
        else{
            
            return $this->edit($replacementStaff);
        }
        
        //return view('replacement_staff.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $replacementStaff = new ReplacementStaff($request->All());
        $replacementStaff->status = 'available';
        $replacementStaff->save();

        session()->flash('success', 'Se ha creado el postulante exitosamente');
        //return redirect()->back();
        return redirect()->route('replacement_staff.edit', $replacementStaff);
    }

    public function edit(ReplacementStaff $replacementStaff)
    {
        // $profiles = Profile::where('replacement_staff_id', $replacementStaff->id)
        //     ->get();

        return view('replacement_staff.edit', compact('replacementStaff'));
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
