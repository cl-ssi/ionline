<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Documents\Document;

class AddReservedToDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->boolean('reserved')->nullable()->after('type');
        });

        $documents = Document::withTrashed()->get();
        foreach($documents as $doc) {
            if($doc->type == 'Reservado') {
                $doc->type = 'Oficio';
                $doc->reserved = true;
                $doc->save();
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
        Schema::table('documents', function (Blueprint $table) {
            $table->dropColumn('reserved');
        });
    }
}
