<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Requirements\EventStatus;

class AddRequirementIdToReqEventsStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('req_events_status', function (Blueprint $table) {
			$table->id()->first();
			$table->foreignId('requirement_id')->after('event_id')->nullable()->constrained('req_requirements');
        });


		$eventStatuses = EventStatus::with('event','event.requirement')->get();

        foreach($eventStatuses as $status)
        {
			// echo $status->id."\n";
            $status->requirement_id = $status->event->requirement->id ?? null;
            $status->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('req_events_status', function (Blueprint $table) {
            $table->dropColumn('id');
            $table->dropColumn('requirement_id');
        });
    }
}
