<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Documents\Type;
use App\Models\Documents\Signature;
use App\Models\Documents\Parte;
use App\Models\Documents\Document;
use App\Models\Documents\Correlative;

class UpdateTypeIdOnDocuments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $types = Type::withTrashed()->pluck('id','name')->toArray();

        $documents = Document::withTrashed()->get();
        //'Memo','Oficio','Ordinario','Reservado','Circular','Acta de recepción','Otros','Resolución','Acta de Recepción Obras Menores'
        echo "Actualizando type_id en documentos\n";
        foreach($documents as $doc) {
            switch($doc->type) {
                case 'Memo': $doc->type_id = $types['Memo']; break;
                case 'Ordinario': $doc->type_id = $types['Ordinario']; break;
                case 'Oficio': $doc->type_id = $types['Oficio']; break;
                // case 'Reservado': 
                //     $doc->type_id = $types['Oficio']; 
                //     $doc->reserved = true; 
                //     break;
                case 'Circular': $doc->type_id = $types['Circular']; break;
                case 'Acta de recepción': $doc->type_id = $types['Acta de recepción']; break;
                case 'Otros': $doc->type_id = $types['Otro']; break;
                case 'Resolución': $doc->type_id = $types['Resolución']; break;
                case 'Acta de Recepción Obras Menores': $doc->type_id = $types['Acta de recepción obras menores']; break;
                default: echo "Doc: " . $doc->id . "-" . $doc->type . "\n";
            }
            $doc->save();
        }

        $partes = Parte::withTrashed()->get();
        //'Memo','Oficio','Ordinario','Carta','Circular','Reservado','Decreto','Demanda','Informe','Otro','Permiso Gremial','Resolución'
        echo "Actualizando type_id en partes\n";
        foreach($partes as $parte) {
            switch($parte->type) {
                case 'Memo': $parte->type_id = $types['Memo']; break;
                case 'Ordinario': $parte->type_id = $types['Ordinario']; break;
                case 'Oficio': $parte->type_id = $types['Oficio']; break;
                case 'Carta': $parte->type_id = $types['Carta']; break;
                case 'Circular': $parte->type_id = $types['Circular']; break;
                // case 'Reservado': 
                //         $parte->type_id = $types['Oficio'];
                //         $parte->reserved = true; 
                //         break;
                case 'Decreto': $parte->type_id = $types['Decreto']; break;
                case 'Demanda': $parte->type_id = $types['Demanda']; break;
                case 'Informe': $parte->type_id = $types['Informe']; break;
                case 'Otro': $parte->type_id = $types['Otro']; break;
                case 'Permiso Gremial': $parte->type_id = $types['Permiso Gremial']; break;
                case 'Resolución': $parte->type_id = $types['Resolución']; break;
                default: echo "Doc: " . $parte->id . "-" . $parte->type . "\n";
            }
            $parte->save();
        }


        $correlatives = Correlative::all();
        //'Memo','Ordinario','Reservado','Circular','Acta de recepción','Otros','Oficio','Resolución','Acta de Recepción Obras Menores'
        echo "Actualizando type_id en correlatives\n";
        foreach($correlatives as $correlative) {
            switch($correlative->type) {
                case 'Memo': $correlative->type_id = $types['Memo']; break;
                case 'Ordinario': $correlative->type_id = $types['Ordinario']; break;
                case 'Oficio': $correlative->type_id = $types['Oficio']; break;
                //case 'Reservado': $correlative->type_id = $types['Reservado']; break;
                case 'Circular': $correlative->type_id = $types['Circular']; break;
                case 'Acta de recepción': $correlative->type_id = $types['Informe']; break;
                case 'Otros': $correlative->type_id = $types['Otro']; break;
                case 'Resolución': $correlative->type_id = $types['Resolución']; break;
                case 'Acta de Recepción Obras Menores': $correlative->type_id = $types['Acta de recepción obras menores']; break;
                
                default: echo "Correlative: ". $correlative->id."\n";
            }
            $correlative->save();
        }

        $signatures = Signature::withTrashed()->get();
        //'Memo','Ordinario','Reservado','Circular','Acta de recepción','Otros','Oficio','Resolución','Acta de Recepción Obras Menores'
        echo "Actualizando type_id en doc_signatures \n";
        foreach($signatures as $sig) {
            switch($sig->document_type) {
                case 'Acta': $sig->type_id = $types['Acta']; break;
                case 'Carta': $sig->type_id = $types['Carta']; break;
                case 'Circular': $sig->type_id = $types['Circular']; break;
                case 'Convenios': $sig->type_id = $types['Convenio']; break;
                case 'Memorando': $sig->type_id = $types['Memo']; break;
                case 'Oficio': $sig->type_id = $types['Oficio']; break;
                case 'Protocolo': $sig->type_id = $types['Protocolo']; break;
                // case 'Reservado': 
                //     $sig->type_id = $types['Oficio'];
                //     $sig->reserved = true;
                //     break;
                case 'Resoluciones': $sig->type_id = $types['Resolución']; break;
                
                default: echo "Firma: ". $sig->id."\n";
            }
            $sig->save();
        }

        Schema::table('documents', function (Blueprint $table) {
            $table->dropColumn('type');
        });

        Schema::table('partes', function (Blueprint $table) {
            $table->dropColumn('type');
        });

        Schema::table('doc_correlatives', function (Blueprint $table) {
            $table->dropColumn('type');
        });

        Schema::table('doc_signatures', function (Blueprint $table) {
            $table->dropColumn('document_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
