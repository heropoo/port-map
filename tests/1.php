<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Workerman\Worker;

// 初始化一个Channel服务端
$channelServer = new Channel\Server('0.0.0.0', 2206);

// websocket服务端
$worker = new Worker('websocket://0.0.0.0:4236');
$worker->name = 'websocket';
$worker->count = 6;

// 每个worker进程启动时
$worker->onWorkerStart = function($worker)
{
    // Channel客户端连接到Channel服务端
    Channel\Client::connect('127.0.0.1', 2206);

    // 订阅broadcast事件，并注册事件回调
    Channel\Client::on('broadcast', function($event_data)use($worker){
        // 向当前worker进程的所有客户端广播消息
        foreach($worker->connections as $connection)
        {
            $connection->send($event_data);
        }
    });
};


$worker->onMessage = function($connection, $data)
{
    // 将客户端发来的数据当做事件数据
    $event_data = $data;
    // 向所有worker进程发布broadcast事件
    \Channel\Client::publish('broadcast', $event_data);
};

Worker::runAll();


