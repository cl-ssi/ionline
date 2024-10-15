<?php

namespace App\Livewire\Pharmacies;

use Livewire\Component;
use App\Models\Pharmacies\Purchase;
use App\Models\Pharmacies\Supplier;
use App\Models\Pharmacies\PurchaseItem;
use App\Models\Pharmacies\Product;
use App\Models\Finance\Receptions\Reception;

class ImportReception extends Component
{
    public $filter_purchase_order = '';
    public $receptions = [];
    public $selectedReception = null;
    public $loadingItems = false;
    public $suppliers = [];
    public $selectedSupplier = null;
    public $to_ou_id;
    public $supplier_filter = '';
    public $selectedItem = null;
    public $unit_cost;
    public $amount;
    public $productName;


    public $products = [];
    public $product_id;
    public $barcode;
    public $experto_id;
    public $product_name;
    public $unity;
    public $due_date;
    public $batch;
    public $showSecondDiv = false;
    public $filtro_producto;
    public $order_number;
    public $notes;
    public $destination;
    public $from;
    public $purchase_order;
    public $dte_date; // Fecha de emisión de la factura
    public $neto; // Monto total neto
    public $despatch_guide;
    public $invoice;
    public $dte_due_date;

    public $due_date_readonly = false;
    public $batch_readonly = false;


    // Nueva propiedad para almacenar los productos agregados
    public $addedProducts = [];

    // Método para cargar las 10 últimas recepciones al inicializar el componente
    public function mount()
    {
        $this->getLastReceptions();
        $this->loadSuppliers();

        $this->products = Product::where('pharmacy_id',session('pharmacy_id'))
                                ->orderBy('name','ASC')->get();
    }

    public function getLastReceptions()
    {
        $this->receptions = Reception::where('creator_id', auth()->user()->id)
                                    ->doesntHave('purchases') // Filtra las recepciones que no tienen compras asociadas
                                    ->take(10)
                                    ->orderBy('id','DESC')
                                    ->get();
    }

