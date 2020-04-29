<?php


namespace Owlet\DelayMessage;

use Owlet\DelayMessage\Exception\Base;
use Owlet\DelayMessage\Exception\InvalidModule;
use Owlet\DelayMessage\Module\Consume;
use Owlet\DelayMessage\Module\Product;
use Yansongda\Supports\Config;

use Owlet\DelayMessage\Module\Base as MBase;

/**
 * @method static Product product(array $config)
 * @method static Consume consume(array $config);
 * @des 延迟消息
 * Class DelayMessage
 * @package Owlet\DelayMessage
 */

class DelayMessage
{
    /**
     * Config.
     *
     * @var Config
     */
    protected $config;

    /**
     * Bootstrap.
     *
     * @param array $config
     * @author yansongda <me@yansongda.cn>
     *
     */
    public function __construct(array $config)
    {
        $this->config = new Config($config);

//        $this->registerLogService();
//        $this->registerEventService();
    }
    public static function __callStatic($name, $params)
    {
        $app = new self(...$params);
        return $app->create($name);
    }
    protected  function create($name){
        $module = __NAMESPACE__."\\Module\\".ucfirst($name);
        if(!class_exists($module)){
            throw new InvalidModule("module ".$name. " not exists");
        }
        return $this->make($module);
    }

    /**
     * Make a gateway.
     *
     * @author yansongda <me@yansonga.cn>
     *
     * @param string $gateway
     *
     * @throws InvalidModule
     * @return MBase
     */
    protected function make($gateway): MBase
    {
        $app = new $gateway($this->config);

        if ($app instanceof MBase) {
            return $app;
        }
        throw new InvalidModule("Gateway [{$gateway}] Must Be An Instance Of Module Base");
    }
}