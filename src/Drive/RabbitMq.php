<?php
namespace Owlet\DelayMessage\Drive;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Wire\AMQPTable;
use Yansongda\Supports\Config;

class RabbitMq extends Mq
{
    /**
     * @var \PhpAmqpLib\Channel\AMQPChannel
     */
    protected $ch;
    public function __construct(Config $conf)
    {
        parent::__construct($conf);
        $this->connect();
        $this->ch = $this->connect->channel();
        /**
         * @desc 申明交换机
         */
        $this->declareExchange();
        /**
         * @desc 申明队列
         */
        $this->declareQueue();
        /**
         * @desc 绑定交换机和队列
         */
        $this->ch->queue_bind($this->config->get("queue",'delayed_queue'),$this->config->get("exchange",'delayed_exchange'));
    }

    /**
     *
     */
    protected function connect()
    {
        $this->connect = new  AMQPStreamConnection(
            $this->config->get("host"),
            $this->config->get("port"),
            $this->config->get("user"),
            $this->config->get("password"),
            $this->config->get('vhost','/')
        );
    }
    protected function declareExchange(){
        $this->ch->exchange_declare($this->config->get("exchange",'delayed_exchange'),'x-delayed-message',false,true,
            false,false,false,new AMQPTable([
                "x-delayed-type"=>AMQPExchangeType::FANOUT
            ]));
    }

    protected function declareQueue(){
        $this->ch->queue_declare($this->config->get("queue",'delayed_queue'), false, false, false, false, false, new AMQPTable(array(
            "x-dead-letter-exchange" => "delayed"
        )));
    }



    /**
     * @param $msg
     * @desc
     */
    public function push(string $msg){
        $headers = new AMQPTable(array("x-delay" => 1000000000));
        $message = new AMQPMessage($msg, array('delivery_mode' => 2));
        $message->set('application_headers', $headers);
        $this->ch->basic_publish($message, 'delayed_exchange');
    }

    /**
     * @param callable $callback
     * @throws \ErrorException
     */
    public function pop(callable $callback){
        register_shutdown_function('shutdown', $this->ch, $this->connect);
        $this->ch->basic_consume($this->config->get("queue","delayed_queue"),
            '', false, false, false, false, $callback);
        while ($this->ch->is_consuming()) {
            $this->ch->wait();
        }
    }
    protected function shutdown(){
        $this->ch->close();
        $this->connect->close();
    }
}