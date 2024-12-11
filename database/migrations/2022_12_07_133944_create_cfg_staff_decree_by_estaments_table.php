<?php

use App\Models\Parameters\StaffDecreeByEstament;
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
        Schema::create('cfg_staff_decree_by_estaments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estament_id')->nullable()->constrained('cfg_estaments');
            $table->integer('start_degree')->nullable();
            $table->integer('end_degree')->nullable();
            $table->longText('description');
            $table->foreignId('staff_decree_id')->nullable()->constrained('cfg_staff_decrees');

            $table->timestamps();
            $table->softDeletes();
        });

        // ADMINISTRATIVOS
        // $StaffDecreeByEstament = new StaffDecreeByEstament();
        // $StaffDecreeByEstament->estament_id     = 1;
        // $StaffDecreeByEstament->start_degree    = '12';
        // $StaffDecreeByEstament->end_degree      = '15';
        // $StaffDecreeByEstament->description     = 'Licencia de Enseñanza Media o equivalente, y acreditar una experiencia
        //                                             laboral en el área administrativa o en labores equivalentes no inferior
        //                                             a cinco años en el sector público';
        // $StaffDecreeByEstament->staff_decree_id = 1;
        // $StaffDecreeByEstament->save();

        // $StaffDecreeByEstament = new StaffDecreeByEstament();
        // $StaffDecreeByEstament->estament_id     = 1;
        // $StaffDecreeByEstament->start_degree    = '16';
        // $StaffDecreeByEstament->end_degree      = '19';
        // $StaffDecreeByEstament->description     = 'Licencia de Enseñanza Media o equivalente, y acreditar una experiencia
        //                                             laboral en el área administrativa o en labores equivalentes no inferior
        //                                             a cinco años en el sector público o privado';
        // $StaffDecreeByEstament->staff_decree_id = 1;
        // $StaffDecreeByEstament->save();

        // $StaffDecreeByEstament = new StaffDecreeByEstament();
        // $StaffDecreeByEstament->estament_id     = 1;
        // $StaffDecreeByEstament->start_degree    = '20';
        // $StaffDecreeByEstament->end_degree      = '22';
        // $StaffDecreeByEstament->description     = 'Licencia de Enseñanza Media o equivalente';
        // $StaffDecreeByEstament->staff_decree_id = 1;
        // $StaffDecreeByEstament->save();
        //-------------------------------------------------------------------------------------------------------------------
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cfg_staff_decree_by_estaments');
    }
};
