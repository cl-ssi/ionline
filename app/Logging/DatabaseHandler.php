<?php

namespace App\Logging;

use App\Models\Parameters\Log;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;

class DatabaseHandler extends AbstractProcessingHandler
{
    public $table;

    /**
     * Reference:
     * https://github.com/markhilton/monolog-mysql/blob/master/src/Logger/Monolog/Handler/MysqlHandler.php
     */
    public function __construct($level = Logger::DEBUG, $bubble = true)
    {
        $this->table = 'logs';
        parent::__construct($level, $bubble);
    }

    protected function write($record): void
    {
        $data = [
            'user_id'         => (auth()->guard('web')->check() == true) ? auth()->user()->id : null,
            'message'         => $record['message'],
            'uri'             => $_SERVER['REQUEST_URI'] ?? '',
            'formatted'       => $record['formatted'],
            'context'         => json_encode($record['context']),
            'level'           => $record['level'],
            'level_name'      => $record['level_name'],
            'channel'         => $record['channel'],
            'extra'           => json_encode($record['extra']),
            'remote_addr'     => $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? null,
            'user_agent'      => $_SERVER['HTTP_USER_AGENT'] ?? '',
            'record_datetime' => $record['datetime']->format('Y-m-d H:i:s'),
            'created_at'      => date('Y-m-d H:i:s'),
        ];

        $log = Log::create($data);

        $log->classify();
    }
}
