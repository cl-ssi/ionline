<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

use Carbon\Carbon;
use App\Rrhh\OrganizationalUnit;
use App\Models\WebService\MercadoPublico;
use App\Models\Establishment;
use App\Jobs\TestJob;

class TestController extends Controller
{
    public function getIp()
    {
        if ( !empty($_SERVER['HTTP_CLIENT_IP']) ) {
            // Check IP from internet.
            // 'ip' => request()->getClientIp(),
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']) ) {
            // Check IP is passed from proxy.
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            // Get IP address from remote address.
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        
        logger()->info($ip);
        //Storage::disk('local')->prepend('log_ips.txt', $ip);
        return $ip;
    }

    /*
    curl -X PATCH -H "Accept: application/vnd.github.v3+json" https://api.github.com/repos/cl-ssi/urgency/issues/22 -d '{"title":"Second Up"}'
    */

    public function getMercadoPublicoTender($date)
    {
        $tenders = MercadoPublico::getTender(Carbon::parse($date));
        dd($tenders);
    }

    public function log()
    {
        $user = \App\User::find(1528758);
        echo $user->name;
        Log::info('primer log');
        echo "Primer log";
    }

    public function info()
    {
        phpinfo();
    }

    /**
    * No cargar 
    */
    public function loopLivewire()
    {
        $ous = OrganizationalUnit::all();

        foreach($ous as $ou)
        {
            // @livewire( parametro ou)
            $estab = Establishment::where('id', $ou->establishment_id)->first();
            // echo $estab->id."<br>";
            if($estab->type == 'HOSPITAL')
            {
                echo $estab->name."<br>";
            } 
            // fin de livewire
        }

    }


    /**
    * Test Job
    */
    public function job()
    {
        TestJob::dispatch(auth()->user())
            // ->onConnection('cloudtasks')
            ->delay(15);

        return view('mails.test', [
            'user' => auth()->user()
        ]);
        
        // return "Test Job Dispatch";
    }


    /**
    * Test de cards en teams
    */
    public function SendCardToTeams()
    {
        $wh = env('LOG_TEAMS_WEBHOOK_URL_ATORRES');

        // $data['text'] = 'Hello world';

        $data = [
            "@type" => "MessageCard",
            "@context" => "http://schema.org/extensions",
            "themeColor" => "0076D7",
            "summary" => "Larry Bryant created a new task",
            "sections" => [
                [
                    "activityTitle" => "Larry Bryant created a new task",
                    "activitySubtitle" => "On Project Tango",
                    "activityImage" =>
                        "https://teamsnodesample.azurewebsites.net/static/img/image5.png",
                    "facts" => [
                        [
                            "name" => "Assigned to",
                            "value" => "Unassigned",
                        ],
                        [
                            "name" => "Due date",
                            "value" =>
                                "Mon May 01 2017 17:07:18 GMT-0700 (Pacific Daylight Time)",
                        ],
                        [
                            "name" => "Status",
                            "value" => "Not started",
                        ],
                    ],
                    "markdown" => true,
                ],
            ],
            "potentialAction" => [
                [
                    "@type" => "ActionCard",
                    "name" => "Add a comment",
                    "inputs" => [
                        [
                            "@type" => "TextInput",
                            "id" => "comment",
                            "isMultiline" => false,
                            "title" => "Add a comment here for this task",
                        ],
                    ],
                    "actions" => [
                        [
                            "@type" => "HttpPOST",
                            "name" => "Add comment",
                            "target" =>
                                "https://learn.microsoft.com/outlook/actionable-messages",
                        ],
                    ],
                ],
                [
                    "@type" => "ActionCard",
                    "name" => "Set due date",
                    "inputs" => [
                        [
                            "@type" => "DateInput",
                            "id" => "dueDate",
                            "title" => "Enter a due date for this task",
                        ],
                    ],
                    "actions" => [
                        [
                            "@type" => "HttpPOST",
                            "name" => "Save",
                            "target" =>
                                "https://learn.microsoft.com/outlook/actionable-messages",
                        ],
                    ],
                ],
                [
                    "@type" => "OpenUri",
                    "name" => "Post x More",
                    "targets" => [
                        [
                            "os" => "default",
                            "uri" =>
                                "http://localhost:8000/postx",
                        ],
                    ],
                ],
                [
                    "@type" => "ActionCard",
                    "name" => "Change status",
                    "inputs" => [
                        [
                            "@type" => "MultichoiceInput",
                            "id" => "list",
                            "title" => "Select a status",
                            "isMultiSelect" => "false",
                            "choices" => [
                                [
                                    "display" => "In Progress",
                                    "value" => "1",
                                ],
                                [
                                    "display" => "Active",
                                    "value" => "2",
                                ],
                                [
                                    "display" => "Closed",
                                    "value" => "3",
                                ],
                            ],
                        ],
                    ],
                    "actions" => [
                        [
                            "@type" => "HttpPOST",
                            "name" => "Save",
                            "target" =>
                                "https://learn.microsoft.com/outlook/actionable-messages",
                        ],
                    ],
                ],
            ],
        ];
        
    
        $response = Http::withBody(json_encode($data), 'application/json')->post($wh);

        if ($response->failed()) {
            dd(json_decode($response->getBody(), true));
         } else {
            dd('success');
         }
    }

}
