<?php


namespace App\Http\Controllers\Rrhh;

use App\Models\Rrhh\OrganizationalUnit;
use App\Http\Controllers\Controller;
use App\Models\Profile\Subrogation;

use Illuminate\Http\Request;

class SubrogationController extends Controller
{
    //
    public function create(OrganizationalUnit $organizationalUnit)
    {
        
        $subrogations = Subrogation::where('organizational_unit_id',$organizationalUnit->id)->orderBy('level', 'asc')->get();
        return view('rrhh.new_authorities.create_subrogant',compact('organizationalUnit','subrogations'));
    }

    public function store(Request $request)
{
    $validatedData = $request->validate([
        'user_id' => 'required|integer',
        'organizational_unit_id' => 'required|integer',
        'type' => 'required|string|max:255',
        'level' => 'required|integer|min:1',
    ]);

    $existingSubrogation = Subrogation::where('level', $validatedData['level'])
        ->where('organizational_unit_id', $validatedData['organizational_unit_id'])
        ->where('type', $validatedData['type'])
        ->first();

    if ($existingSubrogation) {
        return back()->withInput()->withErrors(['level' => 'Ya existe un usuario con ese nivel, tipo y unidad organizacional']);
    }

    $subrogation = new Subrogation($validatedData);
    $subrogation->subrogant_id = $validatedData['user_id'];
    $subrogation->save();

    session()->flash('info', 'Fue creado como usuario subrogante');
    return redirect()->route('rrhh.new-authorities.calendar', $request->organizational_unit_id);
}

    
}
