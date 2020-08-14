<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        $this->call(OrganizationalUnitSeeder::class);
        $this->call(RoleAndPermissionSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(CommuneSeeder::class);
        $this->call(EstablishmentSeeder::class);
        $this->call(LocationSeeder::class);
        $this->call(CourtSeeder::class);
        $this->call(PoliceUnitSeeder::class);
        $this->call(SubstanceSeeder::class);
        $this->call(ReceptionSeeder::class);
        $this->call(TelephoneSeeder::class);
        $this->call(PlaceSeeder::class);

    }
}
