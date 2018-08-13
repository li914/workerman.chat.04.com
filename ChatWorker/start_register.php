<?php
/**
 * Created by IntelliJ IDEA.
 * User: li914
 * Date: 18-8-13
 * Time: 上午9:36
 */
use \Workerman\Worker;
use \GatewayWorker\Register;

require_once __DIR__.'/../vendor/autoload.php';

$register=new Register('text://0.0.0.0:1236');

if (!defined('GLOBAL_START')){
    Worker::runAll();
}