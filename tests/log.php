<?php
/**
 * User: nano
 * Datetime: 2021/8/21 13:33
 */

require_once __DIR__.'/../vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$log_path = __DIR__.'/../runtime/logs';

// create a log channel
$log = new Logger('app');
$log->pushHandler(new StreamHandler($log_path.'/app-info.log', Logger::DEBUG));
$log->pushHandler(new StreamHandler($log_path.'/app.log', Logger::ERROR));


// add records to the log
$log->warning('foo-warning');
$log->error('Bar-error', ['a'=>1, 'b'=>2]);
$log->log('info', 'Hello info');
$log->log('notice', 'Hello notice');
