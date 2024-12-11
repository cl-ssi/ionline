<?php

use App\Models\Profile\Subrogation;
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
        $types = ['manager', 'secretary', 'delegate'];

        /**
         * Subrogations by authority
         */
        $subrogationsAuthority = Subrogation::query()
            ->whereNotNull('organizational_unit_id')
            ->groupBy('organizational_unit_id')
            ->get('organizational_unit_id');

        $idSubrogations = $subrogationsAuthority->unique('organizational_unit_id')->values()->pluck('organizational_unit_id');

        foreach ($idSubrogations as $idSubrogation) {
            foreach ($types as $type) {
                $subrogationsByOU = Subrogation::query()
                    ->whereOrganizationalUnitId($idSubrogation)
                    ->whereType($type)
                    ->get();

                foreach ($subrogationsByOU as $index => $subrogationByOU) {
                    $subrogationByOU->update([
                        'level' => $index + 1,
                    ]);
                }
            }
        }

        /**
         * Subrogations by user
         */
        $subrogations = Subrogation::query()
            ->whereNull('organizational_unit_id')
            ->get('user_id');

        $subrogationsUser = $subrogations->unique('user_id')->values()->pluck('user_id');

        foreach ($subrogationsUser as $subrogationUser) {
            $subrogations = Subrogation::query()
                ->whereNull('organizational_unit_id')
                ->whereUserId($subrogationUser)
                ->get();

            foreach ($subrogations as $index => $subrogation) {
                $subrogation->update([
                    'level' => $index + 1,
                ]);
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
        Schema::table('rrhh_subrogations', function (Blueprint $table) {
            //
        });
    }
};
