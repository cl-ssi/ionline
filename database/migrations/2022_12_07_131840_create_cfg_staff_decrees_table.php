<?php

use App\Models\Parameters\StaffDecree;
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
        Schema::create('cfg_staff_decrees', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->year('year')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        StaffDecree::create([
            'name' => 'DFL 3',
            'year' => '2017',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cfg_staff_decrees');
    }
};
