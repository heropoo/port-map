<?php
/**
 *
 * php server.php start -d
 *
 * User: heropoo
 * Datetime: 2021/6/17 00:09
 */

require_once __DIR__ . '/../vendor/autoload.php';

use Workerman\Worker;

$config = require __DIR__ . '/../conf/portmap.php';

$worker = new Worker("tcp://0.0.0.0:" . $config['server']['port']);

// 启动4个进程对外提供服务
$worker->count = 4;

// 当客户端发来数据时
$worker->onMessage = function ($connection, $data) {
    // 向客户端发送hello $data
    $connection->send('hello ' . $data);
};

// 运行worker
Worker::runAll();



