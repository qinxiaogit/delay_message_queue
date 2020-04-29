<?php


namespace Owlet\DelayMessage\Exception;


class InvalidDrive extends Base
{
    /**
     * InvalidDrive constructor.
     * @param string $message
     * @param array $raw
     * @param int $code
     */
    public function __construct($message = "", $raw = [], $code = 0)
    {
        parent::__construct('ERROR_DRIVE: '.$message, $raw, $code);
    }
}