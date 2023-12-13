<?php

namespace App\Http\Controllers\Pharmacies;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pharmacies\Receiving;
use App\Models\Pharmacies\ReceivingItem;
use App\Models\Pharmacies\Establishment;
use App\Models\Pharmacies\Product;
use Illuminate\Support\Facades\Auth;

class ReceivingController extends Controller
{
    /**
    * Instantiate a new controller instance.
    *
    * @return void
    */
    // public function __construct()
    // {
    //     $this->middleware('permission:Pharmacy: manager')->only('create');
    //     //$this->middleware('subscribed')->except('store');
    // }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $receivings = Receiving::where('pharmacy_id',session('pharmacy_id'))
                                ->with('establishment')
                                ->orderBy('id','DESC')
                                ->paginate(200);
        return view('pharmacies.products.receiving.index', compact('receivings'));
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
        return view('pharmacies.products.receiving.create',compact('establishments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $receiving = new Receiving($request->all());
        $receiving->pharmacy_id = session('pharmacy_id');
        $receiving->user_id = Auth::id();
        $receiving->save();

        session()->flash('success', 'Se ha guardado el encabezado del ingreso.');
        return redirect()->route('pharmacies.products.receiving.show', $receiving);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pharmacy\Receiving  $receiving
     * @return \Illuminate\Http\Response
     */
    public function show(Receiving $receiving)
    {
        $establishment = Establishment::where('pharmacy_id',session('pharmacy_id'))
                                      ->find($receiving->establishment_id);
        $products = Product::where('pharmacy_id',session('pharmacy_id'))
                           ->orderBy('name','ASC')->get();
        return view('pharmacies.products.receiving.show',compact('establishment','receiving','products'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pharmacy\Receiving  $receiving
     * @return \Illuminate\Http\Response
     */
    public function edit(Receiving $receiving)
    {
      $establishments = Establishment::where('pharmacy_id',session('pharmacy_id'))
                                     ->orderBy('name','ASC')->get();
      $products = Product::where('pharmacy_id',session('pharmacy_id'))
                         ->orderBy('name','ASC')->get();
      return view('pharmacies.products.receiving.edit', compact('establishments','receiving','products'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pharmacy\Receiving  $receiving
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Receiving $receiving)
    {
      $receiving->fill($request->all());
      $receiving->user_id = Auth::id();
      $receiving->save();
      //$computer->users()->sync($request->input('users'));
      session()->flash('success', 'El ingreso ha sido actualizado.');
      return redirect()->route('pharmacies.products.receiving.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pharmacy\Receiving  $receiving
     * @return \Illuminate\Http\Response
     */
    public function destroy(Receiving $receiving)
    {
        //se modifica el stock del producto
        $amount = 0;
        $flag = 0;
        foreach ($receiving->receivingItems as $key => $receivingItem){
            $product = Product::find($receivingItem->product_id);

            if($product){
                $product->stock = $product->stock - $receivingItem->amount;
                $product->save();

                $receivingItem->delete();
            }else{
                $flag=1;
            }
        }

        if($flag==0)
        {
            //se elimina la cabecera y detalles
            $receiving->delete();
            session()->flash('success', 'El ingreso se ha sido eliminado');
            return redirect()->route('pharmacies.products.receiving.index');
        }
        else
        {
            session()->flash('warning', 'Se han eliminad detalles, pero no se ha eliminado el ingreso por que no se encontró uno de los productos. Intente nuevamente.');
            return redirect()->route('pharmacies.products.receiving.index');
        }
        
    }

    public function record(Receiving $receiving)
    {
        return view('pharmacies.products.receiving.record', compact('receiving'));
    }

    public function receivingProductsWs(Request $request){
        try {
            $dataArray = json_decode($request->getContent(), true);

            // encabezado

            // if (!isset($dataArray['receiving']['notes']) || $dataArray['receiving']['notes'] == '') {
            //     $responseArray = ['status' => false,'message' => 'Debe ingresar "notes"'];
            //     return json_encode($responseArray);
            // }

            // if (!isset($dataArray['receiving']['order_number']) || $dataArray['receiving']['order_number'] == '') {
            //     $responseArray = ['status' => false,'message' => 'Debe ingresar "order_number"'];
            //     return json_encode($responseArray);
            // }

            // producto

            foreach($dataArray['receiving_items'] as $receiving_item){
                
                // detalle

                if (!isset($receiving_item['unity']) || $receiving_item['unity'] == '') {
                    $responseArray = ['status' => false,
                        'message' => 'Debe ingresar "unity"'];
                    return json_encode($responseArray);
                }

                if (!isset($receiving_item['due_date']) || $receiving_item['due_date'] == '') {
                    $responseArray = ['status' => false,
                        'message' => 'Debe ingresar "due_date"'];
                    return json_encode($responseArray);
                }

                if (!isset($receiving_item['batch']) || $receiving_item['batch'] == '') {
                    $responseArray = ['status' => false,
                        'message' => 'Debe ingresar "batch"'];
                    return json_encode($responseArray);
                }

                if (!isset($receiving_item['amount']) || $receiving_item['amount'] == '') {
                    $responseArray = ['status' => false,
                        'message' => 'Debe ingresar "amount"'];
                    return json_encode($responseArray);
                }

                // productos

                if (!isset($receiving_item['product']['experto_id']) || $receiving_item['product']['experto_id'] == '') {
                    $responseArray = ['status' => false,
                        'message' => 'Debe ingresar "experto_id"'];
                    return json_encode($responseArray);
                }

                // if (!isset($receiving_item['product']['barcode']) || $receiving_item['product']['barcode'] == '') {
                //     $responseArray = ['status' => false,'message' => 'Debe ingresar "barcode"'];
                //     return json_encode($responseArray);
                // }

                if (!isset($receiving_item['product']['name']) || $receiving_item['product']['name'] == '') {
                    $responseArray = ['status' => false,
                        'message' => 'Debe ingresar "name"'];
                    return json_encode($responseArray);
                }

                if (!isset($receiving_item['product']['unit']) || $receiving_item['product']['unit'] == '') {
                    $responseArray = ['status' => false,
                        'message' => 'Debe ingresar "unit"'];
                    return json_encode($responseArray);
                }

                // if (!isset($receiving_item['product']['expiration']) || $receiving_item['product']['expiration'] == '') {
                //     $responseArray = ['status' => false,'message' => 'Debe ingresar "expiration"'];
                //     return json_encode($responseArray);
                // }

                // if (!isset($receiving_item['product']['price']) || $receiving_item['product']['price'] == '') {
                //     $responseArray = ['status' => false,'message' => 'Debe ingresar "price"'];
                //     return json_encode($responseArray);
                // }

                // if (!isset($receiving_item['product']['critic_stock']) || $receiving_item['product']['critic_stock'] == '') {
                //     $responseArray = ['status' => false,'message' => 'Debe ingresar "critic_stock"'];
                //     return json_encode($responseArray);
                // }

                // if (!isset($receiving_item['product']['min_stock']) || $receiving_item['product']['min_stock'] == '') {
                //     $responseArray = ['status' => false,'message' => 'Debe ingresar "min_stock"'];
                //     return json_encode($responseArray);
                // }

                // if (!isset($receiving_item['product']['max_stock']) || $receiving_item['product']['max_stock'] == '') {
                //     $responseArray = ['status' => false,'message' => 'Debe ingresar "max_stock"'];
                //     return json_encode($responseArray);
                // }

                // if (!isset($receiving_item['product']['storage_conditions']) || $receiving_item['product']['storage_conditions'] == '') {
                //     $responseArray = ['status' => false,'message' => 'Debe ingresar "storage_conditions"'];
                //     return json_encode($responseArray);
                // }

            }

            

            // se guarda encabezado del ingreso
            $receiving = new Receiving();
            $receiving->establishment_id = 377; // Sistema experto
            $receiving->pharmacy_id = 10; //Recursos Físicos - HETG
            $receiving->user_id = 11162352;
            $receiving->date = now();
            $receiving->notes = isset($dataArray['receiving']['notes']) ? $dataArray['receiving']['notes'] : null;
            $receiving->order_number = isset($dataArray['receiving']['order_number']) ? $dataArray['receiving']['order_number'] : null;
            $receiving->save();


            // se guarda detalle del ingres    
            foreach($dataArray['receiving_items'] as $receiving_item){

                //se guarda producto del ingreso
                $product = Product::where('experto_id',$receiving_item['product']['experto_id'])->first();

                if(!$product){
                    // nuevo producto
                    $product = new Product();
                    $product->barcode = isset($receiving_item['product']['barcode']) ? $receiving_item['product']['barcode'] : null;
                    $product->name = $receiving_item['product']['name']; //** 
                    $product->unit = $receiving_item['product']['unit']; //** 
                    $product->expiration = isset($receiving_item['product']['expiration']) ? $receiving_item['product']['expiration'] : null;
                    $product->price = isset($receiving_item['product']['price']) ? $receiving_item['product']['price'] : null;
                    $product->stock = $receiving_item['amount']; //** 
                    $product->critic_stock = isset($receiving_item['product']['critic_stock']) ? $receiving_item['product']['critic_stock'] : null;
                    $product->min_stock = isset($receiving_item['product']['min_stock']) ? $receiving_item['product']['min_stock'] : null;
                    $product->max_stock = isset($receiving_item['product']['max_stock']) ? $receiving_item['product']['max_stock'] : null;
                    $product->storage_conditions = isset($receiving_item['product']['storage_conditions']) ? $receiving_item['product']['storage_conditions'] : null;
                    $product->pharmacy_id = 10; //Recursos Físicos - HETG  //** 
                    $product->category_id = 9; // Recursos físicos
                    $product->program_id = 90; // Recursos físicos
                    $product->experto_id = $receiving_item['product']['experto_id']; //** 
                    $product->save();
                }else{

                    // actualiza stock del producto
                    $product->stock = $product->stock + $receiving_item['amount'];
                    $product->save();
                }


                $ReceivingItem = new ReceivingItem();
                $ReceivingItem->barcode = isset($receiving_item['product']['barcode']) ? $receiving_item['product']['barcode'] : null;
                $ReceivingItem->receiving_id = $receiving->id;
                $ReceivingItem->product_id = $product->id;
                $ReceivingItem->amount = $receiving_item['amount'];
                $ReceivingItem->unity = $receiving_item['unity'];
                $ReceivingItem->due_date = $receiving_item['due_date'];
                $ReceivingItem->batch = $receiving_item['batch'];
                $ReceivingItem->created_at = now();
                $ReceivingItem->save();
            }    
            

            

            //Respuesta
            $responseArray = ['status' => true,'receiving_id' => $receiving->id];
            return json_encode($responseArray);

        } catch (\Exception $e) {
            $responseArray = ['status' => false,'message' => $e->getMessage()];
            return json_encode($responseArray);
        }
    }
}
