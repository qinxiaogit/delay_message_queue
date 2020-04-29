<?php
namespace Owlet\DelayMessage\Module;

use Owlet\DelayMessage\Drive\Mq;
use Owlet\DelayMessage\Exception\InvalidDrive;
use Yansongda\Supports\Config;

class Product extends Base
{
    /**
     * @var $drive Mq
     */
    protected $drive;
    public function __construct(Config $config)
    {
        $drive = "Owlet\\DelayMessage\\Drive\\".$config->get("drive",'RabbitMQq');
        if(!class_exists($drive)){
            throw new InvalidDrive("invalid drive:".$drive);
        }
        $this->drive = new $drive($config);
    }

    public function push($msg){
        return $this->drive->push($msg);
    }
}