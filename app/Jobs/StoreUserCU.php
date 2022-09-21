<?php

namespace App\Jobs;

use App\Models\ClaveUnica;
use Illuminate\Support\Facades\Http;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class StoreUserCU implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    /**
     * The claveUnica instance.
     *
     * @var \App\ClaveUnica
     */
    protected $access_token;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($access_token)
    {
        $this->access_token = $access_token;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $url_base = "https://www.claveunica.gob.cl/openid/userinfo";
		$response = Http::withToken($this->access_token)->post($url_base);
		
		if($response->getStatusCode() == 200) {
			$json = json_decode($response);
			
			ClaveUnica::create([
				'user_id' => $json->RolUnico->numero,
				'access_token' => $this->access_token,
				'response' => json_encode($json)
			]);
		}
    }
}
