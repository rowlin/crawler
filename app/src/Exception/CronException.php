<?php


namespace App\Exception;


class CronException extends \LengthException
{

    public function __construct()
    {
        parent::__construct('Ops: crontab is not correct');
    }

}
