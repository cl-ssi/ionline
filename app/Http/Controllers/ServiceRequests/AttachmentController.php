<?php


namespace App\Http\Controllers\ServiceRequests;
use App\Http\Controllers\Controller;

use App\Models\ServiceRequests\Attachment;
use App\Models\ServiceRequests\Fulfillment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Fulfillment $var)
    {
        //        
        $files = $request->file('file');

        $i = 1;

        foreach ($files as $key_file => $file) {
            $attachment = new Attachment();            
            $file_name = $var->id.'_'.$i;
            $attachment->fulfillment_id = $var->id;
            $attachment->file = $file->storeAs('/ionline/service_request/fulfiments_attachment', $file_name.'.'.$file->extension(), 'gcs');
            foreach ($request->name as $req) {
                $attachment->name = $request->input('name.'.$key_file.'');
                $attachment->save();
            }
            
            $i++;

        }
        
        session()->flash('success', 'Su Adunto ha sido agregado exitosamente');
        return redirect()->back();
    }




    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ServiceRequests\Attachment  $attachment
     * @return \Illuminate\Http\Response
     * public function show_file(ReplacementStaff $replacementStaff)
    
     */
    public function show(Attachment $attachment)
    {
        //

        return Storage::disk('gcs')->response($attachment->file);
        
    }

    public function download(Attachment $attachment)
    {
        //

        return Storage::disk('gcs')->download($attachment->file);
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ServiceRequests\Attachment  $attachment
     * @return \Illuminate\Http\Response
     */
    public function edit(Attachment $attachment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ServiceRequests\Attachment  $attachment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attachment $attachment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ServiceRequests\Attachment  $attachment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attachment $attachment)
    {
        //        
        $attachment->delete();
        Storage::disk('gcs')->delete($attachment->file);

        session()->flash('danger', 'Su Archivo adjunto ha sido eliminado.');
        return redirect()->back();
    }
}
