<?php


namespace App\Command;


use App\Exception\CronException;

class CronResolver
{

    private array $cron;
    private int $minute;
    private int $hour;
    private int $day;
    private int $month;
    private int $dayOfWeak;

    /**
     MIN      Minute field    0 to 59
     HOUR     Hour field      0 to 23
     DOM      Day of Month    1-31
     MON      Month field     1-12
     DOW      Day Of Week     0-6
     */

    public function __construct(string $crontab)
    {
        $this->cron = explode(' ' ,  $crontab);
        if(sizeof($this->cron)  !== 5 ){
            throw new CronException();
        }
        $this->minute  = date('i');
        $this->hour = date('H');
        $this->day = date('d');
        $this->month = date('m');
        $this->dayOfWeak = date('w');
    }

    private function checkOnAsterisk(string $data) : bool{
        $res = false;
        if($data ===  "*")  $res  =  true;
        return $res;
    }


    private function checkMinute() : bool{
        $res  = $this->checkOnAsterisk($this->cron[0]);
        if(!$res){


            if(strpos( $this->cron[0], '/' ) === true){
                $r  = explode('/', $this->cron[0]);
                $value = $this->minute / $r[1];
                if (filter_var($value, FILTER_VALIDATE_INT) === 0 || !filter_var($value, FILTER_VALIDATE_INT) === false) {
                    $res = true;
                }
            }elseif($this->minute == $this->cron[0])
                    $res = true;
        }
        return $res;
    }

    private function checkHour() :bool{
        $res  = $this->checkOnAsterisk($this->cron[1]);
        if(!$res){
            if($this->hour === $this->cron[1])
                $res = true;
        }
        return $res;

    }

    private function checkDay():bool{
        $res  = $this->checkOnAsterisk($this->cron[2]);
        if(!$res){
            if($this->day === $this->cron[2])
                $res = true;
        }
        return $res;
    }

    private function checkMonth():bool{
        $res  = $this->checkOnAsterisk($this->cron[3]) ;
        if(!$res){
            if($this->month === $this->cron[3])
                $res = true;
        }
        return $res;

    }

    private function checkDayOfWeek():bool{
        $res  = $this->checkOnAsterisk($this->cron[4]);
        if(!$res){
            if($this->dayOfWeak === $this->cron[4])
                $res = true;
        }
        return $res ;
    }

    public function getResult():bool{
        return ($this->checkMinute() &
        $this->checkHour() &
        $this->checkDay() &
        $this->checkMonth() &
        $this->checkDayOfWeek());
    }







}
