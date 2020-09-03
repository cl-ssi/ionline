<?php

namespace App\Http\Controllers\Agreements;

use App\Agreements\Addendum;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class AddendumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $addendum = new Addendum($request->All());
        if($request->hasFile('file'))
            $addendum->file = $request->file('file')->store('addendums');
        $addendum->save();

        session()->flash('info', 'El addendum '.$addendum->number.' ha sido creado.');

        return redirect()->back();
    }

    // METODO PARA ACTUALIZAR LA ETAPA DESDE LA TABLA DE SEGUIMIENTO DE CONVENIOS
    public function update(Request $request, $id)
    {
        //dd($request);
        $addendum = Addendum::find($id);
        $addendum->number = $request->number;
        $addendum->date = $request->date;
        if($request->hasFile('file')){
            Storage::delete($addendum->file);
            $addendum->file = $request->file('file')->store('addendums');
        }
        $addendum->save();
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Agreements\Addendum  $addendum
     * @return \Illuminate\Http\Response
     */
    public function show(Addendum $addendum)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Agreements\Addendum  $addendum
     * @return \Illuminate\Http\Response
     */
    public function edit(Addendum $addendum)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Agreements\Addendum  $addendum
     * @return \Illuminate\Http\Response
     */

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Agreements\Addendum  $addendum
     * @return \Illuminate\Http\Response
     */
    public function destroy(Addendum $addendum)
    {
        //
    }

    public function download(Addendum $file)
    {
        return Storage::response($file->file, mb_convert_encoding($file->name,'ASCII'));
    }
}
