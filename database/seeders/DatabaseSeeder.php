<?php

namespace Database\Seeders;

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
        $this->call(CountrySeeder::class);
        $this->call(CommuneSeeder::class);
        $this->call(EstablishmentSeeder::class);
        $this->call(OrganizationalUnitSeeder::class);
        $this->call(RoleAndPermissionSeeder::class);
        $this->call(AddParametersPermissions::class);
        $this->call(UserSeeder::class);
        $this->call(LocationSeeder::class);
        $this->call(CourtSeeder::class);
        $this->call(PoliceUnitSeeder::class);
        $this->call(SubstanceSeeder::class);
        $this->call(ReceptionSeeder::class);
        $this->call(TelephoneSeeder::class);
        $this->call(PlaceSeeder::class);
        $this->call(ProfessionSeeder::class);
        $this->call(MinisterialProgramTableSeeder::class);
        $this->call(ActionTypeTableSeeder::class);
        $this->call(AuthoritySeeder::class);

        /* Honorarios Service Request */
        $this->call(ServiceRequestSeeder::class);
        $this->call(FulfillmentSeeder::class);
        $this->call(SignatureFlowSeeder::class);
        $this->call(ProfessionalSeeder::class);

        /* SEED PARA MANTENEDORES DE REPLACEMENT STAFF */
        $this->call(ProfileManageSeeder::class);
        $this->call(ProfessionManageSeeder::class);
        $this->call(LegalQualityManageSeeder::class);
        $this->call(RstFundamentSeeder::class);
        $this->call(RstFundamentDetailSeeder::class);

        /* SEED PARA MANTENEDORES DE ABASTECIEMIENTOS */
        $this->call(PurchaseMechanismSeeder::class);
        $this->call(PurchaseTypeSeeder::class);
        $this->call(UnitOfMeasurementSeeder::class);
        $this->call(BudgetItemSeeder::class);
        $this->call(PurchaseUnitSeeder::class);

    }
}