    public function loadSuppliers()
    {
        $filter = trim(preg_replace('/\s+/', ' ', $this->supplier_filter));
        $this->suppliers = Supplier::query()
            ->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($filter) . '%'])
            ->orderBy('name')
            ->get();
    }

    public function updatedSupplierFilter()
    {
        $this->loadSuppliers();
    }

    public function updatedFilterPurchaseOrder()
    {
        if ($this->filter_purchase_order) {
            $this->receptions = Reception::with(['purchaseOrder'])
                ->where('purchase_order', 'like', '%' . $this->filter_purchase_order . '%')
                ->latest()
                ->take(10)
                ->get();
        } else {
            $this->getLastReceptions();
        }
    }

    public function selectReception($receptionId)
    {
        $this->loadingItems = true;
        $this->selectedReception = null;

        // Limpiar los campos y la tabla dinámica
        $this->clearFields();
        $this->addedProducts = [];

        // Cargar la recepción seleccionada con las relaciones necesarias
        $this->selectedReception = Reception::with(['purchaseOrder', 'items', 'dte', 'guia'])->find($receptionId);

        // Cargar los datos de la orden de compra y factura si están disponibles
        if ($this->selectedReception) {
            $supplierName = $this->selectedReception->purchaseOrder?->json->Listado[0]->Proveedor->Nombre ?? '';
            $this->supplier_filter = $supplierName;

            $this->purchase_order = $this->selectedReception->purchase_order;
            $this->dte_date = $this->selectedReception->dte_date; // Fecha de emisión de la factura
            $this->neto = $this->selectedReception->neto; // Monto total neto de la orden de compra
            $this->dte_due_date = $this->selectedReception->dte?->fecha_vencimiento; // Fecha de vencimiento de la factura
            $this->despatch_guide = $this->selectedReception->guia?->folio; // Número de la guía de despacho
            $this->invoice = $this->selectedReception->dte?->folio; // Número de la factura
        }

        $this->loadSuppliers();
        $this->loadingItems = false;
    }

    public function selectItem($itemId)
    {
        $this->selectedItem = $itemId;

        // Limpiar los campos individuales
        $this->clearFields(); 

        $item = $this->selectedReception->items->find($itemId);

        if ($item) {
            $this->unit_cost = $item->PrecioNeto;
            $this->amount = $item->Cantidad;
            $this->productName = $item->Producto;
            $this->barcode = $item->CodigoProducto; // Asegúrate de usar el nombre de la propiedad correcta
            $this->experto_id = $item->CodigoExperto; // Asegúrate de usar el nombre de la propiedad correcta

            $this->filtro_producto = $item->Producto;
            $this->updatedFiltroProducto();
        }
    }

    public function clearFields()
    {
        $this->product_id = null;
        $this->barcode = '';
        $this->experto_id = '';
        $this->productName = '';
        $this->unit_cost = '';
        $this->amount = '';
        $this->due_date = '';
        $this->batch = '';
        $this->filtro_producto = '';

        // Desbloquear los campos de fecha de vencimiento y lote, y limpiar sus valores
        $this->due_date_readonly = false; // Desbloquear el campo de fecha de vencimiento
        $this->batch_readonly = false; // Desbloquear el campo de lote

        $this->due_date = ''; // Limpiar el valor de la fecha de vencimiento
        $this->batch = ''; // Limpiar el valor del lote
    }

    // Método para agregar un producto a la tabla dinámica
    public function addProduct()
    {
        // Validar si el ítem ya fue agregado basado en el selectedItem
        foreach ($this->addedProducts as $addedProduct) {
            if ($addedProduct['selectedItem'] === $this->selectedItem) {
                session()->flash('error', 'Este ítem de la recepción ya ha sido agregado.');
                return;
            }
        }

        // Validar si todos los campos requeridos están completos
        if (!$this->selectedItem || !$this->product_id || !$this->productName || !$this->unit_cost || !$this->amount || !$this->barcode || !$this->due_date || !$this->batch) {
            $missingFields = [];

            if (!$this->selectedItem) {
                $missingFields[] = 'Ítem seleccionado';
            }

            if (!$this->product_id) {
                $missingFields[] = 'Producto';
            }
            if (!$this->productName) {
                $missingFields[] = 'Nombre del Producto';
            }
            if (!$this->unit_cost) {
                $missingFields[] = 'Precio Unitario';
            }
            if (!$this->amount) {
                $missingFields[] = 'Cantidad';
            }
            if (!$this->barcode) {
                $missingFields[] = 'Código del Producto';
            }
            if (!$this->due_date) {
                $missingFields[] = 'Fecha de Vencimiento';
            }
            if (!$this->batch) {
                $missingFields[] = 'Número de Lote';
            }

            $message = 'Debe completar los siguientes campos antes de agregar el producto: ' . implode(', ', $missingFields) . '.';
            session()->flash('error', $message);
            return;
        }

        // Agregar el producto a la tabla de abajo
        $this->addedProducts[] = [
            'selectedItem' => $this->selectedItem,
            'id' => $this->product_id,
            'barcode' => $this->barcode,
            'experto_id' => $this->experto_id,
            'name' => $this->productName,
            'unit_cost' => $this->unit_cost,
            'amount' => $this->amount,
            'due_date' => $this->due_date,
            'batch' => $this->batch
        ];

        // Eliminar el ítem seleccionado de la lista de ítems de recepción
        $this->selectedReception->items = $this->selectedReception->items->reject(function ($item) {
            return $item->id == $this->selectedItem;
        });

        // Limpiar la selección de la tabla y los campos relacionados
        $this->selectedItem = null;
        $this->clearFields();
    }

    public function toggleSecondDiv()
    {
        $this->showSecondDiv = !$this->showSecondDiv;
    }

    public function updatedBarcode($value)
    {
        $product = Product::where('pharmacy_id',session('pharmacy_id'))->where('barcode',$value)->first();
        if($product){
            $this->product_id = $product->id;
            $product = Product::find($this->product_id);
            $this->unity = $product->unit;
            $this->product_name = $product->name;
            // $this->barcode = $product->barcode;
            $this->experto_id = $product->experto_id;
        }
    }

    public function change(){
        $product = Product::find($this->product_id);
        $this->unity = $product->unit;
        $this->product_name = $product->name;
        $this->barcode = $product->barcode;
        $this->experto_id = $product->experto_id;
    }

    public function updatedFiltroProducto()
{
    // Dividir la cadena de búsqueda en palabras, eliminando palabras de menos de 4 caracteres para evitar ruido.
    $terms = collect(explode(' ', $this->filtro_producto))
                ->filter(function ($term) {
                    return strlen($term) >= 4;
                })
                ->map(function ($term) {
                    return '%' . $term . '%';
                });

    // Construir la consulta utilizando 'LIKE' para cada término relevante.
    $this->products = Product::where('pharmacy_id', session('pharmacy_id'))
                            ->where(function ($query) use ($terms) {
                                // Verificar si hay términos para buscar.
                                if ($terms->isNotEmpty()) {
                                    foreach ($terms as $term) {
                                        $query->orWhere('name', 'like', $term);
                                    }
                                } else {
                                    // Si no hay términos significativos, buscar todo.
                                    $query->where('name', 'like', '%' . $this->filtro_producto . '%');
                                }
                            })
                            ->orderBy('name', 'ASC')
                            ->get();
}


    public function removeProduct($index)
    {
        // Verificar si el índice existe en la lista de productos añadidos
        if (isset($this->addedProducts[$index])) {
            // Eliminar el producto de la lista
            unset($this->addedProducts[$index]);
            
            // Reindexar el array para evitar problemas con los índices
            $this->addedProducts = array_values($this->addedProducts);
        }
    }

    public function toggleDueDateBatch()
    {
        // Alternar el estado de los campos
        $this->due_date_readonly = !$this->due_date_readonly;
        $this->batch_readonly = !$this->batch_readonly;

        // Si se deshabilitan, asignar valores predeterminados
        if ($this->due_date_readonly) {
            $this->due_date = '2100-01-01';
            $this->batch = 'S/Lote';
        } else {
            // Limpiar los valores cuando se habiliten
            $this->due_date = null;
            $this->batch = null;
        }
    }


    public function createPharmacyImport()
    {
        // Validaciones personalizadas
        if (empty($this->order_number)) {
            session()->flash('import_validation_error', 'El número de pedido es obligatorio.');
            return;
        }

        if (empty($this->selectedSupplier)) {
            session()->flash('import_validation_error', 'Debe seleccionar un proveedor.');
            return;
        }

        if (count($this->addedProducts) === 0) {
            session()->flash('import_validation_error', 'Debe agregar al menos un producto antes de crear la importación.');
            return;
        }

        // Crear un nuevo registro de compra (Purchase)
        $purchase = new Purchase();
        $purchase->pharmacy_id = session('pharmacy_id');
        $purchase->supplier_id = $this->selectedSupplier;
        $purchase->purchase_order = $this->purchase_order;
        $purchase->order_number = $this->order_number;
        $purchase->notes = $this->notes;
        $purchase->destination = $this->destination;
        $purchase->from = $this->from;
        $purchase->user_id = auth()->id();
        $purchase->date = now();
        $purchase->purchase_order_date = $this->dte_date; // Fecha de emisión de la factura
        $purchase->purchase_order_amount = $this->neto; // Monto total neto de la orden de compra
        $purchase->despatch_guide = $this->despatch_guide; // Número de la guía de despacho
        $purchase->invoice = $this->invoice; // Número de la factura
        $purchase->invoice_date = $this->dte_due_date; // Fecha de vencimiento de la factura
        $purchase->reception_id = $this->selectedReception->id; // Asociar el ID de la recepción seleccionada
        $purchase->save();

        // Crear los ítems de la compra (PurchaseItem)
        foreach ($this->addedProducts as $product) {
            $purchaseItem = new PurchaseItem();
            $purchaseItem->purchase_id = $purchase->id;
            $purchaseItem->product_id = $product['id'];
            $purchaseItem->barcode = $product['barcode'];
            $purchaseItem->amount = $product['amount'];
            $purchaseItem->unit_cost = $product['unit_cost'];
            $purchaseItem->due_date = $product['due_date'];
            $purchaseItem->batch = $product['batch'];
            $purchaseItem->reception_item_id = $this->selectedItem; // Asignar el ID del ítem de recepción seleccionado
            $purchaseItem->save();

            // Actualizar el stock del producto
            $productModel = Product::find($product['id']);
            $productModel->stock += $product['amount'];
            $productModel->save();
        }

        session()->flash('success', 'Importación creada exitosamente.');

        // Redirige a la ruta
        return redirect()->route('pharmacies.products.purchase.index');
    }


    public function render()
    {
        return view('livewire.pharmacies.import-reception');
    }
}

