<?php

use App\Models\Warehouse\TypeReception;
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
        Schema::create('wre_type_receptions', function (Blueprint $table) {
            $table->id();

            $table->string('name', 255)->nullable();
            $table->boolean('active')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        $receptions = [
            [
                'name'   => 'Ingreso Normal',
                'active' => true,
            ],
            [
                'name'   => 'Recibir de Bodega',
                'active' => true,
            ],
            [
                'name'   => 'Devolución',
                'active' => true,
            ],
            [
                'name'   => 'Orden de Compra',
                'active' => true,
            ],
        ];

        foreach ($receptions as $reception) {
            TypeReception::create($reception);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wre_type_receptions');
    }
};
