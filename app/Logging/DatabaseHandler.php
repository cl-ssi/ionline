<?php
namespace App\Logging;
// use Illuminate\Log\Logger;
use DB;
use Illuminate\Support\Facades\Auth;
use Monolog\Logger;
use Monolog\Handler\AbstractProcessingHandler;

class DatabaseHandler extends AbstractProcessingHandler{
/**
 *
 * Reference:
 * https://github.com/markhilton/monolog-mysql/blob/master/src/Logger/Monolog/Handler/MysqlHandler.php
 */
    public function __construct($level = Logger::DEBUG, $bubble = true) {
        $this->table = 'logs';
        parent::__construct($level, $bubble);
    }
    protected function write(array $record):void
    {
       $data = array(
           'user_id'       => auth()->user()->id ?? '',
           'message'       => $record['message'],
           'uri'           => $_SERVER['REQUEST_URI'] ?? '',
           'formatted'     => $record['formatted'],

           'context'       => json_encode($record['context']),
           'level'         => $record['level'],
           'level_name'    => $record['level_name'],
           'channel'       => $record['channel'],
           
           'extra'         => json_encode($record['extra']),
           'remote_addr'   => $_SERVER['REMOTE_ADDR'] ?? '',
           'user_agent'    => $_SERVER['HTTP_USER_AGENT'] ?? '',
           'record_datetime' => $record['datetime']->format('Y-m-d H:i:s'),
           'created_at'    => date("Y-m-d H:i:s"),
       );
       DB::connection()->table($this->table)->insert($data);

       //dd($record);
    }
}