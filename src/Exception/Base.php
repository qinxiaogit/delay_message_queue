<?php
namespace Owlet\DelayMessage\Exception;


class Base extends \Exception
{
    /**
     * @var array
     */
    public $raw;

    public function __construct($message = "", $raw = [],$code = 0)
    {
        $message = '' === $message ? 'Unknown Error' : $message;
        $this->raw = is_array($raw) ? $raw : [$raw];

        parent::__construct($message, $code);
    }
}