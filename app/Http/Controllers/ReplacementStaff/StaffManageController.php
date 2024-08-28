<?php

namespace App\Http\Controllers\ReplacementStaff;

use App\Http\Controllers\Controller;
use App\Models\ReplacementStaff\StaffManage;
use Illuminate\Http\Request;

use App\Models\Rrhh\OrganizationalUnit;

class StaffManageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $staffManages = StaffManage::selectRaw('organizational_unit_id, count(organizational_unit_id) AS people')
            ->groupBy('organizational_unit_id')
            ->orderBy('organizational_unit_id')
            ->get();
        return view('replacement_staff.staff_manage.index', compact('staffManages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ouRoots = OrganizationalUnit::where('level', 1)->get();
        return view('replacement_staff.staff_manage.create', compact('ouRoots'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        foreach ($request->replacement_staff_id as $key_file => $req) {
            $exist = StaffManage::where('replacement_staff_id', $req)
                ->where('organizational_unit_id', $request->ou_of_performance_id)
                ->get();

            if($exist->isEmpty()){
                $staffManage = new StaffManage();
                $staffManage->replacement_staff_id = $req;
                $staffManage->organizational_unit_id = $request->ou_of_performance_id;
                $staffManage->save();
            }
        }

        session()->flash('success', 'Estimado Usuario, el/los postulante(s) se agregarón exitosamente al Staff');
        return redirect()->route('replacement_staff.staff_manage.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StaffManage  $staffManage
     * @return \Illuminate\Http\Response
     */
    public function show(StaffManage $staffManage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StaffManage  $staffManage
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $staffManageByOu = StaffManage::
            with('replacementStaff', 'replacementStaff.profiles', 'replacementStaff.profiles.profile_manage', 
                'replacementStaff.profiles.profession_manage', 'organizationalUnit')
            ->where('organizational_unit_id', $id)
            ->get();

        return view('replacement_staff.staff_manage.edit', compact('staffManageByOu'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StaffManage  $staffManage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StaffManage $staffManage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StaffManage  $staffManage
     * @return \Illuminate\Http\Response
     */
    public function destroy($organizational_unit_id, $replacement_staff_id)
    {
        $staffManage = StaffManage::where('organizational_unit_id', $organizational_unit_id)
            ->where('replacement_staff_id', $replacement_staff_id)
            ->get();

        $staffManage->each->delete();

        $countStaffManage = StaffManage::where('organizational_unit_id', $organizational_unit_id)
            ->count();

        if($countStaffManage > 0){
            session()->flash('danger', 'Estimado Usuario: el postulante ha sido eliminado del Staff.');
            return redirect()->back();
        }
        else{
            session()->flash('danger', 'Estimado Usuario: el postulante ha sido eliminado del Staff.');
            return redirect()->route('replacement_staff.staff_manage.index');
        }

    }
}
