<?php

use App\Models\Warehouse\Family;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFamiliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wre_families', function (Blueprint $table) {
            $table->id();

            $table->integer('code')->nullable();
            $table->string('name')->nullable();
            $table->timestamp('experies_at')->nullable();
            $table->foreignId('segment_id')->nullable()->constrained('wre_segments');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wre_families');
    }
}
