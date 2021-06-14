<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

use Workerman\Worker;
use Channel\Server as ChannelServer;
use Channel\Client as ChannelClient;


class ServerTest extends TestCase
{
    public function testStartChannelServer()
    {
        exec('php tests/channel-server.php start -d', $output, $result_code);
        //var_dump($result_code, $output);
        $this->assertEquals(0, $result_code);
        $pidFile =  __DIR__.'/../runtime/test-channel-server.pid';
        $this->assertTrue((int)file_get_contents($pidFile) > 1);
    }

    /**
     * @depends testStartChannelServer
     */
    public function testConnectToChannelServer()
    {
        // Channel客户端连接到Channel服务端
        ChannelClient::connect('127.0.0.1', 2206);
    }

    /**
     * @depends testStartChannelServer
     */
    public function testStopChannelServer()
    {
        exec('php tests/channel-server.php stop', $output, $result_code);
        //var_dump($result_code, $output);
        $this->assertEquals(0, $result_code);
        $pidFile =  __DIR__.'/../runtime/test-channel-server.pid';
        $this->assertFalse(file_exists($pidFile));
    }
}