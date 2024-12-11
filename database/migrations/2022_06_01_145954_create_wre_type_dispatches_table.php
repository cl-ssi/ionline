<?php

use App\Models\Warehouse\TypeDispatch;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wre_type_dispatches', function (Blueprint $table) {
            $table->id();

            $table->string('name', 255)->nullable();
            $table->boolean('active')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        $dispatches = [
            [
                'name'   => 'Egreso Normal',
                'active' => true,
            ],
            [
                'name'   => 'Ajuste de Inventario',
                'active' => true,
            ],

            [
                'name'   => 'Enviar a Bodega',
                'active' => true,
            ],
        ];

        foreach ($dispatches as $dispatch) {
            TypeDispatch::create($dispatch);
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wre_type_dispatches');
    }
};
