<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Workerman\Worker;
use Workerman\Timer;
use Channel\Client as ChannelClient;
use Channel\Server as ChannelServer;

$GLOBALS['channelName'] = 'queue';

$channelServer = new ChannelServer('0.0.0.0', 2206);

$worker = new Worker();
$worker->name = 'Producer';
$worker->onWorkerStart = function () {
    ChannelClient::connect('127.0.0.1', 2206);

    $count = 0;
    Timer::add(1, function (){
        echo "> Put data to queue -- \n";
        ChannelClient::enqueue($GLOBALS['channelName'], 'Hello World ' . time());
    });
};

$mq = new Worker();
$mq->name = 'Consumer';
$mq->count = 4;
$mq->onWorkerStart = function ($worker) {
    ChannelClient::connect('127.0.0.1', 2206);

    //订阅消息 queue
    ChannelClient::watch($GLOBALS['channelName'], function ($data) use ($worker) {
        echo "Worker {$worker->id} get queue: $data\n";
    });

    //10 秒后取消订阅该消息
    Timer::add(10, function () {
        ChannelClient::unwatch($GLOBALS['channelName']);
    }, [], false);
};

Worker::runAll();
