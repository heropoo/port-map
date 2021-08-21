<?php
/**
 * User: heropoo
 * Datetime: 2021/6/17 00:19
 */

require_once __DIR__ . '/../vendor/autoload.php';

use Workerman\Worker;
use Workerman\Connection\TcpConnection;

$config = require __DIR__ . '/../conf/portmap.php';

foreach ($config['port_map'] as $key => $item){
    //TODO
    $worker = new Worker("tcp://".$item['local_host'].":" . $item['local_port']);

    // 启动4个进程对外提供服务
    $worker->count = 4;

    // 当客户端发来数据时
    $worker->onMessage = function (TcpConnection $connection, $data) {
        // 向客户端发送hello $data
        $connection->send('hello ' . $data);
    };
}

// 运行worker
Worker::runAll();