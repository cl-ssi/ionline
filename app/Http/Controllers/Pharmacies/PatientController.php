<?php

namespace App\Http\Controllers\Pharmacies;

use App\Models\Establishment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pharmacies\Patient;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $query = Patient::query();

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('full_name', 'LIKE', "%{$search}%")
                  ->orWhere('rut', 'LIKE', "%{$search}%");
            });
        }

        $patients = $query->orderBy('full_name', 'ASC')->paginate(50);
        return view('pharmacies.patients.index', compact('patients'));
    }

    public function create()
    {
        $establishments = Establishment::orderBy('name')->get();
        return view('pharmacies.patients.create', compact('establishments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|integer|unique:frm_patients,id',
            'dv' => 'required|string|max:1',
            'full_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'observation' => 'nullable|string|max:255',
            'address' => 'required|string|max:255',
            'establishment_id' => 'required|exists:establishments,id',
        ]);

        $patient = new Patient($validated);
        $patient->save();

        session()->flash('info', 'El paciente '.$patient->full_name.' ha sido creado.');
        return redirect()->route('pharmacies.patients.index');
    }

    public function show($id)
    {
        //
    }

    public function edit(Patient $patient)
    {
        $establishments = Establishment::orderBy('name')->get();
        return view('pharmacies.patients.edit', compact('patient', 'establishments'));
    }

    public function update(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'id' => 'required|integer|unique:frm_patients,id,'.$patient->id.',id',
            'dv' => 'required|string|max:1',
            'full_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'observation' => 'nullable|string|max:255',
            'address' => 'required|string|max:255',
            'establishment_id' => 'required|exists:establishments,id',
        ]);

        $patient->fill($validated);
        $patient->save();

        session()->flash('info', 'El paciente '.$patient->full_name.' ha sido editado.');
        return redirect()->route('pharmacies.patients.index');
    }

    public function destroy($id)
    {
        //
    }
}
