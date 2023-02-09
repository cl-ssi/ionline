<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Requirements\Label;
use App\Models\Requirements\Category;

class SwitchLabelForCategoryOnSgr extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        echo "Elimnar label de requirement \n";
        Schema::table('req_requirements', function (Blueprint $table) {
            $table->dropConstrainedForeignId('label_id');
        });

        echo "Truncar labels\n";
        DB::update("TRUNCATE TABLE req_labels");
        
        echo "Agregar a labels las columnas que tiene categoria\n";
        Schema::table('req_labels', function (Blueprint $table) {
            $table->dropConstrainedForeignId('ou_id');

            $table->foreignId('user_id')
                ->after('name')
                ->constrained('users');
            $table->string('color')->after('name');
        });

        echo "Migrar datos de categoria a label\n";
        DB::update("INSERT INTO req_labels SELECT * FROM req_categories;");
        

        echo "renombrar req_requiremnts_categories a labels_requrimenets\n";
        Schema::rename('req_requirements_categories', 'req_labels_requirements');

        echo "agregar label_id a labels_requirements\n";
        Schema::table('req_labels_requirements', function (Blueprint $table) {
            $table->foreignId('label_id')
                ->nullable()
                ->after('requirement_id')
                ->constrained('req_labels');
        });

        echo "copiar category_id en label_id en tabla labels_requirements\n";
        DB::update("UPDATE req_labels_requirements SET label_id = category_id");

        echo "Renombrar de vuelta req_labels_requirements para eliminar la foranea\n";
        Schema::rename('req_labels_requirements','req_requirements_categories');
        
        echo "Eliminar la foranea category_id de tabla req_requirements_categories\n";
        Schema::table('req_requirements_categories', function (Blueprint $table) {
            $table->dropConstrainedForeignId('category_id');
        });

        echo "Renombara nuevamente a req_labels_requirements\n";
        Schema::rename('req_requirements_categories', 'req_labels_requirements');

        echo "truncar categorias\n";
        DB::update("TRUNCATE TABLE req_categories");

        echo "Agregar category_id a requirements\n";
        Schema::table('req_requirements', function (Blueprint $table) {
            $table->foreignId('category_id')
                ->nullable()
                ->after('to_authority')
                ->constrained('req_categories');
        });

        echo "modificar categorias\n";
        Schema::table('req_categories', function (Blueprint $table) {
            $table->dropColumn('color');
            $table->dropConstrainedForeignId('user_id');

            $table->foreignId('organizational_unit_id')
                ->after('name')
                ->nullable()
                ->constrained('organizational_units');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('req_labels', function (Blueprint $table) {
            $table->dropColumn('color');
            $table->dropConstrainedForeignId('user_id');
        });

        Schema::table('req_categories', function (Blueprint $table) {
            $table->foreignId('ou_id')->after('name')->nullable()->constrained('organizational_units');
        });

    }
}
