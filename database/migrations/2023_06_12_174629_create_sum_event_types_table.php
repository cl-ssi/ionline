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
        Schema::create('sum_event_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->tinyinteger('duration')->unsigned()->nullable();
            $table->boolean('require_user')->default(false);
            $table->boolean('require_file')->default(false);
            $table->boolean('start')->default(false);
            $table->boolean('end')->default(false);
            $table->boolean('investigator')->default(false);
            $table->boolean('actuary')->default(false);
            $table->boolean('sub_event')->default(false);
            $table->boolean('repeat')->default(false);
            $table->unsignedTinyInteger('num_repeat')->nullable();
            
            $table->foreignId('summary_type_id')->constrained('sum_types');
            $table->foreignId('summary_actor_id')->nullable()->constrained('sum_actors');
            $table->foreignId('establishment_id')->nullable()->constrained('establishments');
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
        Schema::dropIfExists('sum_event_types');
    }
};
