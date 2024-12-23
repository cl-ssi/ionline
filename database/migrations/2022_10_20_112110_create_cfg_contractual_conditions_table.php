<?php

use App\Models\Parameters\ContractualCondition;
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
        Schema::create('cfg_contractual_conditions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });

        ContractualCondition::create([
            'name' => 'Contrata',
        ]);
        ContractualCondition::create([
            'name' => 'Honorarios',
        ]);
        ContractualCondition::create([
            'name' => 'Titular',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cfg_contractual_conditions');
    }
};
