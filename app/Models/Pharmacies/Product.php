<?php

namespace App\Models\Pharmacies;

use Illuminate\Database\Eloquent\Model;
use App\Models\Pharmacies\Unit;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Product extends Model implements Auditable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'barcode','experto_id','unspsc_product_id', 'name', 'unit', 'expiration',
        //'batch',
        'price', 'stock',
        'critic_stock','min_stock','max_stock','pharmacy_id',
        'storage_conditions', 'category_id', 'program_id'
    ];

    protected $table = 'frm_products';

    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    //relaciones
    public function pharmacy()
    {
      return $this->belongsTo('App\Models\Pharmacies\Pharmacy');
    }

    public function category()
    {
      return $this->belongsTo('App\Models\Pharmacies\Category');
    }

    public function program()
    {
      return $this->belongsTo('App\Models\Pharmacies\Program');
    }

    public function receivingItems()
    {
      return $this->hasMany('App\Models\Pharmacies\ReceivingItem');
    }

    public function purchaseItems()
    {
      return $this->hasMany('App\Models\Pharmacies\PurchaseItem');
    }

    public function dispatchItems()
    {
      return $this->hasMany('App\Models\Pharmacies\DispatchItem');
    }

    public function fractionationItems()
    {
      return $this->hasMany('App\Models\Pharmacies\FractionationItem');
    }

    public function batchs()
    {
      return $this->hasMany('App\Models\Pharmacies\Batch')->orderBy('due_date');
    }

    public function destines()
    {
      return $this->belongsToMany('App\Models\Pharmacies\Destiny', 'frm_destines_products')
                              ->withPivot('id', 'stock', 'critic_stock', 'max_stock')
                              ->withTimestamps();
    }

    public function getQuantityAttribute(){
      return $this->destines->sum('pivot.stock');
    }

    public function scopeSearchBincard($query, $dateFrom, $dateTo, $product_id) {
        if (!$product_id) {
            return [['tipo' => '']];
        }

        // Obtener todas las transacciones sin filtro de fecha inicial
        $purchases = PurchaseItem::with(['purchase' => function ($q) {
                $q->with('supplier');
            }])
            ->where('product_id', $product_id)
            ->whereHas('purchase')
            ->get()
            ->map(function ($item) {
                return [
                    'tipo' => 'Compra',
                    'type' => 'purchase',
                    'id' => $item->purchase->id,
                    'date' => $item->purchase->date->format('Y-m-d'),
                    'origen_destino' => $item->purchase->supplier->name ?? '',
                    'amount' => $item->amount,
                    'notas' => $item->purchase->notes,
                    'act_number' => null,
                    'product_batch' => null,
                    'file' => null,
                    'ingreso' => $item->amount,
                    'salida' => 0
                ];
            });

        $receivings = ReceivingItem::with(['receiving.destiny'])
            ->where('product_id', $product_id)
            ->whereHas('receiving')
            ->get()
            ->map(function ($item) {
                return [
                    'tipo' => 'Ingreso',
                    'type' => 'receiving',
                    'id' => $item->receiving->id,
                    'date' => $item->receiving->date->format('Y-m-d'),
                    'origen_destino' => $item->receiving->destiny->name ?? '',
                    'amount' => $item->amount,
                    'notas' => $item->receiving->notes,
                    'act_number' => null,
                    'product_batch' => null,
                    'file' => null,
                    'ingreso' => $item->amount,
                    'salida' => 0
                ];
            });

        $dispatches = DispatchItem::with(['dispatch.destiny', 'dispatch.receiver'])
            ->where('product_id', $product_id)
            ->whereHas('dispatch')
            ->get()
            ->map(function ($item) {
                return [
                    'tipo' => 'Salida',
                    'type' => 'dispatch',
                    'id' => $item->dispatch->id,
                    'date' => $item->dispatch->date->format('Y-m-d'),
                    'origen_destino' => ($item->dispatch->destiny->name ?? '') . ' ' . ($item->dispatch->receiver->shortName ?? ''),
                    'amount' => $item->amount,
                    'notas' => $item->dispatch->notes,
                    'act_number' => $item->dispatch->id,
                    'product_batch' => $item->batch,
                    'file' => $item->dispatch,
                    'ingreso' => 0,
                    'salida' => $item->amount
                ];
            });

        $fractionations = FractionationItem::with(['fractionation.patient', 'fractionation.medic'])
            ->where('product_id', $product_id)
            ->whereHas('fractionation')
            ->get()
            ->map(function ($item) {
                return [
                    'tipo' => 'Fraccionamiento',
                    'type' => 'fractionation',
                    'id' => $item->fractionation->id,
                    'date' => $item->fractionation->date->format('Y-m-d'),
                    'origen_destino' => ($item->fractionation->patient->name ?? '') . ' ' . ($item->fractionation->medic->shortName ?? ''),
                    'amount' => $item->amount,
                    'notas' => $item->fractionation->notes,
                    'act_number' => null,
                    'product_batch' => null,
                    'file' => null,
                    'ingreso' => 0,
                    'salida' => $item->amount
                ];
            });

        // Ordenar y calcular saldos para todos los movimientos
        $allMovements = $purchases->concat($receivings)
            ->concat($dispatches)
            ->concat($fractionations)
            ->sortBy('date')
            ->values();

        // Calcular saldos para todos los movimientos
        $saldo = 0;
        $allMovements = $allMovements->map(function($item) use (&$saldo) {
            if ($item['tipo'] == 'Compra' || $item['tipo'] == 'Ingreso') {
                $saldo += $item['amount'];
            } else {
                $saldo -= $item['amount'];
            }
            $item['saldo'] = $saldo;
            return $item;
        });

        // Filtrar por rango de fechas solicitado
        $filteredMovements = $allMovements
            ->when($dateFrom, function($collection) use ($dateFrom) {
                return $collection->filter(function($item) use ($dateFrom) {
                    return $item['date'] >= $dateFrom;
                });
            })
            ->when($dateTo, function($collection) use ($dateTo) {
                return $collection->filter(function($item) use ($dateTo) {
                    return $item['date'] <= $dateTo;
                });
            })
            ->reverse()  // Invertir el orden final para mostrar más reciente primero
            ->values()
            ->toArray();

        return $filteredMovements ?: [['tipo' => '']];
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

    public function scopeSearchConsumosHistoricos($query, $year, $category_id, $program_id, $destiny_id) {
        //obtiene lista de productos
        $products = Product::where('pharmacy_id',session('pharmacy_id'))
                            ->when($category_id, function ($query, $category_id) {
                                return $query->where('category_id', $category_id);
                            })
                            ->when($program_id, function ($query, $program_id) {
                                return $query->where('program_id', $program_id);
                            })
                            ->with('category','program')
                            ->get();

      //obtiene entregas
      $dispatchItems= DispatchItem::whereHas('dispatch', function ($query) use ($year, $destiny_id) {
                                             $query->when($destiny_id, function ($query, $destiny_id) {
                                                        return $query->where('destiny_id', $destiny_id);
                                                     })->where('pharmacy_id',session('pharmacy_id'))
                                                       ->whereYear('date', $year);
                                    })
                                    ->whereHas('product', function ($query) use ($category_id) {
                                             $query->when($category_id, function ($query, $category_id) {
                                                        return $query->where('category_id', $category_id);
                                                     });
                                    })
                                    ->whereHas('product', function ($query) use ($program_id) {
                                        $query->when($program_id, function ($query, $program_id) {
                                                   return $query->where('program_id', $program_id);
                                                });
                               })
                                    ->with('dispatch','product')
                                    ->get();
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

          /* TODO: se agrega validación if $final, comparar con bd final */
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
