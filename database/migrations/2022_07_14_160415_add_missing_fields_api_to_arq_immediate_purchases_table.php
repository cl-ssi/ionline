<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMissingFieldsApiToArqImmediatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('arq_immediate_purchases', function (Blueprint $table) {
            $table->string('po_status')->nullable()->after('resol_purchase_intention'); // Estado
            $table->dateTime('po_date')->change(); // FechaCreacion
            $table->dateTime('po_sent_date')->change(); // FechaEnvio
            $table->dateTime('po_accepted_date')->change(); // FechaAceptacion
            $table->dateTime('estimated_delivery_date')->change();
            $table->float('po_discounts', 15, 2)->nullable()->after('po_with_confirmed_receipt_date'); // Descuentos
            $table->float('po_charges', 15, 2)->nullable()->after('po_discounts'); // Cargos
            $table->float('po_net_amount', 15, 2)->nullable()->after('po_charges'); // TotalNeto
            $table->float('po_tax_percent')->nullable()->after('po_net_amount'); // PorcentajeIva
            $table->float('po_tax_amount', 15, 2)->nullable()->after('po_tax_percent'); // Impuestos
            
            // Datos del proveedor desde API
            $table->string('po_supplier_name')->nullable()->after('po_tax_amount'); // Nombre
            $table->string('po_supplier_activity')->nullable()->after('po_supplier_name'); // Actividad
            $table->string('po_supplier_office_name')->nullable()->after('po_supplier_activity'); // NombreSucursal
            $table->string('po_supplier_office_run')->nullable()->after('po_supplier_office_name'); // RutSucursal
            $table->string('po_supplier_address')->nullable()->after('po_supplier_office_run'); // Direccion
            $table->string('po_supplier_commune')->nullable()->after('po_supplier_address'); // Comuna
            $table->string('po_supplier_region')->nullable()->after('po_supplier_commune'); // Region

            // Datos del contacto de proveedor desde API
            $table->string('po_supplier_contact_name')->nullable()->after('po_supplier_region'); // NombreContacto
            $table->string('po_supplier_contact_position')->nullable()->after('po_supplier_contact_name'); // CargoContacto
            $table->string('po_supplier_contact_phone')->nullable()->after('po_supplier_contact_position'); // FonoContacto
            $table->string('po_supplier_contact_email')->nullable()->after('po_supplier_contact_phone'); // MailContacto
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('arq_immediate_purchases', function (Blueprint $table) {
            $table->date('po_date')->change();
            $table->date('po_sent_date')->change();
            $table->date('po_accepted_date')->change();
            $table->date('estimated_delivery_date')->change();
            $table->dropColumn(['po_status', 'po_discounts', 'po_charges', 'po_net_amount', 'po_tax_percent', 'po_supplier_name', 'po_supplier_activity',
                                'po_supplier_office_name', 'po_supplier_office_run', 'po_supplier_address', 'po_supplier_commune', 'po_supplier_region',
                                'po_supplier_contact_name', 'po_supplier_contact_position', 'po_supplier_contact_phone', 'po_supplier_contact_email']);
        });
    }
}
