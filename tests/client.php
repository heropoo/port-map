<?php
/**
 *  PortMap Client
 */

require_once __DIR__ . '/../vendor/autoload.php';

use Workerman\Worker;
use Channel\Server;
use Channel\Client as ChannelClient;


$worker = new Worker();
$worker->onWorkerStart = function () {
    // Channel客户端连接到Channel服务端
    ChannelClient::connect('127.0.0.1', 2206);

    // 要订阅的事件名称（名称可以为任意的数字和字符串组合）
    $event_name = 'event_xxx';

    // 订阅某个自定义事件并注册回调，收到事件后会自动触发此回调
    ChannelClient::on($event_name, function ($event_data) {
        var_dump($event_data);
    });
};

$worker->onMessage = function ($connection, $data) {
    // 要发布的事件名称
    $event_name = 'event_xxx';
    // 事件数据（数据格式可以为数字、字符串、数组），会传递给客户端回调函数作为参数
    $event_data = array('some data.', 'some data..');
    // 发布某个自定义事件，订阅这个事件的客户端会收到事件数据，并触发客户端对应的事件回调
    ChannelClient::publish($event_name, $event_data);
};

if (!defined('GLOBAL_START')) {
    Worker::runAll();
}