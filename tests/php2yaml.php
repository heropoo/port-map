<?php
/**
 * User: heropoo
 * Datetime: 2021/8/14 5:28 下午
 */

require_once __DIR__.'/../vendor/autoload.php';

$config = require __DIR__.'/../conf/portmap.php';
$yaml = \Symfony\Component\Yaml\Yaml::dump($config);

file_put_contents(__DIR__.'/../conf/portmap.yaml', $yaml);