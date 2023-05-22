<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\RequestForms\ImmediatePurchase;

class ImmediatepurchaesSetRequestformid extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:immediatepurchases-set-requestformid';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setea los request_form_id en cada uno de los inmediate_purchases';

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
        $immediatePurchases = ImmediatePurchase::all();
        try {
            foreach($immediatePurchases as $immediatePurchase){
                if($immediatePurchase->tender_id) {
                    $immediatePurchase->request_form_id = $immediatePurchase->tender->purchasingProcessDetail->purchasingProcess->requestForm()->first()->id;
                }
                elseif($immediatePurchase->direct_deal_id) {
                    $immediatePurchase->request_form_id = $immediatePurchase->directDeal->purchasingProcessDetail->purchasingProcess->requestForm()->first()->id;
                }
                else {
                    if($immediatePurchase->purchasingProcessDetail){
                        if($immediatePurchase->purchasingProcessDetail->purchasingProcess){
                            $immediatePurchase->request_form_id = $immediatePurchase->purchasingProcessDetail->purchasingProcess->requestForm()->first()->id;
                        }
                    } 
                }
                $immediatePurchase->save();
            }
        } catch (Exception $e) {
            print('Excepción capturada: '.  $e->getMessage(). "\n");
        }

        

        return 0;
    }
}
