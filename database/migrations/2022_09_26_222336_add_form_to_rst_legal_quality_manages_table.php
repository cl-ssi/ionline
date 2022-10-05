<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\ReplacementStaff\LegalQualityManage;

class AddFormToRstLegalQualityManagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rst_legal_quality_manages', function (Blueprint $table) {
            $table->boolean('replacement')->after('name')->nullable();
            $table->boolean('announcement')->after('replacement')->nullable();
        });

        // $legalQualities = LegalQualityManage::all();

        // foreach($legalQualities as $legalQuality)
        // {
        //     if($legalQuality->name == 'to hire')
        //     {
        //         $legalQuality->replacement = true;
        //         $legalQuality->announcement = false;
        //         $legalQuality->save();
        //     }
        //     if($legalQuality->name == 'fee')
        //     {
        //         $legalQuality->replacement = true;
        //         $legalQuality->announcement = true;
        //         $legalQuality->save();
        //     }
        // }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rst_legal_quality_manages', function (Blueprint $table) {
            $table->dropColumn(['replacement']);
            $table->dropColumn(['announcement']);
        });
    }
}
