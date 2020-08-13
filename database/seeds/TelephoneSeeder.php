<?php

use Illuminate\Database\Seeder;
use App\Resources\Telephone;
use App\User;
class TelephoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $telephone = Telephone::Create(['number'=>572406984, 'minsal'=>576984]);
        $telephone->users()->attach(User::find(15287582));

        $telephone = Telephone::Create(['number'=>572539004, 'minsal'=>579004]);
        $telephone->users()->attach(User::find(10278387));

        $telephone = Telephone::Create(['number'=>572539008, 'minsal'=>579008]);
        $telephone->users()->attach(User::find(14107361));

        $telephone = Telephone::Create(['number'=>572539009, 'minsal'=>579009]);
        $telephone->users()->attach(User::find(15924400));

        $telephone = Telephone::Create(['number'=>572539518, 'minsal'=>579518]);
        $telephone->users()->attach(User::find(16966444));

        /**
         * Create 10 random telephones.
         */
        factory(App\Resources\Telephone::class, 10)->create();

    }
}
