<?php


namespace Owlet\DelayMessage\Exception;


class InvalidModule extends Base
{
    /**
     * InvalidModule constructor.
     * @param string $message
     * @param array $raw
     * @param int $code
     */
    public function __construct($message = "", $raw = [], $code = 0)
    {
        parent::__construct('ERROR_GATEWAY: '.$message, $raw, $code);
    }
}