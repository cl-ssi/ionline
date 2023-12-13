<?php

namespace App\Http\Controllers\Pharmacies;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pharmacies\Batch;
use App\Models\Pharmacies\Dispatch;
use App\Models\Pharmacies\DispatchItem;
use App\Models\Pharmacies\DispatchVerificationMailing;
use App\Models\Pharmacies\Establishment;
use App\Models\Pharmacies\File;
use App\Models\Pharmacies\Product;

use Illuminate\Support\Facades\Storage;
use App\Exports\DispatchExport;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Support\Facades\Auth;

use App\Mail\DispatchVerificationNotification;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class DispatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      // $product_id = 196;
      // $due_date = '30/09/2023';
      // $products = Product::where('id',$product_id)
      //                    ->get();
      // //dd($products);
      // $matrix_batch = null;
      // $cont = 0;
      // foreach ($products as $key1 => $product) {
      //   foreach ($product->purchaseItems as $key1 => $purchaseItem) {
      //     if($purchaseItem->due_date == $due_date){
      //       $matrix_batch[$cont] = $purchaseItem->batch;
      //       $cont = $cont + 1;
      //     }
      //   }
      //   foreach ($product->receivingItems as $key1 => $receivingItems) {
      //     if($receivingItems->due_date == $due_date){
      //       $matrix_batch[$cont] = $receivingItems->batch;
      //       $cont = $cont + 1;
      //     }
      //   }
      // }
      // //$matrix_due_date=array_unique($matrix_due_date);
      // $matrix_batch=array_unique($matrix_batch);
      // dd($matrix_batch);
      // //return $matrix_batch;


      $dispatchs = Dispatch::where('pharmacy_id',session('pharmacy_id'))
                            ->with('establishment')
                            ->orderBy('id','DESC')
                            ->paginate(200);
                           // dd($dispatchs);
      return view('pharmacies.products.dispatch.index', compact('dispatchs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $establishments = Establishment::where('pharmacy_id',session('pharmacy_id'))
                                       ->orderBy('name','ASC')->get();
        return view('pharmacies.products.dispatch.create',compact('establishments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $dispatch = new Dispatch($request->all());
      $dispatch->pharmacy_id = session('pharmacy_id');
      $dispatch->user_id = Auth::id();
      $dispatch->save();

      session()->flash('success', 'Se ha guardado el encabezado del egreso.');
      return redirect()->route('pharmacies.products.dispatch.show', $dispatch);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pharmacy\Dispatch  $dispatch
     * @return \Illuminate\Http\Response
     */
    public function show(Dispatch $dispatch)
    {
      // 04/10: Esteban comenta este codigo puesto que ya se incorporó en livewire hace tiempo atrás.
      // //obtiene fechas de vencimiento y lotes de todos los ingresos y compras de todos los productos.
      // $products = Product::with(['purchaseItems','receivingItems'])
      //     ->where('pharmacy_id',session('pharmacy_id'))
      //     ->orderBy('name', 'ASC')->get();
          
      // $matrix_due_date = null;
      // $cont = 0;
      // foreach ($products as $key1 => $product) {
      //   foreach ($product->purchaseItems as $key1 => $purchaseItem) {
      //     $matrix_due_date[$cont] = $purchaseItem->due_date;
      //     $cont = $cont + 1;
      //   }
      //   foreach ($product->receivingItems as $key1 => $receivingItems) {
      //     $matrix_due_date[$cont] = $receivingItems->due_date;
      //     $cont = $cont + 1;
      //   }
      // }
      // $matrix_batch = null;
      // $cont = 0;
      // foreach ($products as $key1 => $product) {
      //   foreach ($product->purchaseItems as $key1 => $purchaseItem) {
      //     $matrix_batch[$cont] = $purchaseItem->batch;
      //     $cont = $cont + 1;
      //   }
      //   foreach ($product->receivingItems as $key1 => $receivingItems) {
      //     $matrix_batch[$cont] = $receivingItems->batch;
      //     $cont = $cont + 1;
      //   }
      // }
      // if($matrix_due_date){
      //   $matrix_due_date=array_unique();
      // }
      
      // if($matrix_batch){
      //   $matrix_batch=array_unique();
      // }
      

      $establishment = Establishment::find($dispatch->establishment_id);
      $products = Product::where('pharmacy_id',session('pharmacy_id'))
                         ->orderBy('name','ASC')->get();
      return view('pharmacies.products.dispatch.show', compact('establishment','dispatch','products'));
      // return view('pharmacies.products.dispatch.show', compact('establishment','dispatch','products','matrix_due_date','matrix_batch'));
    }

    public function getFromProduct_due_date($product_id){
      $products = Product::where('id',$product_id)->get();
      $matrix_due_date = null;
      $cont = 0;
      foreach ($products as $key1 => $product) {
        foreach ($product->purchaseItems as $key1 => $purchaseItem) {
          $matrix_due_date[$cont] = $purchaseItem->due_date;
          $cont = $cont + 1;
        }
        foreach ($product->receivingItems as $key1 => $receivingItems) {
          $matrix_due_date[$cont] = $receivingItems->due_date;
          $cont = $cont + 1;
        }
      }

      $matrix_due_date=array_unique($matrix_due_date);
      //$matrix_batch=array_unique($matrix_batch);

      return $matrix_due_date;
    }

    public function getFromProduct_batch($product_id, $due_date){
      $products = Product::where('id',$product_id)
                         ->get();
      $matrix_batch = null;
      $cont = 0;
      foreach ($products as $key1 => $product) {
        foreach ($product->purchaseItems as $key1 => $purchaseItem) {
          if($purchaseItem->due_date == $due_date){
            $matrix_batch[$cont] = $purchaseItem->batch;
            $cont = $cont + 1;
          }
        }
        foreach ($product->receivingItems as $key1 => $receivingItems) {
          if($receivingItems->due_date == $due_date){
            $matrix_batch[$cont] = $receivingItems->batch;
            $cont = $cont + 1;
          }
        }
      }
      //$matrix_due_date=array_unique($matrix_due_date);
      $matrix_batch=array_unique($matrix_batch);

      return $matrix_batch;
    }

    public function getFromProduct_count($product_id, $due_date, $batch){
      $batch = str_replace("*", "/", $batch);
      $products = Product::where('id',$product_id)->get();
      $cont = 0;
      foreach ($products as $key1 => $product) {
        foreach ($product->purchaseItems as $key1 => $purchaseItem) {
          if($purchaseItem->due_date == $due_date && $purchaseItem->batch == $batch){
            $cont = $cont + $purchaseItem->amount;
          }
        }
        foreach ($product->receivingItems as $key1 => $receivingItems) {
          if($receivingItems->due_date == $due_date && $receivingItems->batch == $batch){
            $cont = $cont + $receivingItems->amount;
          }
        }
        foreach ($product->dispatchItems as $key1 => $dispatchItem) {
          if($dispatchItem->due_date == $due_date && $dispatchItem->batch == $batch){
            $cont = $cont - $dispatchItem->amount;
          }
        }
      }

      return $cont;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pharmacy\Dispatch  $dispatch
     * @return \Illuminate\Http\Response
     */
    public function edit(Dispatch $dispatch)
    {
		//obtiene fechas de vencimiento y lotes de todos los ingresos y compras de todos los productos.
		$products = Product::with(['purchaseItems','receivingItems'])
			->where('pharmacy_id',session('pharmacy_id'))
			->orderBy('name', 'ASC')->get();

      $matrix_due_date = null;
      $cont = 0;
      foreach ($products as $key1 => $product) {
        foreach ($product->purchaseItems as $key1 => $purchaseItem) {
          $matrix_due_date[$cont] = $purchaseItem->due_date;
          $cont = $cont + 1;
        }
        foreach ($product->receivingItems as $key1 => $receivingItems) {
          $matrix_due_date[$cont] = $receivingItems->due_date;
          $cont = $cont + 1;
        }
      }
      $matrix_batch = null;
      $cont = 0;
      foreach ($products as $key1 => $product) {
        foreach ($product->purchaseItems as $key1 => $purchaseItem) {
          $matrix_batch[$cont] = $purchaseItem->batch;
          $cont = $cont + 1;
        }
        foreach ($product->receivingItems as $key1 => $receivingItems) {
          $matrix_batch[$cont] = $receivingItems->batch;
          $cont = $cont + 1;
        }
      }
      if ($matrix_due_date!=null) {
        $matrix_due_date=array_unique($matrix_due_date);
      }
      if ($matrix_batch!=null) {
        $matrix_batch=array_unique($matrix_batch);
      }
      //dd(array_unique($matrix_due_date));
      //dd($matrix_due_date, $matrix_batch);

      $establishments = Establishment::where('pharmacy_id',session('pharmacy_id'))
                                     ->orderBy('name','ASC')->get();
      $products = Product::where('pharmacy_id',session('pharmacy_id'))
                         ->orderBy('name','ASC')->get();
      return view('pharmacies.products.dispatch.edit', compact('establishments','dispatch','products','matrix_due_date','matrix_batch'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pharmacy\Dispatch  $dispatch
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dispatch $dispatch)
    {
      $dispatch->fill($request->all());
      $dispatch->user_id = Auth::id();
      $dispatch->save();
      //$computer->users()->sync($request->input('users'));
      session()->flash('success', 'El egreso ha sido actualizado.');
      return redirect()->route('pharmacies.products.dispatch.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pharmacy\Dispatch  $dispatch
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dispatch $dispatch)
    {
      //se modifica el stock del producto
      $amount = 0;
      foreach ($dispatch->dispatchItems as $key => $dispatchItem){
        $product = Product::find($dispatchItem->product_id);
        $product->stock = $product->stock + $dispatchItem->amount;
        $product->save();

        if($product->program_id == 46){ //APS ORTESIS
          $product->load('establishments');
          $establishment_id = Dispatch::find($dispatchItem->dispatch_id)->establishment_id;
          $pass = false;
          foreach($product->establishments as $establishment)
            if($establishment->id == $establishment_id){
                $establishment->pivot->decrement('stock', $dispatchItem->amount);
                $pass = true;
            }
          if(!$pass){
            $product->establishments()->attach($establishment_id, ['stock' => -$dispatchItem->amount]);
          }
        }

        $dispatchItem->delete();
      }

      //se elimina la cabecera y detalles
      $dispatch->delete();
      session()->flash('success', 'La entrega se ha sido eliminado');
      return redirect()->route('pharmacies.products.dispatch.index');
    }

    public function record(Dispatch $dispatch)
    {
        return view('pharmacies.products.dispatch.record', compact('dispatch'));
    }

    public function sendC19(Dispatch $dispatch)
    {
      //obtiene cabecera
      $array_dispatch = $dispatch->toArray();
      $array_dispatch = array_add($array_dispatch, 'pharmacy', $dispatch->pharmacy->name);
      $array_dispatch = array_add($array_dispatch, 'establishment', $dispatch->establishment->name);
      $array_dispatch = array_add($array_dispatch, 'user', $dispatch->user->getFullNameAttribute());;

      //obtiene detalles
      $flag = 0;
      $array_dispatchItems = $dispatch->dispatchItems->toArray();
      foreach ($dispatch->dispatchItems as $key => $dispatchItem) {
        //verificar si es epp
        if($dispatchItem->product->category->id == 6){
          //verificar si es CENABAST 41, MERCADO PUBLICO 39, CAMPAÑA INVIERNO 24, nCOVID-19 35, DONACIÓN 38
          if($dispatchItem->product->program->id == 41 || $dispatchItem->product->program->id == 39 || $dispatchItem->product->program->id == 24 ||
             $dispatchItem->product->program->id == 35 || $dispatchItem->product->program->id == 38){
            $flag = 1;
            $array_dispatchItems[$key] = array_add($array_dispatchItems[$key], 'product', $dispatchItem->product->name);
          }else{unset($array_dispatchItems[$key]);} //se elimina producto
        }else{unset($array_dispatchItems[$key]);} //se elimina producto
      }

      //dd($flag, $array_dispatch, $array_dispatchItems);

      if($flag == 1){
        //envia información a servidor
        // $url_base = "http://127.0.0.1:80/endpoint/receiveDispatchC19";
        $url_base = "https://i.saludtarapaca.gob.cl/monitor/endpoint/receiveDispatchC19";
        $client = new \GuzzleHttp\Client();
        $request = $client->get($url_base, [
                                'query' => ['dispatch' => urldecode(json_encode($array_dispatch, true)),
                                            'dispatchItems' => urldecode(json_encode($array_dispatchItems, true))]
                            ]);

        $dispatch->sendC19 = 1;
        $dispatch->save();

        //dd($request);
        //echo $request->getQuery();
        //echo $request->getBody();
        //dd($request->getBody());
        // $response = $request->getBody();
        session()->flash('success', 'Se subió la información');
        return redirect()->route('pharmacies.products.dispatch.index');
      }else{
        session()->flash('warning', 'No existen productos para subir.');
        return redirect()->route('pharmacies.products.dispatch.index');
      }
    }

    public function deleteC19(Dispatch $dispatch)
    {
      //envia información a servidor
      // $url_base = "http://127.0.0.1:80/endpoint/deleteDispatchC19";
      $url_base = "https://i.saludtarapaca.gob.cl/monitor/endpoint/deleteDispatchC19";
      $client = new \GuzzleHttp\Client();
      $request = $client->get($url_base, [
                              'query' => ['dispatch_id' => $dispatch->id]
                          ]);
      $dispatch->sendC19 = 0;
      $dispatch->save();

      session()->flash('success', 'Se eliminó la información');
      return redirect()->route('pharmacies.products.dispatch.index');
    }

    public function storeFile(Request $request, Dispatch $dispatch)
    {
      if($request->hasFile('filename'.$dispatch->id)){
        // foreach($request->file('filename') as $file) {
          $file = $request->file('filename'.$dispatch->id);
          $filename = $file->getClientOriginalName();
          $fileModel = New File();
          //$fileModel->file = $file->store('pharmacies');
          $fileModel->file = $file->store('ionline/pharmacies',['disk' => 'gcs']);
          $fileModel->name = $filename;
          $fileModel->dispatch_id = $dispatch->id;
          $fileModel->save();
        // }
      }

      session()->flash('success', 'Se guardó el archivo correctamente');
      return redirect()->route('pharmacies.products.dispatch.index');
    }

    public function openFile(Dispatch $dispatch)
    {
        if($dispatch->files){
            $file = $dispatch->files->first();
            return Storage::disk('gcs')->response($file->file, mb_convert_encoding($file->name,'ASCII'));
        }else{
            session()->flash('warning', 'No existe el archivo.');
            return redirect()->back();
        }
        
    }

    public function exportExcel(){
        return Excel::download(new DispatchExport, 'entregas.xlsx');
    }



    // desde aqui se hace funcionalidad para enviar correos solicitando confirmación de recepción

    public function sendEmailValidation(Dispatch $dispatch)
    {
      if($dispatch->establishment->email == null ){
        session()->flash('warning', 'El establecimiento no tiene correo electrónico asignado.');
        return redirect()->back();
      }

      foreach($dispatch->verificationMailings->where('status','Pendiente') as $verificationMailing){
        $verificationMailing->status = "Verificación cancelada.";
        $verificationMailing->sender_observation = "Se ha creado nueva verificación.";
        $verificationMailing->save();
      }

      $dispatchVerificationMailing = new DispatchVerificationMailing();
      $dispatchVerificationMailing->dispatch_id = $dispatch->id;
      $dispatchVerificationMailing->status = "Pendiente";
      $dispatchVerificationMailing->sender_observation = null;
      $dispatchVerificationMailing->delivery_date = Carbon::now();
      $dispatchVerificationMailing->save();

      $base64encode = base64_encode($dispatch->id);
      $dispatch->base64encode = $base64encode;

      Mail::to($dispatch->establishment->email)->send(new DispatchVerificationNotification($dispatch));

      session()->flash('success', 'El correo ha sido enviado correctamente.');
      return redirect()->back();
    }

    public function confirmationDispatchVerificationNotification($id){
      $dispatch = Dispatch::find(base64_decode($id));

      if($dispatch->verificationMailings->count() == 0){
        session()->flash('danger', 'No se han encontrado solicitudes de confirmación en nuestros registros.');
        return view('pharmacies.products.dispatch.outview');
      }

      if($dispatch->verificationMailings->where('status','Pendiente')->count() == 0){
        session()->flash('danger', 'No se han encontrado solicitudes pendientes de confirmación en nuestros registros.');
        return view('pharmacies.products.dispatch.outview');
      }

      foreach($dispatch->verificationMailings->where('status','Pendiente') as $verificationMailing){
        $verificationMailing->status = "Recepción conforme por destinatario";
        $verificationMailing->receiver_observation = "Sin observaciones";
        $verificationMailing->confirmation_date = Carbon::now();
        $verificationMailing->save();
      }
      session()->flash('success', 'La solicitud fue confirmada.');
      return view('pharmacies.products.dispatch.outview');
    }

    public function confirmationWithObservationsDispatchVerificationNotification($id){
      $dispatch = Dispatch::find(base64_decode($id));

      if($dispatch->verificationMailings->count() == 0){
        session()->flash('danger', 'No se han encontrado solicitudes de recepción en nuestros registros.');
        return view('pharmacies.products.dispatch.outview');
      }

      if($dispatch->verificationMailings->where('status','Pendiente')->count() == 0){
        session()->flash('danger', 'No se han encontrado solicitudes de recepción pendientes de confirmación en nuestros registros.');
        return view('pharmacies.products.dispatch.outview');
      }

      return view('pharmacies.products.dispatch.outview',compact('dispatch'));
    }

    public function cancelDispatchVerificationNotification($id){
      $dispatch = Dispatch::find(base64_decode($id));

      if($dispatch->verificationMailings->count() == 0){
        session()->flash('danger', 'No se han encontrado solicitudes de recepción en nuestros registros.');
        return view('pharmacies.products.dispatch.outview');
      }

      if($dispatch->verificationMailings->where('status','Pendiente')->count() == 0){
        session()->flash('danger', 'No se han encontrado solicitudes pendientes de confirmación en nuestros registros.');
        return view('pharmacies.products.dispatch.outview');
      }

      foreach($dispatch->verificationMailings->where('status','Pendiente') as $verificationMailing){
        $verificationMailing->status = "Recepción anulada por destinatario";
        $verificationMailing->receiver_observation = "Sin observaciones";
        $verificationMailing->confirmation_date = Carbon::now();
        $verificationMailing->save();
      }
      session()->flash('success', 'La solicitud de recepción fue anulada.');
      return view('pharmacies.products.dispatch.outview');
    }

    public function storeVerification(Request $request){
      $dispatch = Dispatch::find($request->dispatch_id);

      if(!$dispatch){
        session()->flash('danger', 'No se ha encontrado la solicitud de entrega enviada.');
        return view('pharmacies.products.dispatch.outview');
      }

      if($dispatch->verificationMailings->count() == 0){
        session()->flash('danger', 'No se han encontrado solicitudes de confirmación en nuestros registros.');
        return view('pharmacies.products.dispatch.outview');
      }

      if($dispatch->verificationMailings->where('status','Pendiente')->count() == 0){
        session()->flash('danger', 'No se han encontrado solicitudes pendientes de confirmación en nuestros registros.');
        return view('pharmacies.products.dispatch.outview');
      }

      foreach($dispatch->verificationMailings->where('status','Pendiente') as $verificationMailing){
        $verificationMailing->status = "Recepción conforme por destinatario";
        $verificationMailing->receiver_observation = $request->observation;
        $verificationMailing->confirmation_date = Carbon::now();
        $verificationMailing->save();
      }
      session()->flash('success', 'La solicitud de recepción con observaciones fué ingresada.');
      return view('pharmacies.products.dispatch.outview');
    }

    public function storePrivateVerification(Dispatch $dispatch){

      if($dispatch->establishment->email == null ){
        session()->flash('warning', 'El establecimiento no tiene correo electrónico asignado.');
        return redirect()->back();
      }

      foreach($dispatch->verificationMailings->where('status','Pendiente') as $verificationMailing){
        $verificationMailing->status = "Verificación cancelada.";
        $verificationMailing->sender_observation = "Se ha creado nueva verificación.";
        $verificationMailing->save();
      }

      $dispatchVerificationMailing = new DispatchVerificationMailing();
      $dispatchVerificationMailing->dispatch_id = $dispatch->id;
      $dispatchVerificationMailing->status = "Pendiente";
      $dispatchVerificationMailing->sender_observation = null;
      $dispatchVerificationMailing->delivery_date = Carbon::now();
      $dispatchVerificationMailing->status = "Recepción conforme por origen";
      $dispatchVerificationMailing->receiver_observation = "Sin observaciones";
      $dispatchVerificationMailing->confirmation_date = Carbon::now();
      $dispatchVerificationMailing->save();

      session()->flash('success', 'La recepción fué ingresada.');
      return redirect()->back();
    }

    public function dispatchingProductsWs(Request $request){
        try {

            $dataArray = json_decode($request->getContent(), true);

            // encabezado

            // if (!isset($dataArray['dispatch']['notes']) || $dataArray['dispatch']['notes'] == '') {
            //     $responseArray = ['status' => false,'message' => 'Debe ingresar "notes"'];
            //     return json_encode($responseArray);
            // }

            if (!isset($dataArray['dispatch']['establishment_id']) || $dataArray['dispatch']['establishment_id'] == '') {
                $responseArray = ['status' => false, 'message' => 'Debe ingresar "establishment_id" (Destino)'];
                return json_encode($responseArray);
            }

            

            foreach($dataArray['dispatch_items'] as $dispatch_item){
                
                // producto

                if (!isset($dispatch_item['product']['experto_id']) || $dispatch_item['product']['experto_id'] == '') {
                    $responseArray = ['status' => false,'message' => 'Debe ingresar "experto_id"'];
                    return json_encode($responseArray);
                }
    
                //se verifica existencia del producto de ingreso
                $product = Product::where('experto_id',$dispatch_item['product']['experto_id'])->first();
    
                if(!$product){
                    $responseArray = ['status' => false, 'message' => 'El producto (experto_id), no existe en Ionline.'];
                    return json_encode($responseArray);
                }

                // detalle

                if (!isset($dispatch_item['unity']) || $dispatch_item['unity'] == '') {
                    $responseArray = ['status' => false,'message' => 'Debe ingresar "unity"'];
                    return json_encode($responseArray);
                }

                if (!isset($dispatch_item['due_date']) || $dispatch_item['due_date'] == '') {
                    $responseArray = ['status' => false,'message' => 'Debe ingresar "due_date"'];
                    return json_encode($responseArray);
                }

                if (!isset($dispatch_item['batch']) || $dispatch_item['batch'] == '') {
                    $responseArray = ['status' => false,'message' => 'Debe ingresar "batch"'];
                    return json_encode($responseArray);
                }

                if (!isset($dispatch_item['amount']) || $dispatch_item['amount'] == '') {
                    $responseArray = ['status' => false,'message' => 'Debe ingresar "amount"'];
                    return json_encode($responseArray);
                }

                $batch = Batch::where('product_id',$product->id)
                                ->where('due_date',$dispatch_item['due_date'])
                                ->where('batch',$dispatch_item['batch'])
                                ->first();
                if(!$batch){
                    $responseArray = ['status' => false,'message' => 'No existe stock creado para el producto-fvenc-lote ingresado.'];
                    return json_encode($responseArray);
                }else{
                    if($batch->count < $dispatch_item['amount']){
                        $responseArray = ['status' => false,'message' => 'No existe stock suficiente para realizar el despacho.'];
                        return json_encode($responseArray);
                    }
                }
            }

            

            // se guarda encabezado del ingreso
            $dispatch = new Dispatch();
            
            $dispatch->date = now();
            $dispatch->pharmacy_id = 10; //Recursos Físicos - HETG
            $dispatch->establishment_id = $dataArray['dispatch']['establishment_id']; 
            $dispatch->user_id = 11162352;
            $dispatch->notes = isset($dataArray['dispatch']['notes']) ? $dataArray['dispatch']['notes'] : null;
            $dispatch->save();


            // se guarda detalle del ingres    
            foreach($dataArray['dispatch_items'] as $dispatch_item){

                if($product){
                    $product->stock = $product->stock - $dispatch_item['amount'];
                    $product->save();
                }

                $dispatchItem = new dispatchItem();
                $dispatchItem->barcode = $product->barcode;
                $dispatchItem->dispatch_id = $dispatch->id;
                $dispatchItem->product_id = $product->id;
                $dispatchItem->amount = $dispatch_item['amount'];
                $dispatchItem->unity = $dispatch_item['unity'];
                $dispatchItem->due_date = $dispatch_item['due_date'];
                $dispatchItem->batch = $dispatch_item['batch'];
                $dispatchItem->created_at = now();
                $dispatchItem->save();
            }    
            

            //Respuesta
            $responseArray = ['status' => true,'dispatch_id' => $dispatch->id];
            return json_encode($responseArray);

        } catch (\Exception $e) {
            $responseArray = ['status' => false,'message' => $e->getMessage()];
            return json_encode($responseArray);
        }
    }

}
