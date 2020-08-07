<?php

namespace App\Http\Controllers\Indicators;

use App\Indicators\SingleParameter;
use App\Establishment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\Redirect;

class SingleParameterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /*$parameters = SingleParameter::Where('year',date('Y'))
                        ->orderBy('law', 'ASC')
                        ->orderBy('establishment_id', 'ASC')
                        ->orderBy('indicator', 'ASC')
                        ->get();*/
        $parameters = SingleParameter::Search($request)
            ->orderBy('created_at', 'DESC')
            ->orderBy('law', 'ASC')
            ->orderBy('establishment_id', 'ASC')
            ->orderBy('indicator', 'ASC')
            ->get();
        return view('indicators.single_parameter.index', compact('parameters'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $establishments = Establishment::All();
        return view('indicators.single_parameter.create', compact('establishments'));
    }


    public function comges($id, $indicador, $mes, $nd)
    {
        return view('indicators.single_parameter.comgescreate2020', compact('id', 'indicador', 'mes', 'nd'));
    }

    public function comgesmodal($id, $indicador, $mes, $nd)
    {
        return view('indicators.single_parameter.comgescreatemodal2020', compact('id', 'indicador', 'mes', 'nd'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->law <> 'Comges') {
            $singleParameter = SingleParameter::create($request->all());

            session()->flash('info', 'El parametro ' . $singleParameter->indicator . '
            del la ley ' . $singleParameter->law . ' año ' . $singleParameter->year . '
            ha sido creado.');

            return redirect()->route('indicators.single_parameter.index');
        } else {
            if ($request->id == 0) {
                $singleParameter = new SingleParameter($request->all());
                //todos los comges son de Iquique
                $singleParameter->establishment_id = 8;
                $singleParameter->description .= ' Digitado por: ' . auth()->user()->fullName;
                $singleParameter->save();
                session()->flash('success', $singleParameter->position . ' del Comges ' . $singleParameter->indicator . ' Creado Exitosamente');                
                return redirect(session('links')[0]);
                
            } else {               
                $singleParameter = SingleParameter::find($request->id); 
                $singleParameter->fill($request->All());
                $singleParameter->establishment_id = 8;
                $singleParameter->description .= ' Actualizado por: ' . auth()->user()->fullName;
                $singleParameter->save();
                session()->flash('success', $singleParameter->position . ' del Comges ' . $singleParameter->indicator . ' Creado Exitosamente');                
                return redirect(session('links')[0]);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\indicators\SingleParameter  $singleParameter
     * @return \Illuminate\Http\Response
     */
    public function show(SingleParameter $singleParameter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\indicators\SingleParameter  $singleParameter
     * @return \Illuminate\Http\Response
     */
    public function edit(SingleParameter $singleParameter)
    {
        $establishments = Establishment::All();
        return view(
            'indicators.single_parameter.edit',
            compact('singleParameter', 'establishments')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\indicators\SingleParameter  $singleParameter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SingleParameter $singleParameter)
    {
        $singleParameter->fill($request->all());

        $singleParameter->save();

        session()->flash('info', 'El parametro ' . $singleParameter->indicator . '
            del la ley ' . $singleParameter->law . ' año ' . $singleParameter->year . '
            ha sido actualizado.');

        return redirect()->route('indicators.single_parameter.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\indicators\SingleParameter  $singleParameter
     * @return \Illuminate\Http\Response
     */
    public function destroy(SingleParameter $singleParameter)
    {
        //
    }
}
