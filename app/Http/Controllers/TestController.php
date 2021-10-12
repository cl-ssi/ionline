<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class TestController extends Controller
{
    public function index()
    {
        $endpoint="https://api.github.com/repos/cl-ssi/urgency/"; //issues?state=all
        $client = new Client(['base_uri' => $endpoint]);
        $auth = array(env('GITHUB_USER'), env('GITHUB_TOKEN'));

        $headers = array('auth' => $auth);
        $response = $client->request('GET', "issues?state=open", $headers);
        $issues = json_decode($response->getBody());

        // <!-- GanttStart: 2021-10-06 -->
        // <!-- GanttDue: 2021-10-08 -->
        // <!-- GanttProgress: 38% -->

        foreach($issues as $key => $issue) {
            $resources[$key]['id'] = $issue->id;
            $resources[$key]['title'] = $issue->title;

            if($issue->number == 233) {

                echo "numero 23";
                echo '<pre>'. htmlspecialchars($issue->body) . "</pre>";
                $patron = '/GanttDue: (?P<value>\d{4}-\d{2}-\d{2})/';
                $sustitucion = 'GanttDue: 2021-10-19';
                $issue->body = preg_replace($patron, $sustitucion, $issue->body);
                //echo '<pre>'. htmlspecialchars($issue->body) . "</pre>";

                $headers = array(
                    'auth' => $auth,
                    'Accept' => 'application/vnd.github.v3+json',
                    'body' => json_encode(['body' => $issue->body])
                );

                $response = $client->request('PATCH',"issues/$issue->number",$headers);

            }

            $events[$key]['resourceId'] = $issue->id;
            $events[$key]['title'] = $issue->title . ' ' . $issue->number;
            $events[$key]['start'] = $this->getStart($issue);
            $events[$key]['end'] = $this->getDue($issue);
            //echo '<h1>'.$issue->title.'</h1>';
            //echo '<pre>'. htmlspecialchars($issue->body) . "</pre>";
            //echo '<br>';
            //echo "<li>GanttStart: " . $this->getStart($issue) . "</li>";
            //echo "<li>GanttDue: " . $this->getDue($issue) . "</li>";
            //echo "<li>GanttProgress: " . $this->getProgress($issue) . "</li>";
        }
        $resources = json_encode($resources);
        $events = json_encode($events);

        // $response = $client->request('GET', "issues/23", $auth);
        // $issue = json_decode($response->getBody());
        // echo '<pre>'. htmlspecialchars($issue->title) . "</pre>";

        //dd($events);
	    return view('test.gantt')
            ->withResources($resources)
            ->withEvents($events);
    }

    public function getStart($issue) {
        preg_match_all('/GanttStart: (?P<value>\d{4}-\d{2}-\d{2})/', $issue->body, $result);
        return ($result['value']) ? $result['value'][0] : null;
    }
    public function getDue($issue) {
        preg_match_all('/GanttDue: (?P<value>\d{4}-\d{2}-\d{2})/', $issue->body, $result);
        return ($result['value']) ? $result['value'][0] : null;
    }
    public function getProgress($issue) {
        /* Si el issue está cerrado, se asume un 100% */
        if($issue->state == 'closed') return '100';
        else {
            preg_match_all('/GanttProgress: (?P<value>\d+)/', $issue->body, $result);
            return ($result['value']) ? $result['value'][0] : '0';
        }
    }

    /*
    curl -X PATCH -H "Accept: application/vnd.github.v3+json" https://api.github.com/repos/cl-ssi/urgency/issues/22 -d '{"title":"Second Up"}'
  */
}
