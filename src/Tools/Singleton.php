<?php
namespace Owlet\DelayMessage\Tools;

trait Singleton
{
    protected $instance ;
    function getInstance(...$args){
        if(is_null($this->instance)){
            $this->instance = new self(...$args);
        }
        return $this->instance;
    }
}