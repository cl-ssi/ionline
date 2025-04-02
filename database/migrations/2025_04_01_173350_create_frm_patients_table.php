<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('frm_patients', function (Blueprint $table) {
            $table->bigInteger('id')->primary();
            $table->char('dv', 1);
            $table->string('full_name');
            $table->string('phone', 20)->nullable();
            $table->string('observation')->nullable(); // Para notas como "(Hija)"
            $table->string('address');
            $table->foreignId('establishment_id')->constrained('establishments');
            $table->timestamps();
            $table->softDeletes();
        });

        DB::table('frm_patients')->insert([
            ['id' => 6755452, 'dv' => '3', 'full_name' => 'Adriana Estay Araya', 'phone' => '95725884', 'address' => 'PASAJE EL MONTE 2615 BLOCK I DEPTO 9', 'establishment_id' => 35, 'observation' => null],
            ['id' => 5369183, 'dv' => '8', 'full_name' => 'Agustin Nunez Diaz', 'phone' => '963735797', 'address' => 'ARTURO PEREZ CANTO 1258', 'establishment_id' => 35, 'observation' => '(Hija)'],
            ['id' => 20247833, 'dv' => '6', 'full_name' => 'Alan Gallardo Venegas', 'phone' => '67350095', 'address' => 'LAS ROSAS 2183', 'establishment_id' => 34, 'observation' => null],
            ['id' => 20504621, 'dv' => '6', 'full_name' => 'Alan Mena Carvajal', 'phone' => '86173630', 'address' => 'LAS PIZARRAS 3638', 'establishment_id' => 35, 'observation' => null],
            ['id' => 4942761, 'dv' => '1', 'full_name' => 'Alberto Garcia Arancibia', 'phone' => '90939599', 'address' => 'Los Jacintos 3094', 'establishment_id' => 35, 'observation' => null],
            ['id' => 15002117, 'dv' => '0', 'full_name' => 'Alberto Grunert Rivera', 'phone' => '968060812', 'address' => 'violeta 1856', 'establishment_id' => 34, 'observation' => null],
            ['id' => 18898890, 'dv' => '3', 'full_name' => 'Aldo Pinto Alvarez', 'phone' => '976553828', 'address' => 'CARDENAL CARO 2211', 'establishment_id' => 35, 'observation' => '/977870576'],
            ['id' => 8859632, 'dv' => '3', 'full_name' => 'Aldo Riquelme Bucarey', 'phone' => '94723772', 'address' => 'PASAJE KENA 2505', 'establishment_id' => 35, 'observation' => null],
            ['id' => 8493588, 'dv' => '3', 'full_name' => 'Aldwin Miranda Ulloa', 'phone' => '97305921', 'address' => 'orella 773', 'establishment_id' => 34, 'observation' => null],
            ['id' => 22026561, 'dv' => '7', 'full_name' => 'Alejandra Munoz Munoz', 'phone' => '271579', 'address' => 'pasaje el salitre 2371 poblacion jorge inostrosa', 'establishment_id' => 34, 'observation' => null],
            ['id' => 17477353, 'dv' => 'k', 'full_name' => 'Alejandro Cruz Hidalgo', 'phone' => '944814352', 'address' => 'Av. la tirana 4800 torre b dpto 1501Con costa sur', 'establishment_id' => 35, 'observation' => null],
            ['id' => 10674494, 'dv' => '7', 'full_name' => 'Alejandro Venegas Riquelme', 'phone' => '156846090', 'address' => 'CAMPO DEPORTE 2317', 'establishment_id' => 35, 'observation' => null],
            ['id' => 15685544, 'dv' => '8', 'full_name' => 'Alejandro Gallardo Elizalde', 'phone' => '86874706', 'address' => 'salvador allende 2001', 'establishment_id' => 35, 'observation' => null],
            ['id' => 21576029, 'dv' => '4', 'full_name' => 'Alejandro Diaz Esparza', 'phone' => '979890457', 'address' => 'ignacio carrera pinto 2315 (segundo piso )', 'establishment_id' => 35, 'observation' => '572223276'],
            ['id' => 13415945, 'dv' => '6', 'full_name' => 'Alejandro Mollo Carlos', 'phone' => '310547', 'address' => 'LAS ACACIAS 2335', 'establishment_id' => 35, 'observation' => null],
            ['id' => 11342847, 'dv' => '3', 'full_name' => 'Alejandro Bravo Fuentes', 'phone' => '2340970', 'address' => '156846090', 'establishment_id' => 35, 'observation' => null],
            ['id' => 14005142, 'dv' => 'k', 'full_name' => 'Alejandra Toro Ramos', 'phone' => '982024495', 'address' => 'chamiza 3839', 'establishment_id' => 35, 'observation' => null],
            ['id' => 13215334, 'dv' => '5', 'full_name' => 'Alexandra Araya Castillo', 'phone' => '933329484', 'address' => 'Sotomayor 888', 'establishment_id' => 34, 'observation' => null],
            ['id' => 19978240, 'dv' => '1', 'full_name' => 'Alexandra Mondaca Martinez', 'phone' => '35713973', 'address' => 'gorostiaga 538', 'establishment_id' => 34, 'observation' => null],
            ['id' => 14106390, 'dv' => '1', 'full_name' => 'Alexis Ayala Eloy', 'phone' => '944728349', 'address' => 'pje. Dolores 3172, Villa magisterio', 'establishment_id' => 35, 'observation' => null],
            ['id' => 15003553, 'dv' => '8', 'full_name' => 'Alexis Sapiain Godoy', 'phone' => '89704373', 'address' => 'AV LA TIRANA 2126', 'establishment_id' => 35, 'observation' => '(Mama),92313531(Alexis)'],
            ['id' => 12729960, 'dv' => '9', 'full_name' => 'David Cabrera Godoy', 'phone' => '959924402', 'address' => 'pasaje pachica 2841', 'establishment_id' => 35, 'observation' => null]
        ]);

        DB::table('frm_pharmacies')->insert([
            ['name' => 'Fraccionamiento SST', 'address' => 'SST', 'establishment_id' => 38]
        ]);

        DB::table('frm_categories')->insert([
            ['name' => 'FARMACOS CONTROLADOS']
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('frm_patients');
    }
};
