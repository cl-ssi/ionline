<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Parameters\Holiday;

class AddRegionIdToCfgHolidaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cfg_holidays', function (Blueprint $table) {
            $table->foreignId('region_id')->after('name')->nullable()->constrained('cl_regions');
        });

        $holidays = Holiday::whereNotNull('region')->get();
        foreach($holidays as $holiday) {
            switch($holiday->region) {
                case 'I': $holiday->region_id = 1; break;
                case 'II': $holiday->region_id = 2; break;
                case 'III': $holiday->region_id = 3; break;
                case 'IV': $holiday->region_id = 4; break;
                case 'V': $holiday->region_id = 5; break;
                case 'VI': $holiday->region_id = 6; break;
                case 'VII': $holiday->region_id = 7; break;
                case 'VIII': $holiday->region_id = 8; break;
                case 'IX': $holiday->region_id = 9; break;
                case 'X': $holiday->region_id = 10; break;
                case 'XI': $holiday->region_id = 11; break;
                case 'XII': $holiday->region_id = 12; break;
                case 'XIII': $holiday->region_id = 13; break;
                case 'XIV': $holiday->region_id = 14; break;
                case 'XV': $holiday->region_id = 15; break;
                case 'XVI': $holiday->region_id = 16; break;
            }
            $holiday->save();
        }

        Schema::table('cfg_holidays', function (Blueprint $table) {
            $table->dropColumn('region');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cfg_holidays', function (Blueprint $table) {
            $table->dropConstrainedForeignId('region_id');
        });
    }
}
