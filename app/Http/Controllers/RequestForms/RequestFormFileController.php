<?php

namespace App\Http\Controllers\RequestForms;

use App\Models\RequestForms\RequestFormFile;
use App\RequestForms\RequestForms\RequestForm;
use App\RequestForms\RequestForms\RequestFormEvent;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RequestFormFileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('request_form.file.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, RequestForm $requestForm)
    {
        $request_form_id=$requestForm->id;
        if($request->hasFile('forfile')){
          foreach($request->file('forfile') as $file) {
            $filename = $file->getClientOriginalName();
            $fileModel = New RequestFormFile;
            $fileModel->file = $file->store('request_form');
            $fileModel->name = $filename;
            $fileModel->request_form_id = $request_form_id;
            $fileModel->user()->associate(Auth::user());
            $fileModel->save();
          }
        }

        session()->flash('info', 'Se adjunto archivo/s con exito');
        return redirect()->route('request_forms.edit', compact('requestForm'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RequestFormFile  $requestFormFile
     * @return \Illuminate\Http\Response
     */
    public function show(RequestFormFile $requestFormFile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RequestFormFile  $requestFormFile
     * @return \Illuminate\Http\Response
     */
    public function edit(RequestFormFile $requestFormFile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RequestFormFile  $requestFormFile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RequestFormFile $requestFormFile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RequestFormFile  $requestFormFile
     * @return \Illuminate\Http\Response
     */
    public function destroy(RequestFormFile $requestFormFile)
    {
        //
    }

    public function show_file(RequestFormFile $requestFormFile)
    {
        return Storage::disk('gcs')->response($requestFormFile->file, $requestFormFile->name);
    }

    public function download(RequestFormFile $requestFormFile)
    {
        return Storage::disk('gcs')->download($requestFormFile->file,  $requestFormFile->name);
    }
}
