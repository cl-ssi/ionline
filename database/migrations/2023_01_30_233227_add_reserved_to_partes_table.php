<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Documents\Parte;

class AddReservedToPartesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('partes', function (Blueprint $table) {
            $table->boolean('reserved')->nullable()->after('type');
        });

        $partes = Parte::withTrashed()->get();
        foreach($partes as $parte) {
            if($parte->type == 'Reservado') {
                $parte->type = 'Oficio';
                $parte->reserved = true;
                $parte->save();
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('partes', function (Blueprint $table) {
            $table->dropColumn('reserved');
        });
    }
}
