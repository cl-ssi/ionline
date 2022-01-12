<?php
namespace App\Logging;
use Monolog\Logger;

class DatabaseVia {
    /**
     * Create a custom Monolog instance.
     *
     *
     * @param  array  $config
     * @return \Monolog\Logger
     */
    public function __invoke(array $config){
        $logger = new Logger("DatabaseHandler");
        return $logger->pushHandler(new DatabaseHandler());
    }
}