<?php

namespace App\Http\Controllers\RequestForms;;

use App\Models\RequestForms\RequestFormMessage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\RequestForms\RequestForm;
use Illuminate\Support\Facades\Auth;

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
    public function store(Request $request, RequestForm $requestForm, $eventType)
    {
        $message = new RequestFormMessage($request->All());
        $message->user()->associate(Auth::user());
        $message->requestForm()->associate($requestForm);
        $message->save();

        return redirect()
           ->to(route('request_forms.sign',[
             'requestForm' => $requestForm,
             'eventType' => $eventType
             ]).'#message');
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
}
