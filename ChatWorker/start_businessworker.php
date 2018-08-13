<?php
/**
 * Created by IntelliJ IDEA.
 * User: li914
 * Date: 18-8-13
 * Time: 上午9:36
 */

use \Workerman\Worker;
use \GatewayWorker\BusinessWorker;
use \Workerman\Autoloader;

require_once __DIR__.'/../vendor/autoload.php';

//bussinessWorker实例 进程
$worker=new BusinessWorker();

//名称
$worker->name='chatworker-BusinessWorker';

//进程数量
$worker->count=1;

//服务器注册地址
$worker->registerAddress='127.0.0.1:1236';

if (!defined('GLOBAL_START')){
    Worker::runAll();
}