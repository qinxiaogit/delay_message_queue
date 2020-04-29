<?php

namespace Owlet\DelayMessage\Drive;


use Owlet\DelayMessage\Tools\Singleton;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use Yansongda\Supports\Config;

abstract class Mq
{
    use Singleton;
    /**
     * @var $connect AMQPStreamConnection
     */
    protected $connect;
    /**
     * @var Config $config
     */
    protected $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    protected function connect(){
    }

    public function push(string $message){
    }

    public function pop(callable $callback){

    }
}