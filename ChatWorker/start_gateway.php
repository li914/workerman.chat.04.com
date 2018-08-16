<?php
/**
 * Created by IntelliJ IDEA.
 * User: li914
 * Date: 18-8-13
 * Time: 上午9:36
 */

use \Workerman\Worker;
use \GatewayWorker\Gateway;
use \Workerman\Autoloader;

require_once __DIR__.'/../vendor/autoload.php';


$gateway=new Gateway('Websocket://0.0.0.0:31520');

$gateway->name='chatworker-Gateway';

$gateway->count=1;

$gateway->lanIp='127.0.0.1';

$gateway->startPort=2300;

$gateway->registerAddress='127.0.0.1:1236';


if (!defined('GLOBAL_START')){
    Worker::runAll();
}