<?php
/**
 * Created by IntelliJ IDEA.
 * User: li914
 * Date: 18-8-13
 * Time: 上午9:35
 */

use \GatewayWorker\Lib\Gateway;

class Events
{
    /**
     * 每当有客户端连接时,向该客户端发送$client_id,让客户端进行初始化.
    */
    public static function onConnect($client_id){
        $msg='{"type":"init","client_id":"'.$client_id.'","time":"'.date('Y-m-d H:i:s').'"}';
        echo $msg."\r\n";
        Gateway::sendToCurrentClient($msg);
    }
    /**
     * 该方法不用添加任何业务处理,所有的业务处理都交给thinkphp5.1的控制器Service里处理!
    */
    public static function onMessage($client_id,$message){
    }
    /**
     * 当客户端断开连接时触发
    */
    public static function OnClose($client_id){
        $msg='{"type":"onclose","client_id":"'.$client_id.'","time":"'.date('Y-m-d H:i:s').'"}';
        echo $msg."\r\n";
    }
}