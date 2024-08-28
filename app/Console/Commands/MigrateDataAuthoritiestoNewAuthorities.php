<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Rrhh\Authority;
use App\Models\Rrhh\NewAuthority;
use Carbon\Carbon;


class MigrateDataAuthoritiestoNewAuthorities extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:data-authorities-to-new-authorities';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migra datos de la tabla authorities a new authorities';


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {


        $organizationalUnits = Authority::select('organizational_unit_id')->distinct()->get();

        foreach ($organizationalUnits as $unit) {
            $minValue = Authority::where('organizational_unit_id', $unit->organizational_unit_id)->min('from');
            $maxValue = Authority::where('organizational_unit_id', $unit->organizational_unit_id)->max('to');
            $currentDate = Carbon::parse($minValue);
            $maxDate = Carbon::parse($maxValue);
            while ($currentDate->lte($maxDate)) {
                $authorityManager = Authority::getAuthorityFromDate($unit->organizational_unit_id, $currentDate, 'manager');
                $authorityDelegate = Authority::getAuthorityFromDate($unit->organizational_unit_id, $currentDate, 'delegate');
                $authoritySecretary = Authority::getAuthorityFromDate($unit->organizational_unit_id, $currentDate, 'secretary');
                if ($authorityManager) {
                    echo "Autoridad de Tipo Manager encontrada en fecha " . $currentDate->format('d-m-Y') . "\n";
                    // Aquí viene el codigo para añadir el dato encontrado en NewAuthority
                    $newAuthority = new NewAuthority();
                    $newAuthority->user_id = $authorityManager->user_id;
                    $newAuthority->organizational_unit_id = $authorityManager->organizational_unit_id;
                    $newAuthority->date = $currentDate;
                    $newAuthority->position = $authorityManager->position;
                    $newAuthority->type = 'manager';
                    $newAuthority->decree = $authorityManager->decree;
                    $newAuthority->representation_id = $authorityManager->representation_id;
                    $newAuthority->save();
                }
                if ($authorityDelegate) {
                    echo "Autoridad de Tipo Delegate encontrada en fecha " . $currentDate->format('d-m-Y') . "\n";
                    // Aquí viene el codigo para añadir el dato encontrado en NewAuthority
                    if (!NewAuthority::where('date', $currentDate)
                        ->where('user_id', $authorityDelegate->user_id)
                        ->where('type', 'delegate')
                        ->exists()) {
                        $newAuthority = new NewAuthority();
                        $newAuthority->user_id = $authorityDelegate->user_id;
                        $newAuthority->organizational_unit_id = $authorityDelegate->organizational_unit_id;
                        $newAuthority->date = $currentDate;
                        $newAuthority->position = $authorityDelegate->position;
                        $newAuthority->type = 'delegate';
                        $newAuthority->decree = $authorityDelegate->decree;
                        $newAuthority->representation_id = $authorityDelegate->representation_id;
                        $newAuthority->save();
                    }
                }
                if ($authoritySecretary) {
                    echo "Autoridad de Tipo Secretaria encontrada en fecha " . $currentDate->format('d-m-Y') . "\n";
                    // Aquí viene el codigo para añadir el dato encontrado en NewAuthority
                    if (!NewAuthority::where('date', $currentDate)
                        ->where('user_id', $authoritySecretary->user_id)
                        ->where('type', 'secretary')
                        ->exists()) {
                        $newAuthority = new NewAuthority();
                        $newAuthority->user_id = $authoritySecretary->user_id;
                        $newAuthority->organizational_unit_id = $authoritySecretary->organizational_unit_id;
                        $newAuthority->date = $currentDate;
                        $newAuthority->position = $authoritySecretary->position;
                        $newAuthority->type = 'secretary';
                        $newAuthority->decree = $authoritySecretary->decree;
                        $newAuthority->representation_id = $authoritySecretary->representation_id;
                        $newAuthority->save();
                    }
                }

                $currentDate->addDay();
            }
        }
        return 0;
    }
}
