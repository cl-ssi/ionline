<?php

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
            $table->foreignId('subdirection_ou_id')->constrained('organizational_units');
            $table->foreignId('responsability_center_ou_id')->constrained('organizational_units');
            $table->foreignId('responsable_id')->constrained('users');
            // $table->string('rut', 100); /* // FIXME: @sickiqq no está en el backup, tiene migración para eliminar? */
            // $table->string('name', 100);
            $table->string('address', 100)->nullable();
            $table->string('phone_number', 150)->nullable();
            $table->string('email', 100)->nullable();
            $table->datetime('request_date');
            $table->datetime('start_date');
            $table->datetime('end_date');
            $table->enum('contract_type', ['NUEVO', 'ANTIGUO', 'CONTRATO PERM.', 'PRESTACION']);
            $table->string('contractual_condition', 100)->nullable();
            $table->longText('service_description')->nullable();
            $table->string('programm_name', 100)->nullable();
            $table->string('grade')->nullable();
            $table->enum('other', ['Brecha', 'LM:LICENCIAS MEDICAS', 'HE:HORAS EXTRAS']);
            $table->enum('normal_hour_payment', ['', 'MACROZONA'])->nullable();
            $table->double('amount', 8, 2)->nullable();
            $table->enum('program_contract_type', ['Horas', 'Semanal', 'Mensual', 'Otro'])->nullable();
            $table->double('weekly_hours', 8, 2)->nullable();
            $table->double('daily_hours', 8, 2)->nullable();
            $table->double('nightly_hours', 8, 2)->nullable();
            $table->enum('estate', ['Profesional Médico', 'Profesional', 'Técnico', 'Administrativo', 'Farmaceutico', 'Odontólogo', 'Bioquímico', 'Auxiliar', 'Otro (justificar)'])->nullable();
            $table->string('estate_other', 100)->nullable();
            // $table->enum('working_day_type', ['08:00 a 16:48 hrs (L-M-M-J-V)', 'TERCER TURNO', 'CUARTO TURNO', 'Otro (justificar)'])->nullable();
            $table->longText('working_day_type')->nullable();
            $table->string('schedule_detail')->nullable();
            $table->longText('working_day_type_other')->nullable();
            $table->string('budget_cdp_number', 100)->nullable();
            $table->string('budget_item', 100)->nullable();
            $table->double('budget_amount', 8, 2)->nullable();
            $table->datetime('budget_date')->nullable();

            //datos adicionales
            $table->bigInteger('contract_number')->nullable();
            $table->integer('month_of_payment')->nullable();
            $table->foreignId('establishment_id')->constrained('establishments');
            $table->foreignId('profession_id')->nullable()->constrained('cfg_professions');
            $table->longText('objectives');
            $table->string('resolve')->nullable();
            $table->string('subt31', 2000)->nullable();
            $table->string('additional_benefits', 2000)->nullable();
            $table->string('bonus_indications', 2000)->nullable();
            $table->string('nationality', 100)->nullable();
            $table->string('digera_strategy', 100)->nullable();
            $table->string('rrhh_team', 100)->nullable();
            $table->double('gross_amount', 10, 0)->nullable();
            $table->double('net_amount', 10, 0)->nullable();
            $table->boolean('sirh_contract_registration')->nullable();
            $table->bigInteger('resolution_number')->nullable();
            $table->datetime('resolution_date')->nullable();
            $table->bigInteger('bill_number')->nullable();
            $table->double('total_hours_paid', 10, 2)->nullable();
            $table->double('total_paid', 10, 2)->nullable();
            $table->datetime('payment_date')->nullable();
            $table->boolean('has_resolution_file')->nullable();
            $table->dateTime('has_resolution_file_at')->nullable();
            $table->boolean('signature_page_break')->nullable()->default(0);
            $table->foreignId('bank_id')->nullable()->constrained('cfg_banks');
            $table->string('account_number')->nullable();
            $table->string('pay_method')->nullable();

            $table->string('verification_code', 100)->nullable();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('signed_budget_availability_cert_id')->nullable()->constrained('doc_signatures_files');

            $table->string('observation')->nullable();
            $table->foreignId('creator_id')->nullable()->constrained('users');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('doc_resolutions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ou_id')->constrained('organizational_units');
            $table->foreignId('responsable_id')->constrained('users');
            $table->datetime('request_date');
            $table->string('document_type', 255)->nullable(); //carta, circular, convenios, etc.
            $table->string('resolution_matter', 255)->nullable(); //honorarios, covid19, etc.
            $table->string('description', 255)->nullable();
            $table->string('endorse_type', 255)->nullable(); //tipo de visación
            $table->string('document_recipients', 255)->nullable(); //tipo de visación
            $table->string('document_distribution', 255)->nullable(); //tipo de visación
            $table->foreignId('user_id')->constrained('users');

            $table->timestamps();
        });

        Schema::create('doc_signature_flow', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ou_id')->constrained('organizational_units');
            $table->datetime('derive_date')->nullable();
            $table->foreignId('responsable_id')->nullable()->constrained('users');
            $table->foreignId('service_request_id')->nullable()->constraine('doc_service_requests');
            $table->foreignId('resolution_id')->nullable()->constrained('doc_resolutions');
            // $table->enum('employee', ['Supervisor de servicio', 'Jefatura de servicio', 'Subdirector', 'Jefe de finanzas', 'Director', 'Jefe Depto. Gestión de las Personas', 'Subdirector RR.HH']);
            $table->integer('sign_position')->nullable();
            $table->string('type', 100)->nullable(); //visador, firmante
            $table->string('employee', 100)->nullable();
            $table->longText('observation')->nullable();
            $table->datetime('signature_date')->nullable();
            $table->boolean('status')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users');

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
        Schema::dropIfExists('doc_signature_flow');
        Schema::dropIfExists('doc_resolutions');
        Schema::dropIfExists('doc_service_requests');
        // Schema::dropIfExists('doc_subdirections');
        // Schema::dropIfExists('doc_responsability_centers');
    }
};
