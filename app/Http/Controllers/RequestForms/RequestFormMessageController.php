<?php

namespace App\Http\Controllers\RequestForms;;

use App\Models\RequestForms\RequestFormMessage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\RequestForms\RequestForm;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class RequestFormMessageController extends Controller
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
    public function store(Request $request, RequestForm $requestForm, $eventType, $from)
    {
        $message = new RequestFormMessage($request->All());
        $message->user()->associate(Auth::user());
        $message->requestForm()->associate($requestForm);

        if($request->hasFile('file')){
            $now = Carbon::now()->format('Y_m_d_H_i_s');
            $file_name = $now.'_message_file_'.$requestForm->id;
            $message->file = $request->file->storeAs('ionline/request_forms/messages', $file_name.'.'.$request->file->extension(), 'gcs');
            //$reqFile->file = $fileRequest->storeAs('/ionline/request_forms/request_files', $file_name.'.'.$fileRequest->extension(), 'gcs');
            $filename = $request->file->getClientOriginalName();
            $message->file_name = $filename;
        }

        $message->save();

        if($from == 'signature'){
            return redirect()
               ->to(route('request_forms.sign',[
                 'requestForm' => $requestForm,
                 'eventType' => $eventType
                 ]).'#message');
        }
        if($from == 'show'){
            return redirect()
               ->to(route('request_forms.show',[
                 'requestForm' => $requestForm]).'#message');
        }
        if($from == 'purchase'){
            return redirect()
               ->to(route('request_forms.supply.purchase',[
                 'requestForm' => $requestForm]).'#message');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RequestFormMessage  $requestFormMessage
     * @return \Illuminate\Http\Response
     */
    public function show(RequestFormMessage $requestFormMessage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RequestFormMessage  $requestFormMessage
     * @return \Illuminate\Http\Response
     */
    public function edit(RequestFormMessage $requestFormMessage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RequestFormMessage  $requestFormMessage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RequestFormMessage $requestFormMessage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RequestFormMessage  $requestFormMessage
     * @return \Illuminate\Http\Response
     */
    public function destroy(RequestFormMessage $requestFormMessage)
    {
        //
    }

    public function show_file(RequestFormMessage $requestFormMessage)
    {
        return Storage::disk('gcs')->response($requestFormMessage->file);
    }
}
