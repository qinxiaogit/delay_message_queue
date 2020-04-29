<?php

declare(strict_types=1);

namespace Owlet\DelayMessage\Tests;


use Owlet\DelayMessage\DelayMessage;

class ProductTest extends TestCase
{
    public function testProduct(){
//        DelayMessage::product()->push("hello world");

        $this->assertIsObject(DelayMessage::product([
            "drive"=>"RabbitMq",
            "host"=>"localhost",
            "port"=>"5672",
            "user"=>"guest",
            "password"=>"guest"
        ]));
//        $this->assertIsString("asdasd","njadad");
    }

    public function testPush(){
        $this->assertEmpty(DelayMessage::product([
            "drive"=>"RabbitMq",
            "host"=>"localhost",
            "port"=>"5672",
            "user"=>"guest",
            "password"=>"guest"
        ])->push('你好中国'));
    }
}