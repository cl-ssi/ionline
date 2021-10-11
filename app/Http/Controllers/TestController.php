<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class TestController extends Controller
{
    public function index()
    {
        $auth = ['auth' => [env('GITHUB_USER'), env('GITHUB_TOKEN')]];
        $endpoint="https://api.github.com/repos/cl-ssi/ionline/"; //issues?state=all
        $client = new Client(['base_uri' => $endpoint]);
        $response = $client->request('GET', "issues?state=all", $auth);
        $issues = json_decode($response->getBody());

        // <!-- GanttStart: 2021-10-06 -->
        // <!-- GanttDue: 2021-10-08 -->
        // <!-- GanttProgress: 38% -->

        foreach($issues as $issue) {
            echo '<h1>'.$issue->title.'</h1>';
            echo '<pre>'. htmlspecialchars($issue->body) . "</pre>";
            echo '<br>';
            echo "<li>GanttStart: " . $this->getStart($issue) . "</li>";
            echo "<li>GanttDue: " . $this->getDue($issue) . "</li>";
            echo "<li>GanttProgress: " . $this->getProgress($issue) . "</li>";
        }
	return view('test.gantt');
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
        /* Si esl issue está cerrado, se asume un 100% */
        if($issue->state == 'closed') return '100';
        else {
            preg_match_all('/GanttProgress: (?P<value>\d+)/', $issue->body, $result);
            return ($result['value']) ? $result['value'][0] : '0';
        }
    }
}
