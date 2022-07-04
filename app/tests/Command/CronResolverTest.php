<?php

namespace App\Tests\Command;

use App\Command\CronResolver;
use PHPUnit\Framework\TestCase;

class CronResolverTest extends TestCase
{

/*    public function testGetResult()
    {
        $res =  new CronResolver("* * * * *");
        $this->assertEquals(true , $res->getResult());
    }

    public function testGetResultMinute()
    {
        $res =  new CronResolver("*15 * * * *");

        $this->assertEquals(false , $res->getResult());
    }*/


    public function testGetResultMinuteIsDigit()
    {
        $res =  new CronResolver(date('i')." * * * *");
        $this->assertEquals(true , $res->getResult());
    }


}
