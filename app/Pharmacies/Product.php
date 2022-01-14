<?php

namespace App\Pharmacies;

use Illuminate\Database\Eloquent\Model;
use App\Pharmacies\Unit;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'barcode', 'name', 'unit', 'expiration',
        //'batch',
        'price', 'stock',
        'critic_stock', 'storage_conditions', 'category_id', 'program_id', 'id'
    ];

    protected $table = 'frm_products';

    use SoftDeletes;

    //relaciones
    public function pharmacy()
    {
      return $this->belongsTo('App\Pharmacies\Pharmacy');
    }

    public function category()
    {
      return $this->belongsTo('App\Pharmacies\Category');
    }

    public function program()
    {
      return $this->belongsTo('App\Pharmacies\Program');
    }

    public function receivingItems()
    {
      return $this->hasMany('App\Pharmacies\ReceivingItem');
    }

    public function purchaseItems()
    {
      return $this->hasMany('App\Pharmacies\PurchaseItem');
    }

    public function dispatchItems()
    {
      return $this->hasMany('App\Pharmacies\DispatchItem');
    }

    public function establishments()
    {
      return $this->belongsToMany('App\Pharmacies\Establishment', 'frm_establishments_products')
                              ->withPivot('id', 'stock', 'critic_stock', 'max_stock')
                              ->withTimestamps();
    }

    public function getQuantityAttribute(){
      return $this->establishments->sum('pivot.stock');
    }

    public function scopeSearchBincard($query, $dateFrom, $dateTo, $product_id) {

        $matrix = null;
        $matrix[0]['tipo'] = '';

        if($dateFrom != "" AND $dateTo != "") {
            $data = collect();

            /* compras */
            $purchaseItems = PurchaseItem::whereHas('purchase', function ($query) use ($dateFrom,$dateTo){
                                                     //$query->whereBetween('date', [$dateFrom,$dateTo]);
                                                     $query->where('date', '>=', $dateFrom);
                                                   })
                                      ->WhereHas('product', function($query) use ($product_id) {
                                                        $query->when($product_id, function ($q, $product_id) {
                                                           return $q->where('id', $product_id);
                                                        });
                                                   })->get();
            $purchaseItems->each(function($purchaseItems){
                $purchaseItems->purchase;
                $purchaseItems->product;
            });
            $data->push($purchaseItems);

            /* ingresos */
            $receivingItems= ReceivingItem::whereHas('receiving', function ($query) use ($dateFrom,$dateTo) {
                                                     //$query->whereBetween('date', [$dateFrom,$dateTo]);
                                                     $query->where('date', '>=', $dateFrom);
                                                   })
                                        ->WhereHas('product', function($query) use ($product_id) {
                                                      $query->when($product_id, function ($q, $product_id) {
                                                         return $q->where('id', $product_id);
                                                      });
                                                   })->get();
            $receivingItems->each(function($receivingItems){
                $receivingItems->receiving;
                $receivingItems->product;
            });
            $data->push($receivingItems);

            /* entregas */
            $dispatchItems= DispatchItem::whereHas('dispatch', function ($query) use ($dateFrom,$dateTo) {
                                                     //$query->whereBetween('date', [$dateFrom,$dateTo]);
                                                     $query->where('date', '>=', $dateFrom);
                                                   })
                                        ->WhereHas('product', function($query) use ($product_id) {
                                                      $query->when($product_id, function ($q, $product_id) {
                                                         return $q->where('id', $product_id);
                                                      });
                                                   })->get();
            $dispatchItems->each(function($dispatchItems){
                $dispatchItems->dispatch;
                $dispatchItems->product;
            });
            $data->push($dispatchItems);

            //dd($data);

            //obtener saldo del Product
            $producto = Product::find($product_id);
            $saldo = $producto->stock;

            //ciclo para generar estructura para enviar a informe
            $cont = 0;
            foreach ($data as $key1 => $Collection) {
                foreach ($Collection as $key2 => $CollectionItem) {
                    if ($key1==0) {
                        //$saldo = $saldo + $CollectionItem->amount;
                        $matrix[$cont]['tipo'] = 'Compra';
                        $matrix[$cont]['type'] = 'purchase';
                        $matrix[$cont]['id'] = $CollectionItem->purchase->id;
                        //$matrix[$cont]['date'] = $CollectionItem->created_at->format("Y-m-d H:i:s");
                        $matrix[$cont]['date'] = $CollectionItem->purchase->date->format("Y-m-d");
                        $matrix[$cont]['origen_destino'] = $CollectionItem->purchase->supplier->name;
                        //$matrix[$cont]['ingreso'] = $CollectionItem->amount;
                        //$matrix[$cont]['salida'] = 0;
                        //$matrix[$cont]['saldo'] = $saldo;
                        $matrix[$cont]['amount'] = $CollectionItem->amount;
                        $matrix[$cont]['notas'] = $CollectionItem->purchase->notes;

                        $matrix[$cont]['act_number'] = null;
                        $matrix[$cont]['product_batch'] = null;
                        $matrix[$cont]['file'] = null;
                    }
                    if ($key1==1) {
                        //$saldo = $saldo + $CollectionItem->amount;
                        $matrix[$cont]['tipo'] = 'Ingreso';
                        $matrix[$cont]['type'] = 'receiving';
                        $matrix[$cont]['id'] = $CollectionItem->receiving->id;
                        //$matrix[$cont]['date'] = $CollectionItem->created_at->format("Y-m-d H:i:s");
                        $matrix[$cont]['date'] = $CollectionItem->receiving->date->format("Y-m-d");
                        $matrix[$cont]['origen_destino'] = $CollectionItem->receiving->establishment->name;
                        //$matrix[$cont]['ingreso'] = $CollectionItem->amount;
                        //$matrix[$cont]['salida'] = 0;
                        //$matrix[$cont]['saldo'] = $saldo;
                        $matrix[$cont]['amount'] = $CollectionItem->amount;
                        $matrix[$cont]['notas'] = $CollectionItem->receiving->notes;

                        $matrix[$cont]['act_number'] = null;
                        $matrix[$cont]['product_batch'] = null;
                        $matrix[$cont]['file'] = null;
                    }
                    if ($key1==2) {
                        //$saldo = $saldo - $CollectionItem->amount;
                        $matrix[$cont]['tipo'] = 'Salida';
                        $matrix[$cont]['type'] = 'dispatch';
                        $matrix[$cont]['id'] = $CollectionItem->dispatch->id;
                        //$matrix[$cont]['date'] = $CollectionItem->created_at->format("Y-m-d H:i:s");
                        $matrix[$cont]['date'] = $CollectionItem->dispatch->date->format("Y-m-d");
                        $matrix[$cont]['origen_destino'] = $CollectionItem->dispatch->establishment->name;
                        //$matrix[$cont]['ingreso'] = 0;
                        //$matrix[$cont]['salida'] = $CollectionItem->amount;
                        //$matrix[$cont]['saldo'] = $saldo;
                        $matrix[$cont]['amount'] = $CollectionItem->amount;
                        $matrix[$cont]['notas'] = $CollectionItem->dispatch->notes;

                        $matrix[$cont]['act_number'] = $CollectionItem->dispatch->id;
                        $matrix[$cont]['product_batch'] = $CollectionItem->batch;
                        $matrix[$cont]['file'] = $CollectionItem->dispatch;
                    }

                    $cont = $cont + 1;
                }
            }

            //si no hay datos
            if ($matrix == NULL) {
              goto salida;
            }

            //se ordena según fecha
            usort($matrix, array($this, "ordenamiento_lejano"));

            //dd($matrix[0]['tipo']);

            if($matrix[0]['tipo']<>"")
            {

            //obtiene saldos
            foreach ($matrix as $key => $item) {
              if ($key == 0) {
                if ($item['type'] == 'dispatch') {
                  $matrix[$key]['ingreso'] = 0;
                  $matrix[$key]['salida'] = $item['amount'];
                  $matrix[$key]['saldo'] = $saldo;
                }
                else{
                  $matrix[$key]['ingreso'] = $item['amount'];
                  $matrix[$key]['salida'] = 0;
                  $matrix[$key]['saldo'] = $saldo;
                }
              }

              else{
                if ($matrix[$key-1]['type'] == 'purchase') {
                  $saldo = $saldo - $matrix[$key-1]['amount'];//$item['amount'];
                  $matrix[$key]['saldo'] = $saldo;
                }
                if ($matrix[$key-1]['type'] == 'receiving') {
                  $saldo = $saldo - $matrix[$key-1]['amount'];//$item['amount'];
                  $matrix[$key]['saldo'] = $saldo;
                }
                if ($matrix[$key-1]['type'] == 'dispatch') {
                  $saldo = $saldo + $matrix[$key-1]['amount'];//$item['amount'];
                  $matrix[$key]['saldo'] = $saldo;
                }
              }
            }

            //muestra ingresos y salidas
            foreach ($matrix as $key => $item) {
              if ($key <> 0) {
                if ($matrix[$key]['type'] == 'purchase') {
                  $matrix[$key]['ingreso'] = $item['amount'];
                  $matrix[$key]['salida'] = 0;
                }
                if ($matrix[$key]['type'] == 'receiving') {
                  $matrix[$key]['ingreso'] = $item['amount'];
                  $matrix[$key]['salida'] = 0;
                }
                if ($matrix[$key]['type'] == 'dispatch') {
                  $matrix[$key]['ingreso'] = 0;
                  $matrix[$key]['salida'] = $item['amount'];
                }
              }
            }

            }


            //dd($matrix);
            //dd($matrix);
            /*foreach ($data as $key1 => $Collection) {
                foreach ($Collection as $key2 => $CollectionItem) {
                    //compras
                    if ($key1==0) {
                      //si es el primer dato, se deja el saldo (según formato de informe)
                      if ($key1 == 0 && $key2 == 0) {
                        $saldo = $saldo;
                      }
                      else{
                        $saldo = $saldo + $CollectionItem->amount;
                      }
                      //$saldo = $saldo + $CollectionItem->amount;
                      $matrix[$cont]['ingreso'] = $CollectionItem->amount;
                      $matrix[$cont]['salida'] = 0;
                      $matrix[$cont]['saldo'] = $saldo;
                    }
                    //ingresos
                    if ($key1==1) {
                      //si es el primer dato, se deja el saldo (según formato de informe)
                      if ($key1 == 0 && $key2 == 0) {
                        $saldo = $saldo;
                      }
                      else{
                        $saldo = $saldo + $CollectionItem->amount;
                      }
                      //$saldo = $saldo + $CollectionItem->amount;
                      $matrix[$cont]['ingreso'] = $CollectionItem->amount;
                      $matrix[$cont]['salida'] = 0;
                      $matrix[$cont]['saldo'] = $saldo;
                    }
                    //egresos
                    if ($key1==2) {
                      //si es el primer dato, se deja el saldo (según formato de informe)
                      if ($key1 == 0 && $key2 == 0) {
                        $saldo = $saldo;
                      }
                      else{
                        $saldo = $saldo - $CollectionItem->amount;
                      }
                      //$saldo = $saldo - $CollectionItem->amount;
                      $matrix[$cont]['ingreso'] = 0;
                      $matrix[$cont]['salida'] = $CollectionItem->amount;
                      $matrix[$cont]['saldo'] = $saldo;
                    }
                    $cont = $cont + 1;
                }
            }*/

            //se vuelve a ordenar por fecha pero al revez (más antiguas al principio)
            //usort($matrix, array($this, "ordenamiento_cercano"));
        }

        salida:
        //dd($matrix);
        return $matrix;
    }

    //función para order arreglo según fechas - más lejano primero
    public function ordenamiento_lejano($b,$a) {
        return strtotime($a["date"]) - strtotime($b["date"]);
    }
    //función para order arreglo según fechas - más cercano primero
    public function ordenamiento_cercano($a,$b) {
        return strtotime($a["date"]) - strtotime($b["date"]);
    }

    public function ordenamiento_fecha_vencimiento($a,$b) {
        return strtotime($a["due_date"]) - strtotime($b["due_date"]);
    }

    public function scopeSearchConsumosHistoricos($query, $year, $category_id, $establishment_id) {
      //obtiene lista de productos
      $products = Product::where('pharmacy_id',session('pharmacy_id'))
                         ->when($category_id, function ($query, $category_id) {
                              return $query->where('category_id', $category_id);
                           })->get();

      //obtiene entregas
      $dispatchItems= DispatchItem::whereHas('dispatch', function ($query) use ($year, $establishment_id) {
                                             $query->when($establishment_id, function ($query, $establishment_id) {
                                                        return $query->where('establishment_id', $establishment_id);
                                                     })->where('pharmacy_id',session('pharmacy_id'))
                                                       ->whereYear('date', $year);
                                    })
                                    ->whereHas('product', function ($query) use ($category_id) {
                                             $query->when($category_id, function ($query, $category_id) {
                                                        return $query->where('category_id', $category_id);
                                                     });
                                    })->get();
      $matrix = null;
      //para setear valores en cero
      foreach ($products as $key => $product) {
        $matrix[$product->name]['product_name'] = $product->name;
        $matrix[$product->name]['category'] = $product->category->name;
        $matrix[$product->name]['stock'] = $product->stock;
        for ($i=1; $i <= 12 ; $i++) {
          $matrix[$product->name][$i] = 0;
        }
      }
      //se obtienen valores y se asignan a matriz
      foreach ($products as $key => $product) {
        $total = 0;
        for ($i=1; $i <= 12 ; $i++) {
          foreach ($dispatchItems as $key => $dispatchItem) {
            if ($dispatchItem->dispatch->date->month == $i && $dispatchItem->product_id == $product->id) {
              $matrix[$product->name][$i] = $matrix[$product->name][$i] + $dispatchItem->amount;
              $total = $total + $dispatchItem->amount;
              //$matrix[$product->name]['product_name'] = $dispatchItem->product->name;
              //$matrix[$product->name]['category'] = $dispatchItem->product->category->name;
              //$matrix[$product->name]['stock'] = $dispatchItem->product->stock;
            }
          }
        }
        $matrix[$product->name]['total'] = $total;
      }
      //dd($matrix);
      return $matrix;
    }

    public function scopeSearchProducts($query, $product_id, $program) {
      //$product_id = 1;
      $cont = 0;

      $matrix[0] = null;
      $PurchaseItems = PurchaseItem::when($product_id, function ($query, $product_id) {
                                        return $query->where('product_id',$product_id);
                                     })
                                   ->whereHas('purchase', function ($query) {
                                        return $query->where('pharmacy_id',session('pharmacy_id'));
                                     })
                                   ->get();

      foreach ($PurchaseItems as $key => $PurchaseItem) {
        $matrix[$cont]=$PurchaseItem;
        $cont = $cont + 1;
      }

      $ReceivingItems = ReceivingItem::when($product_id, function ($query, $product_id) {
                                        return $query->where('product_id',$product_id);
                                     })
                                     ->whereHas('receiving', function ($query) {
                                          return $query->where('pharmacy_id',session('pharmacy_id'));
                                       })
                                    ->get();
      foreach ($ReceivingItems as $key => $ReceivingItem) {
        $matrix[$cont]=$ReceivingItem;
        $cont = $cont + 1;
      }

      $DispatchItems = DispatchItem::when($product_id, function ($query, $product_id) {
                                        return $query->where('product_id',$product_id);
                                     })
                                     ->whereHas('dispatch', function ($query) {
                                          return $query->where('pharmacy_id',session('pharmacy_id'));
                                       })
                                     ->get();
      /*foreach ($DispatchItems as $key => $DispatchItem) {
        $matrix[$cont]=$DispatchItem;
        $cont = $cont + 1;
      }*/


      // dd($matrix[0]);

      //Dejar solo los distinct (fecha vencimiento y lote/serial) - se suman cantidades de ingreso
      $final[0] = null;
      $cont = 0;
      if ($matrix[0]  <> null) {
        foreach ($matrix as $key => $data) {
          $flag = 0;

          //TODO se agrega validación if $final, comparar con bd final
          if($final[0] <> null){
              foreach ($final as $key2 => $f) {
                  if ($f['product_id'] == $data->product_id && $f['due_date'] == $data->due_date && $f['batch'] == $data->batch) {
                      $flag = 1;
                      $f['cantidad'] = $f['cantidad'] + $data->amount;
                  }
              }
          }

          if ($flag == 0) {
            $final[$cont] = $data;
            $final[$cont]['cantidad'] = $final[$cont]['cantidad'] + $data->amount;
            $cont = $cont + 1;
          }
        }
      }

      // dd($final);

      //se restan cantidades entregadas según lote y f.venc.
      foreach ($final as $key => $data) {
        foreach ($DispatchItems as $key => $DispatchItem) {
          if ($data['product_id'] == $DispatchItem->product_id && $data['due_date'] == $DispatchItem->due_date && $data['batch'] == $DispatchItem->batch) {
            $data['cantidad'] = $data['cantidad'] - $DispatchItem->amount;
          }
        }
      }

      //usort($final, array($this, "ordenamiento_fecha_vencimiento"));
      //usort($final, 'order');
      $data = null;
      foreach ($final as $key => $i) {
        if($program != NULL){
            // print_r(strtoupper($i->product->program->name) ." *** ". strtoupper($program)." ***".strpos(strtoupper($i->product->program->name), strtoupper($program)). "<br />");
            // $flag = strpos(strtoupper($i->product->program->name), strtoupper($program));
            $mystring = strtoupper($i->product->program->name);
            $word = strtoupper($program);
            $flag = false;
            if(strpos($mystring, $word) !== false){
                $flag = true;
            }

            // if($flag == false){$flag=-1;}
            // print_r($flag);
            if ($flag == true) {
                // dd(strpos(strtoupper($i->product->program->name), strtoupper($program)), $key);
                $data[$key]['name'] = $i->product->name;
                $data[$key]['due_date'] = $i->due_date;//Carbon::parse();
                $data[$key]['batch'] = $i->batch;
                $data[$key]['cantidad'] = $i->cantidad;
                $data[$key]['program'] = $i->product->program->name;
            }
        }else{
          if ($i!=null) {
            $data[$key]['name'] = $i->product->name;
            $data[$key]['due_date'] = $i->due_date;//Carbon::parse();
            $data[$key]['batch'] = $i->batch;
            $data[$key]['cantidad'] = $i->cantidad;
            $data[$key]['program'] = $i->product->program->name;
          }
        }
      }

      // dd($data);

      if($data != null){
        usort($data, array($this, "ordenamiento_fecha_vencimiento"));
    }else{
        $data[0] = null;
    }

      // dd($data);

      //usort($data, 'SORT_ASC');

      // dd($data);
      return $data;
    }

    // Comparator function used for comparator
    // scores of two object/students
    public function comparator($object1, $object2) {
        return $object1->name > $object2->name;
    }


}
