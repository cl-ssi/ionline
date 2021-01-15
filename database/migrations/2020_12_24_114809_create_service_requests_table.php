<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('doc_subdirections', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('name', 100);
        //     $table->boolean('status');
        //
        //     $table->timestamps();
        // });
        //
        // Schema::create('doc_responsability_centers', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('name', 100);
        //     $table->boolean('status');
        //
        //     $table->timestamps();
        // });

        Schema::create('doc_service_requests', function (Blueprint $table) {
            $table->id();
            $table->string('type', 100); //honorarios, covid19, etc.
            $table->unsignedBigInteger('subdirection_ou_id');
            $table->unsignedBigInteger('responsability_center_ou_id');
            $table->string('rut', 100);
            $table->string('name', 100);
            $table->string('address', 100)->nullable();
            $table->string('phone_number', 150)->nullable();
            $table->string('email', 100)->nullable();
            $table->datetime('request_date');
            $table->datetime('start_date');
            $table->datetime('end_date');
            $table->enum('contract_type', ['NUEVO', 'ANTIGUO', 'CONTRATO PERM.', 'PRESTACION']);
            $table->longText('service_description')->nullable();
            $table->string('programm_name', 100)->nullable();
            $table->enum('other', ['Brecha', 'LM:LICENCIAS MEDICAS', 'HE:HORAS EXTRAS']);
            $table->enum('normal_hour_payment', ['', 'MACROZONA'])->nullable();
            $table->double('amount', 8, 2)->nullable();
            $table->enum('program_contract_type', ['Horas', 'Semanal', 'Mensual', 'Otro'])->nullable();
            $table->double('daily_hours', 8, 2)->nullable();
            $table->double('nightly_hours', 8, 2)->nullable();
            $table->enum('estate', ['Profesional Médico', 'Profesional', 'Técnico', 'Administrativo', 'Farmaceutico', 'Odontólogo', 'Bioquímico', 'Auxiliar', 'Otro (justificar)'])->nullable();
            $table->string('estate_other', 100)->nullable();
            $table->enum('working_day_type', ['08:00 a 16:48 hrs (L-M-M-J-V)', 'TERCER TURNO', 'CUARTO TURNO', 'Otro (justificar)'])->nullable();
            $table->string('working_day_type_other', 100)->nullable();
            $table->string('budget_cdp_number', 100)->nullable();
            $table->string('budget_item', 100)->nullable();
            $table->double('budget_amount', 8, 2)->nullable();
            $table->datetime('budget_date')->nullable();

            //datos adicionales
            $table->bigInteger('contract_number')->nullable();
            $table->integer('month_of_payment')->nullable();
            $table->unsignedInteger('establishment_id')->nullable();
            $table->string('nationality', 100)->nullable();
            $table->string('digera_strategy', 100)->nullable();
            $table->string('rrhh_team', 100)->nullable();
            $table->double('gross_amount', 8, 2)->nullable();
            $table->boolean('sirh_contract_registration')->nullable();
            $table->bigInteger('resolution_number')->nullable();
            $table->bigInteger('bill_number')->nullable();
            $table->double('total_hours_paid', 8, 2)->nullable();
            $table->double('total_paid', 8, 2)->nullable();
            $table->datetime('payment_date')->nullable();

            //fk
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('subdirection_ou_id')->references('id')->on('organizational_units');
            $table->foreign('responsability_center_ou_id')->references('id')->on('organizational_units');
            $table->foreign('establishment_id')->references('id')->on('establishments');

            $table->unsignedBigInteger('user_id');
            $table->timestamps();
        });

        Schema::create('doc_shift_controls', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_request_id');
            $table->datetime('start_date')->nullable();
            $table->datetime('end_date')->nullable();
            $table->string('observation', 100)->nullable();

            $table->foreign('service_request_id')->references('id')->on('doc_service_requests');
            $table->timestamps();
        });

        Schema::create('doc_resolutions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ou_id');
            $table->unsignedBigInteger('responsable_id');
            $table->datetime('request_date');
            $table->string('document_type', 255)->nullable(); //carta, circular, convenios, etc.
            $table->string('resolution_matter', 255)->nullable(); //honorarios, covid19, etc.
            $table->string('description', 255)->nullable();
            $table->string('endorse_type', 255)->nullable(); //tipo de visación
            $table->string('document_recipients', 255)->nullable(); //tipo de visación
            $table->string('document_distribution', 255)->nullable(); //tipo de visación
            $table->unsignedBigInteger('user_id');

            //fk
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('responsable_id')->references('id')->on('users');
            $table->foreign('ou_id')->references('id')->on('organizational_units');

            $table->timestamps();
        });

        Schema::create('doc_signature_flow', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('ou_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('service_request_id')->nullable();
            $table->unsignedBigInteger('resolution_id')->nullable();
            // $table->enum('employee', ['Supervisor de servicio', 'Jefatura de servicio', 'Subdirector', 'Jefe de finanzas', 'Director', 'Jefe Depto. Gestión de las Personas', 'Subdirector RR.HH']);
            $table->string('type', 100)->nullable(); //visador, firmante
            $table->string('employee', 100)->nullable();
            $table->longText('observation')->nullable();
            $table->datetime('signature_date')->nullable();
            $table->boolean('status')->nullable();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('service_request_id')->references('id')->on('doc_service_requests');
            $table->foreign('resolution_id')->references('id')->on('doc_resolutions');
            $table->foreign('ou_id')->references('id')->on('organizational_units');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('doc_signature_flow');
        Schema::dropIfExists('doc_resolutions');
        Schema::dropIfExists('doc_shift_controls');
        Schema::dropIfExists('doc_service_requests');
        // Schema::dropIfExists('doc_subdirections');
        // Schema::dropIfExists('doc_responsability_centers');
    }
}
