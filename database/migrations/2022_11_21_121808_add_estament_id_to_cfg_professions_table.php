<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Parameters\Profession;
use App\Models\Parameters\Estament;

class AddEstamentIdToCfgProfessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cfg_professions', function (Blueprint $table) {
            $table->foreignId('estament_id')->after('name')->default(1)->constrained('cfg_estaments');
        });

        $professions = Profession::all();
        foreach($professions as $p)
        {
            $p->estament_id = Estament::where('category', $p->category)->first()->id;
            $p->save();
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cfg_professions', function (Blueprint $table) {
            $table->dropConstrainedForeignId('estament_id');
        });
    }
}
