<?php


namespace Owlet\DelayMessage\Tests;


use Owlet\DelayMessage\DelayMessage;

class ConsumeTest extends TestCase
{
    public function testConsume(){
        $this->assertIsObject(
            DelayMessage::consume([
                "drive"=>"RabbitMq",
                "host"=>"localhost",
                "port"=>"5672",
                "user"=>"guest",
                "password"=>"guest"
            ])
        );
    }

}