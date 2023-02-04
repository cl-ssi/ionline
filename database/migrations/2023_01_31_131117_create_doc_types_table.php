<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Documents\Type;

class CreateDocTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doc_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->boolean('doc_digital')->nullable();
            $table->boolean('partes_exclusive')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });


        // Call seeder table
        Artisan::call('db:seed', [
            '--class' => 'TypeSeeder',
            '--force' => true
        ]);

        Type::where('name','Ordinario')->first()->delete();

        Schema::table('documents', function (Blueprint $table) {
            $table->foreignId('type_id')->after('type')->nullable()->constrained('doc_types');
        });

        Schema::table('partes', function (Blueprint $table) {
            $table->foreignId('type_id')->after('type')->nullable()->constrained('doc_types');
        });

        Schema::table('doc_correlatives', function (Blueprint $table) {
            $table->foreignId('type_id')->after('type')->nullable()->constrained('doc_types');
        });

        Schema::table('doc_signatures', function (Blueprint $table) {
            $table->foreignId('type_id')->after('document_type')->nullable()->constrained('doc_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropConstrainedForeignId('type_id');
        });

        Schema::table('partes', function (Blueprint $table) {
            $table->dropConstrainedForeignId('type_id');
        });

        Schema::table('doc_correlatives', function (Blueprint $table) {
            $table->dropConstrainedForeignId('type_id');
        });

        Schema::table('doc_signatures', function (Blueprint $table) {
            $table->dropConstrainedForeignId('type_id');
        });

        Schema::dropIfExists('doc_types');

    }
}
