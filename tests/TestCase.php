<?php
namespace Owlet\DelayMessage\Tests;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Wire\AMQPTable;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;

class TestCase extends PHPUnitTestCase
{

    public function setUp()
    {
    }

    public function tearDown()
    {
}
    public function testAA(){
        $this->assertIsString('aaa','aaa');
    }
    public static function start(){

        $method = getopt("m");

        $mod = $method['m']??"default";

        $connection = new AMQPStreamConnection("localhost","5672",'guest','guest');
        $ch = $connection->channel();
        $ch->exchange_declare('delayed_exchange','x-delayed-message',false,true,false,false,
            false,new AMQPTable([
                'x-delayed-type'=>AMQPExchangeType::FANOUT
            ]));
        $ch->queue_declare('delayed_queue',false, false, false, false, false,new AMQPTable([
            "x-dead-letter-exchange"=>"delayed"
        ]));
        $ch->queue_bind('delayed_queue','delayed_exchange');
        $headers = new AMQPTable(array("x-delay" =>30));
        $message = new AMQPMessage("hello world",['delivery_mode'=>2]);
        $message->set('application_headers',$headers);
        $ch->publish_batch($message,'delayed_exchange');
        //消费者消费
        $ch->basic_consume('delayed_queue', '', false, true, false, false,
            function (AMQPMessage $message){
                $headers = $message->get('application_headers');
                $nativeData = $headers->getNativeData();
                var_dump($nativeData);
                $message->delivery_info['channel']->basic_ack($message->delivery_info['delivery_tag']);
            });

        while ($ch->is_consuming()) {
            $ch->wait();
        }
    }

 function  process_message(AMQPMessage $message)
    {

    }

}