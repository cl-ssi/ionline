<?php

use App\Models\Summary\Type;
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
        Schema::create('sum_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('establishment_id')->constrained('establishments');
            $table->timestamps();
        });

        // Type::create(['name' => 'Investigación Sumaria']);
        // Type::create(['name' => 'Sumario Administrativo']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sum_types');
    }
};
