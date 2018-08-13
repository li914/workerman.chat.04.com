<?php
/**
 * Created by IntelliJ IDEA.
 * User: li914
 * Date: 18-8-13
 * Time: 上午9:35
 */

//namespace chatworker;
use \GatewayWorker\Lib\Gateway;

class Events
{

    public static function onConnect($client_id){
        $msg='{"type":"init","client_id":"'.$client_id.'","time":"'.date('Y-m-d H:i:s').'"}';
        echo $msg."\r\n";
        Gateway::sendToCurrentClient($msg);
    }
    public static function onMessage($client_id,$message){

    }

    public static function OnClose($client_id){
        $msg='{"type":onclose","client_id":"'.$client_id.'","time":"'.date('Y-m-d H:i:s').'"}';
        echo $msg."\r\n";
    }
}