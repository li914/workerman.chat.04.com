<?php /*a:1:{s:70:"/data/www/workerman.chat.04.com/application/chat/view/index/index.html";i:1542028600;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="keywords" content="WebSocket,WorkerMan服务,PHP,在线聊天,长连接通讯">
    <meta name="author" content="li914">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="static/js/jquery.min.js"></script>
    <link href="static/css/bootstrap.min.css" rel="stylesheet">
    <script src="static/js/emoji_jQuery.min.js"></script>
    <script src="static/js/bootstrap.min.js"></script>
    <script src="static/js/web_socket.js"></script>
    <script src="static/js/swfobject.js"></script>
    <script src="static/js/CookieTools.js"></script>
    <script src="static/js/TimeTools.js"></script>
    <title id="title">基于workerman和thinkPHP5.1搭建的聊天室</title>
    <link href="static/css/chat-websocket-workerman.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-sm-9 col-xs-12 content">
            <div class="row msg-list">
            </div>
            <div class="row my-input">
                <form role="form" onsubmit="submitMsg();return false;">
                    <div class="form-group">
                        <select class="form-control" style="margin-bottom: 7px;" id="client_list">
                            <option value="all">所有人</option>
                        </select>
                    </div>
                    <div id="btn" class="form-group clearfix">
                        <!--<button type="button" id="sendMsg" class="btn btn-success pull-right">发送</button>-->
                        <button type="button" id="qqfaceBtn" class="btn btn-default pull-right"><img
                                src="static/images/chat/fabiaoqing.png" width="31" height="31" alt="发表情"></button>
                        <button type="button" id="fatupian" class="btn btn-default pull-right"><img
                                src="static/images/chat/tupian.png" width="31" height="31" alt="发图片"></button>
                    </div>
                    <div class="form-group clearfix" style="height: 85px;">
                        <!--<div contenteditable="true" style="border-radius:7px;width: 100%;height: 23px;max-height:33px;border: 1px solid rgba(133,133,133,0.3);background-color: #fff;display: block;clear: both;"></div>-->
                        <textarea placeholder="回车可快速发送信息" class="form-control" id="msg_content" name="content"
                                  style="height: 83px;"></textarea>
                    </div>
                </form>
                <div class="form-group clearfix">
                    <button type="button" id="sendMsg" class="btn btn-success pull-right">发送</button>
                </div>
            </div>
        </div>
        <div class="col-sm-3 col-xs-12 clearfix">
            <div class="row">
                <div class="col-xs-12 text-left text-muted">
                    <div class="caption" id="user_list"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- 模态框（Modal） -->
<div class="modal fade" id="input_name_Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">请输入用户名,否则系统将自动为你创建!</h4>
            </div>
            <div class="modal-body">
                <input id="name_modal" class="form-control" type="text">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button type="button" id="sureName" class="btn btn-success">确定</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<!--<script src="static/js/plupload/plupload.full.min.js"></script>-->
<script src="static/js/plupload/plupload.full.min.js"></script>
<script src="static/js/chat-websocket-workerman.js"></script>
</body>
</html>