<?php
namespace Tests;

use PHPUnit\Framework\TestCase;

use Workerman\Worker;
use Channel\Server as ChannelServer;


class ServerTest extends TestCase
{
    public function testServer(){
        //Tcp 通讯方式
//        $channelServer = new ChannelServer("0.0.0.0", 2206);
        $this->assertTrue(true);
//        if(!defined('GLOBAL_START'))
//        {
//            Worker::runAll();
//        }
    }
}