<?php

namespace App\Models\RequestForms;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class PurchaseOrder extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'arq_purchase_orders';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'date',
        'data',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'date' => 'datetime',
    ];

    /**
     * The attributes that should be appended to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'version',
        'date_creation',
        'tax_percentage',
        'supplier_rut_full',
        'supplier_rut',
        'supplier_dv',
        'supplier_name',
        'supplier_code',
        'supplier_commercial_activity',
        'supplier_branch_code',
        'supplier_branch_name',
        'supplier_contact_name',
        'supplier_contact_charge',
        'supplier_contact_phone',
        'supplier_contact_email',
        'supplier_address',
        'supplier_commune',
        'items',
    ];

    public function getDataObjectAttribute()
    {
        $object = json_decode($this->data);
        return $object;
    }

    public function getVersionAttribute()
    {
        return $this->data_object->Version;
    }

    public function getDateCreationAttribute()
    {
        return Carbon::parse($this->data_object->Listado[0]->Fechas->FechaCreacion)->format('Y-m-d H:i:s');
    }

    public function getTaxPercentageAttribute()
    {
        return $this->data_object->Listado[0]->PorcentajeIva;
    }

    public function getChargesAttribute()
    {
        return $this->data_object->Listado[0]->Cargos;
    }

    public function getItemsAttribute()
    {
        return $this->data_object->Listado[0]->Items->Listado;
    }

    public function getSupplierRutFullAttribute()
    {
        $rut = strval($this->data_object->Listado[0]->Proveedor->RutSucursal);
        return $rut;
    }

    public function getSupplierRutAttribute()
    {
        $rut = Str::replace('.', '', $this->supplier_rut_full);
        $rut = explode('-', $rut);
        return $rut[0];
    }

    public function getSupplierDvAttribute()
    {
        $rut = Str::replace('.', '', $this->supplier_rut_full);
        $rut = explode('-', $rut);
        return $rut[1];
    }

    public function getSupplierNameAttribute()
    {
        return $this->data_object->Listado[0]->Proveedor->Nombre;
    }

    public function getSupplierCodeAttribute()
    {
        return $this->data_object->Listado[0]->Proveedor->Codigo;
    }

    public function getSupplierCommercialActivityAttribute()
    {
        return $this->data_object->Listado[0]->Proveedor->Actividad;
    }

    public function getSupplierBranchCodeAttribute()
    {
        return $this->data_object->Listado[0]->Proveedor->CodigoSucursal;
    }

    public function getSupplierBranchNameAttribute()
    {
        return $this->data_object->Listado[0]->Proveedor->NombreSucursal;
    }

    public function getSupplierAddressAttribute()
    {
        return $this->data_object->Listado[0]->Proveedor->Direccion;
    }

    public function getSupplierCommuneAttribute()
    {
        return $this->data_object->Listado[0]->Proveedor->Comuna;
    }

    public function getSupplierContactNameAttribute()
    {
        return $this->data_object->Listado[0]->Proveedor->NombreContacto;
    }

    public function getSupplierContactChargeAttribute()
    {
        return $this->data_object->Listado[0]->Proveedor->CargoContacto;
    }

    public function getSupplierContactPhoneAttribute()
    {
        return $this->data_object->Listado[0]->Proveedor->FonoContacto;
    }

    public function getSupplierContactEmailAttribute()
    {
        return $this->data_object->Listado[0]->Proveedor->MailContacto;
    }
}
