<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Documents\Signature;

class AddReservedToDocSignaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('doc_signatures', function (Blueprint $table) {
        //     $table->boolean('reserved')->nullable()->after('document_type');
        // });

        $signatures = Signature::withTrashed()->get();
        foreach($signatures as $signature) {
            if($signature->document_type == 'Reservado') {
                $signature->document_type = 'Oficio';
                $signature->reserved = true;
                $signature->save();
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
        Schema::table('doc_signatures', function (Blueprint $table) {
            $table->dropColumn('reserved');
        });
    }
}
