<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('UPDATE model_has_permissions SET model_type="App\\\Models\\\User" WHERE model_type="App\\\User"');
        DB::statement('UPDATE model_has_roles       SET model_type="App\\\Models\\\User" WHERE model_type="App\\\User"');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('UPDATE model_has_permissions SET model_type="App\\\User" WHERE model_type="App\\\Models\\\User"');
        DB::statement('UPDATE model_has_roles       SET model_type="App\\\User" WHERE model_type="App\\\Models\\\User"');
    }
};
