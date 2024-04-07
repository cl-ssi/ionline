<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Requirements\Event;
use App\Models\Documents\Parte;
use App\Models\User;

class DeriveDirectionRequirements extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sgr:derive-direction';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deriva los requerimientos de la funcionaria Diana Jofre a Gema Jimenez';

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
        // requerimiento creado por parte
        // solo se derivar a gema requerimientos abiertos, que creados por diana, en los que gema no sea participe
        // les crea un evento de derivacion a gema

        try {
            
            $partes = Parte::whereHas('requirements', function ($query) {
                $query->where('user_id',10131640)
                    ->where('created_at','>=','2023-01-01');
            })->get();
            
            $to_user = User::where('id', 10248622)->first(); //gema
            $from_user = User::where('id', 10131640)->first(); //diana
    
            $count_reqs = 0;
            foreach($partes as $parte){
                foreach($parte->requirements as $req){
    
                    // si requerimiento se encuentra cerrado, se pasa al siguiente
                    if($req->status == "cerrado"){
                        continue;
                    }
    
                    // si en los eventos participa gema, se pasa al siguiente req
                    if($req->events->where('from_user_id',10248622)->count()>0){
                        continue;
                    }
                    if($req->events->where('to_user_id',10248622)->count()>0){
                        continue;
                    }
    
                    $requirementEvent = new Event();
                    $requirementEvent->status = "derivado";
                    $requirementEvent->from_user_id = $from_user->id;
                    $requirementEvent->from_ou_id = $from_user->organizational_unit_id;
                    $requirementEvent->to_user_id = $to_user->id;
                    $requirementEvent->to_ou_id = $to_user->organizational_unit_id;
                    $requirementEvent->requirement_id = $req->id;
                    $requirementEvent->to_authority = 0;
                    $requirementEvent->save();
    
                    $count_reqs += 1;
                    
                }    
            }
            print("Se crearon " . $count_reqs . " eventos en copia.");
   
        } catch (Exception $e) {
            print('Excepción capturada: '.  $e->getMessage(). "\n");
        }


        return 0;
    }
}
