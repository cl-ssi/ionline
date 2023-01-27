<?php

use App\Models\Warehouse\Control;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateRelationshipToWreControls extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wre_controls', function (Blueprint $table) {
            /* Delete reception_signature_id */
            $table->dropForeign(['reception_signature_id']);
            $table->dropColumn('reception_signature_id');

            /* Add reception_visator_id */
            $table->foreignId('reception_visator_id')
                ->nullable()
                ->after('organizational_unit_id')
                ->constrained('users');

            /* Add technical_signer_id */
            $table->foreignId('technical_signer_id')
                ->nullable()
                ->after('technical_signature_id')
                ->constrained('users');
        });

        /* Pasar de signer_id a technical_signer_id */
        DB::update('update wre_controls set technical_signer_id = signer_id where true');

        /* Elimino el signer */
        Schema::table('wre_controls', function (Blueprint $table) {
            $table->dropForeign(['signer_id']);
            $table->dropColumn('signer_id');
        });

        /* reception_visator_id deberia ser el encargado de bodega */
        $controls = Control::all();
        foreach($controls as $control)
        {
            $control->update([
                'reception_visator_id' => $control->store->visator->id
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wre_controls', function (Blueprint $table) {
            //
        });
    }
}
