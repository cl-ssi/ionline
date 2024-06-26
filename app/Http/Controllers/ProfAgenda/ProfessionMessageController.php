<?php

namespace App\Http\Controllers\ProfAgenda;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Parameters\Parameter;
use App\Models\Parameters\Profession;
use App\Models\ProfAgenda\ProfessionMessage;

class ProfessionMessageController extends Controller
{
    public function index()
    {
        $professionMessages = ProfessionMessage::all();
        return view('prof_agenda.profession_messages.index',compact('professionMessages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $professions = explode(',',Parameter::where('parameter','profesiones_ust')->pluck('value')->toArray()[0]);
        $professions = Profession::whereIn('id',$professions)->get();
        return view('prof_agenda.profession_messages.create',compact('professions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $professionMessage = new ProfessionMessage($request->All());
      $professionMessage->save();

      session()->flash('info', 'El mensaje de la profesión ha sido registrada.');
      return redirect()->route('prof_agenda.profession_messages.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pharmacies\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(ProfessionMessage $professionMessage)
    {
        $professions = explode(',',Parameter::where('parameter','profesiones_ust')->pluck('value')->toArray()[0]);
        $professions = Profession::whereIn('id',$professions)->get();
        return view('prof_agenda.profession_messages.edit', compact('professionMessage','professions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pharmacies\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProfessionMessage $professionMessage)
    {
        $professionMessage->fill($request->all());
        $professionMessage->save();

        session()->flash('info', 'El mensaje de la profesión ha sido actualizada.');
        return redirect()->route('prof_agenda.profession_messages.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pharmacies\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProfessionMessage $professionMessage)
    {
      $professionMessage->delete();
      session()->flash('success', 'El mensaje de la profesión ha sido eliminado.');
      return redirect()->route('prof_agenda.profession_messages.index');
    }
}
