<?php
/**
 *  PortMap Server
 */

require_once __DIR__ . '/../vendor/autoload.php';

use Workerman\Worker;
use Channel\Server as ChannelServer;

// #### create socket and listen 1234 port ####
// $tcpWorker = new Worker('tcp://0.0.0.0:1234');
//
//// 4 processes
//$tcpWorker->count = 4;
//
//// Emitted when new connection come
//$tcpWorker->onConnect = function ($connection) {
//    echo "New Connection\n";
//};
//
//// Emitted when data received
//$tcpWorker->onMessage = function ($connection, $data) {
//    // Send data to client
//    $connection->send("Hello $data \n");
//};
//
//// Emitted when connection is closed
//$tcpWorker->onClose = function ($connection) {
//    echo "Connection closed\n";
//};

Worker::$pidFile = __DIR__.'/../runtime/test-channel-server.pid';
Worker::$logFile = __DIR__.'/../runtime/test-channel-server.log';

//Tcp 通讯方式
$channelServer = new ChannelServer("0.0.0.0", 2206);

if(!defined('GLOBAL_START'))
{
    Worker::runAll();
}



