<?php /*a:1:{s:70:"/data/www/workerman.chat.04.com/application/chat/view/index/index.html";i:1541752838;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="keywords" content="WebSocket,WorkerMan服务,PHP,在线聊天,长连接通讯">
    <meta name="author" content="li914">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="static/js/jquery.min.js"></script>
    <link href="static/css/bootstrap.css" rel="stylesheet">
    <script src="static/js/emoji_jQuery.min.js"></script>
    <script src="static/js/bootstrap.js"></script>
    <script src="static/js/web_socket.js"></script>
    <script src="static/js/swfobject.js"></script>
    <script src="static/js/CookieTools.js"></script>
    <script src="static/js/TimeTools.js"></script>
    <title id="title">基于workerman和thinkPHP5.1搭建的聊天室</title>
    <style type="text/css">
        body {

            background-color: lightcyan;
            font-size: 16px;
            line-height: 32px;
            font-family: "Microsoft Yahei", "Helvetica Neue", Helvetica, Arial, sans-serif;
        }

        .content {
            background-color: #c7ddef;
            height: 100vh;
        }

        .content .msg-list {
            min-height: 430px;
            max-height: 63vh;
            overflow-x: hidden;
            overflow-y: scroll;
        }

        .msg-other {
            clear: both;
            margin-top: 7px;
            padding: 3px;
        }

        .msg-other .msg-other-container {
            display: inline;
            padding: 7px;
        }

        .msg-other .msg-other-container .msg-other-content {
            background-color: rgba(224, 244, 244, 1);
            color: #333333;
            text-indent: 2em;
            word-wrap: break-word;
            line-height: 120%;
            box-shadow: 3px 3px 5px 1px rgba(224, 244, 244, 0.6);
            padding: 5px;
        }

        .msg-user {
            margin-top: 7px;
            padding: 3px;
        }

        .msg-user .msg-user-container {
            display: inline;
            padding: 7px;
        }

        .msg-user .msg-user-container .msg-user-content {
            background-color: rgba(201, 226, 179, 1);
            color: #333333;
            text-align: left;
            word-wrap: break-word;
            line-height: 120%;
            box-shadow: 3px 3px 5px 1px rgba(201, 226, 179, 0.6);
            padding: 5px;
            clear: both;
        }

        .msg-user .msg-user-container .msg-user-content p {
            text-align: right;
            text-indent: 2em;
            /*display: inline-block;*/
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-sm-9 col-xs-12 content">
            <div class="row msg-list">
                <!--<div class="msg-other">-->
                    <!--<p style="clear: both;text-align: center;">15:56</p>-->
                    <!--<img src="static/images/li914.jpg" style="display: inline;margin: auto 7px"-->
                         <!--class="img-responsive img-circle" width="41" height="41">-->
                    <!--<div class="msg-other-container">-->
                        <!--<span>li914</span>-->
                        <!--<div class="msg-other-content">-->
                            <!--55556666668889999900005555566688899995656text-indent: 2em;-->
                            <!--word-wrap: break-word;text-indent: 2em;-->
                            <!--word-wrap: break-word;text-indent: 2em;-->
                            <!--word-wrap: break-word;text-indent: 2em;-->
                            <!--word-wrap: break-word;text-indent: 2em;-->
                            <!--word-wrap: break-word;text-indent: 2em;-->
                            <!--word-wrap: break-word;-->
                        <!--</div>-->
                    <!--</div>-->
                <!--</div>-->

                <!--<div class="msg-user">-->
                    <!--<div class="msg-user-container">-->
                        <!--<div class="user-info">-->
                            <!--<span style="float: right;">li914</span>-->
                            <!--<img src="static/images/li914.jpg" style="display: inline;margin: auto 7px;float: right"-->
                                 <!--class="img-responsive img-circle" width="41" height="41">-->
                        <!--</div>-->
                        <!--<div class="msg-user-content">-->
                            <!--<p>-->
                                <!--5555666666888999990000 55556666668889999900005555566688899995656text-indent: 2em;-->
                                <!--word-wrap: break-word;text-indent: 2em;-->
                                <!--word-wrap: break-word;text-indent: 2em;-->
                                <!--word-wrap: break-word;text-indent: 2em;-->
                                <!--word-wrap: break-word;text-indent: 2em;-->
                                <!--word-wrap: break-word;text-indent: 2em;-->
                                <!--word-wrap: break-word;-->
                            <!--</p>-->
                        <!--</div>-->
                    <!--</div>-->
                <!--</div>-->
            </div>
            <div class="row my-input">
                <form role="form" onsubmit="submitMsg();return false;">
                    <div class="form-group">
                        <select class="form-control" style="margin-bottom: 7px;" id="client_list">
                            <option value="all">所有人</option>
                        </select>
                    </div>
                    <div class="form-group clearfix">
                        <!--<button type="button" id="sendMsg" class="btn btn-success pull-right">发送</button>-->
                        <button type="button" id="qqfaceBtn" class="btn btn-default pull-right">表情</button>
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
<script>
    if (typeof console == 'undefined') {
        this.console = {
            log: function (msg) {

            }
        }
    }
    WEB_SOCKET_SWF_LOCATION = 'static/swf/WebSocketMain.swf';
    WEB_SOCKET_DEBUG = true;
    var ws, client_name, client_header, client_id, room_id = '小仙女', client_list_data = {};
    var timer=timeTools.timeStamp();

    /**
     * 连接websocket服务器
     * */
    function connect() {
        try {
            ws = new WebSocket('ws://127.0.0.1:31520');
            ws.onopen = ws_open;
            ws.onmessage = ws_message;
            ws.onclose = function () {
                connect();
            };

            ws.onerror = function (e) {
                console.log(e)
            };
        } catch (e) {
            console.log(e);
        }
    }

    /**
     * 接受来自socket服务器的信息
     * @param msg
     * */
    function ws_message(msg) {
        var data = JSON.parse(msg.data);
        console.log(data);
        switch (data.type) {
            //初始化,绑定,发送房间号
            case 'init':
                client_id = data.client_id;
                var sendMsg = {
                    'type': 'bind',
                    'client_id': client_id,
                    'client_name': client_name,
                    'room_id': room_id,
                    'time': timeTools.timeStamp()
                };
                // console.log(sendMsg);
                sendMessage('chat/service/bindUid', sendMsg);
                return;
            //更新房间里所有在线的用户
            //{"type":"client_list","time":"11:26:01","list":{"7f00000108fc0000000a":{"room_id":"小仙女","client_name":"小白"}}}
            case 'client_list':
                client_list_data = data.list;
                flush_client_list();
                return;
            //加入房间通知:
            //{type: "join", client_name: "小白", time: "11:23:36"}
            case 'join':
                noticeMsg('join', data.client_name, data.time);
                return;
            //离开房间通知
            // {type: "leave", client_name: "小白", time: "11:23:36"}
            case 'leave':
                noticeMsg('leave', data.client_name, data.time);
                return;
            //接收房间或私聊发来的信息
            case 'say':
                NoticeTimer();
                updateMsgList(data.to_client_id, data.to_client_name, data.form_client_name, data.content, data.time, data.form_client_header);
                return;
        }
    }

    /**
     * 添加时间显示
     * */
    function NoticeTimer() {
        if (timer+120>timeTools.timeStamp()){
            timer=timeTools.timeStamp();
            return;
        }
        var tpl="<p style='text-align: center'>"+timeTools.formatTime("H:i:s")+"</p>";
        console.log(tpl);
        $('.msg-list').append(tpl);
    }

    /**
     * 处理加入或离开房间的通知更新
     * @param type 类型
     * @param client_name 用户名
     * @param time 时间(15:35)
     * */
    function noticeMsg(type, client_name, time) {
        var tpl = '';
        if (type == 'join') {
            tpl = '<div class="text-muted text-center notice">\n' +
                '                    欢迎用户 ' + client_name + ' 来到本房间 <span>时间:' + time + '</span>\n' +
                '                </div>';
        } else if (type == 'leave') {
            tpl = '<div class="text-muted text-center notice">\n' +
                '                    用户 ' + client_name + ' 离开本房间 <span>时间:' + time + '</span>\n' +
                '                </div>';
        }
        $('.msg-list').append(tpl);

        $('.msg-list').scrollTop(30000);
    }

    /**
     * 发送信息
     *@param url 接口网址
     * @param data 请求提交的数据
     * @param type 类型
     * */
    function sendMessage(url, data, type) {
        $.post(
            url,
            data,
            function (res, status) {
                // console.log(res, status);
                switch (type) {
                    case 'bind':
                        return;
                }
            },
            'json'
        );
    }

    function ws_open() {
    }

    /**
     * 当没有输入用户名,则输出随机用户名
     * @return string
     * */
    function randomName() {
        var name = ['小猫咪', 'HelloKitty', '迷妹弟弟', '豆浆', '油条', '小仙女', '抠脚大叔', '菠萝蜜', '大虾', '小白', '可爱的大汉', '我是谁!', '你好啊', '罗密欧', '朱丽叶'];
        var i = parseInt(Math.random() * 15);
        var getName = name[i];
        return getName;
    }

    /**
     * 随机分配头像
     * @return string
     * */
    function getHeaderPic() {
        var header = ['header01.jpg', 'header02.jpg', 'header03.jpg', 'header04.jpg', 'header05.jpg', 'header06.jpg', 'header07.jpg', 'header08.jpg',
            'header09.jpg', 'header10.jpg', 'header11.jpg', 'header12.jpg', 'header13.jpg', 'header14.jpg', 'header15.jpg'];
        var i = parseInt(Math.random() * 15);
        return header[i];
    }


    /**
     * 静态模拟框
     * 判断是否输入了用户名
     * */
    function getNameModal() {
        $('#input_name_Modal').modal('show');
        $('#sureName').click(
            function () {
                var input = $('#name_modal');
                var name = $.trim(input.val());
                if (!name) {
                    alert('对不起,请输入用户名后确定!');
                    return;
                }
                client_name = name;
                cookie.setCookie('client_name', client_name);
                input.val('');
                $('#input_name_Modal').modal('hide');
                connect();
                return;
            }
        );
        $('#input_name_Modal').on('hidden.bs.modal', function () {
            if (client_name) return;
            client_name = randomName();
            cookie.setCookie('client_name', client_name);
            connect();
            return;
        });
        // return is;
    }

    /**
     * 判断发送的类型
     * */
    $(function () {
        select_client_id = 'all';
        select_client_text = '所有人';
        $('#client_list').change(function () {
            select_client_id = $('#client_list option:selected').attr('value');
            select_client_text = $('#client_list option:selected').text();
        })
    });

    /**
     * 刷新在线用户
     * */
    function flush_client_list() {
        var user_list = $('#user_list');
        var client_list = $('#client_list');
        user_list.empty();
        client_list.empty();
        user_list.append('<h4>在线用户</h4>');
        client_list.append('<option value="all" id="client_all">所有人</option>');
        for (var p in client_list_data) {
            user_list.append('<li id="' + p + '">' + client_list_data[p].client_name + '</li>');
            client_list.append('<option value="' + p + '">' + client_list_data[p].client_name + '</option>');
        }
        user_list.append('</ul>');
        $('#client_list').find("option[text='" + select_client_text + "']").attr('selected', true);
    }

    /**
     * 发送信息
     * */
    function sendContent() {
        var content = $.trim($('#msg_content').val());
        var to_client_id = $('#client_list option:selected').attr('value');
        var to_client_name = $('#client_list option:selected').text();
        if (!content) {
            return false;
        }
        var url = 'chat/service/sendGroupMsg';
        if (to_client_id != 'all') {
            url = 'chat/service/sendPrivateMsg';
        }
        if (to_client_id == client_id && to_client_name == client_name) {
            return false;
        }
        var data = {
            'type': 'say',
            'to_client_id': to_client_id,
            'to_client_name': to_client_name,
            'form_client_id': client_id,
            'form_client_name': client_name,
            'room_id': room_id,
            'content': content,
            'form_client_header': client_header,
            'time': timeTools.formatTime('H:i:s')
        };
        console.log(data, 'data');

        sendMessage(url, data, 'send');
//发送成功后,进行更新聊天
        content = parseContent(content);
        // var tpl = '<div class="my-msg">\n' +
        //     '                    <div class="my-msg-info">\n' +
        //     '                        <div class="my-info">\n' +
        //     '                            <img src="static/images/chat/header/' + client_header + '"' + 'style="display: inline-block;margin-right: 7px;"\n' +
        //     '                                 class="img-responsive img-circle" width="41" height="41">\n' +
        //     '                            <small>' + client_name + '</small></div>\n' +
        //     '                        <div class="text-center text-muted time">' + timeTools.formatTime('H:i:s') + '</div>\n' +
        //     '                        <div class="my-msg-content">\n' +
        //     '                            <p>' + content + '</p>\n' +
        //     '                        </div>\n' +
        //     '                    </div>\n' +
        //     '                </div>';
        // $('.msg-list').append(tpl);

        if (to_client_id == 'all') {
            var tpl1 = '<div class="msg-user">\n' +
                '                    <div class="msg-user-container">\n' +
                '                        <div class="user-info">\n' +
                '                            <span style="float: right;">' + client_name + '</span>\n' +
                '                            <img src="static/images/chat/header/' + client_header + '"' + ' style="display: inline;margin: auto 7px;float: right"\n' +
                '                                 class="img-responsive img-circle" width="41" height="41">\n' +
                '                        </div>\n' +
                '                        <div class="msg-user-content">\n' +
                '                           <p>\n'
                + content +
                '                           </p>\n' +
                '                        </div>\n' +
                '                    </div>\n' +
                '                </div>';
            $('.msg-list').append(tpl1);
        } else {
            var tpl1 = '<div class="msg-user">\n' +
                '                    <div class="msg-user-container">\n' +
                '                        <div class="user-info">\n' +
                '                            <span style="float: right;">' + client_name + '</span>\n' +
                '                            <img src="static/images/chat/header/' + client_header + '"' + ' style="display: inline;margin: auto 7px;float: right"\n' +
                '                                 class="img-responsive img-circle" width="41" height="41">\n' +
                '                        </div>\n' +
                '                        <div class="msg-user-content">\n' +
                '                           <p>\n' +
                "<small>你对 [@<strong>"+to_client_name+"</strong>]说：</small>"
                +content +
                '                           </p>\n' +
                '                        </div>\n' +
                '                    </div>\n' +
                '                </div>';
            $('.msg-list').append(tpl1);
        }

        $('#msg_content').val('').focus();
        $('.msg-list').scrollTop(30000);
    }

    /**
     * 刷新信息
     * */
    function updateMsgList(to_client_id, to_client_name, form_client_name, content, time, form_client_header) {
        content = parseContent(content);
        var tpl = '';
        if (to_client_id == 'all') {
            // tpl = '<div class="other">\n' +
            //     '                    <div class="other-msg-info">\n' +
            //     '                        <div class="other-info">\n' +
            //     '                            <small>' + form_client_name + '</small>\n' +
            //     '                            <img src="static/images//chat/header/' + form_client_header + '"' + 'style="display: inline-block;margin-left: 7px;"\n' +
            //     '                                 class="img-responsive img-circle" width="41" height="41">\n' +
            //     '                        </div>\n' +
            //     '                        <div class="text-center text-muted time">' + time + '</div>\n' +
            //     '                        <div class="other-msg-content">\n' + content +
            //     '                        </div>\n' +
            //     '                    </div>\n' +
            //     '                </div>';
            // $('.msg-list').append(tpl);


            var tpl1 = '<div class="msg-other">\n' +
                '                    <img src="static/images//chat/header/' + form_client_header + '"' + ' style="display: inline;margin: auto 7px"\n' +
                '                         class="img-responsive img-circle" width="41" height="41">\n' +
                '                    <div class="msg-other-container">\n' +
                '                        <span>' + form_client_name + '</span>\n' +
                '                        <div class="msg-other-content">\n' + content +
                '                        </div>\n' +
                '                    </div>\n' +
                '                </div>';
            $('.msg-list').append(tpl1);

        } else {
            if (to_client_id == client_id && client_name == to_client_name) {
                // tpl = '<div class="other">\n' +
                //     '                    <div class="other-msg-info">\n' +
                //     '                        <div class="other-info">\n' +
                //     '                            <small>' + form_client_name + '</small>\n' +
                //     '                            <img src="static/images//chat/header/' + form_client_header + '"' + 'style="display: inline-block;margin-left: 7px;"\n' +
                //     '                                 class="img-responsive img-circle" width="41" height="41">\n' +
                //     '                        </div>\n' +
                //     '                        <div class="text-center text-muted time"><span style="color: red;">私聊 </span>' + time + '</div>\n' +
                //     '                        <div class="other-msg-content">\n' + content +
                //     '                        </div>\n' +
                //     '                    </div>\n' +
                //     '                </div>';
                // $('.msg-list').append(tpl);
                var tpl1 = '<div class="msg-other">\n' +
                    '                    <img src="static/images//chat/header/' + form_client_header + '"' + ' style="display: inline;margin: auto 7px"\n' +
                    '                         class="img-responsive img-circle" width="41" height="41">\n' +
                    '                    <div class="msg-other-container">\n' +
                    '                        <span>' + form_client_name + '</span>\n' +
                    '                        <div class="msg-other-content">\n' +
                    "<small>[@<strong>" + form_client_name + "</strong>] 对你说：</small>" +
                    content +
                    '                        </div>\n' +
                    '                    </div>\n' +
                    '                </div>';
                $('.msg-list').append(tpl1);
            }
        }
        $('.msg-list').scrollTop(30000);
    }

    function parseContent(content) {
        content = $.emojiParse({
            content: content,
            emojis: [
                {type: 'qq', path: 'static/emojiPic/qq/', code: ':'}, {
                    path: 'static/emojiPic/tieba/',
                    code: ';',
                    type: 'tieba'
                }, {path: 'static/emojiPic/emoji/', code: ',', type: 'emoji'}
            ]
        });
        return content;
    }

    window.onload = function () {
        client_name = cookie.getCookie('client_name');
        client_header = cookie.getCookie('client_header');
        if (!client_header) {
            client_header = getHeaderPic();
            cookie.setCookie('client_header', client_header);
        }
        if (!client_name) {
            getNameModal();
        } else {
            connect();
        }
        $('#sendMsg').click(
            function (e) {
                // var content=$('#msg_content').val();

                sendContent();
                // console.log(e);
            }
        );
        $("#msg_content").keydown(function (event) {
            if (event.keyCode == 13) {
                if ($.trim($('#msg_content').val())) {
                    sendContent();
                }
                $('#msg_content').val('').focus();
            }
        });
    };


    $.Lemoji({
        emojiInput: '#msg_content',
        emojiBtn: "#qqfaceBtn",
        position: 'leftTop',
        emojis: {
            qq: {
                name: 'QQ表情',
                path: 'static/emojiPic/qq',
                code: ':'
            },
            tieba: {
                name: '贴吧表情',
                path: 'static/emojiPic/tieba',
                code: ';'
            },
            emoji: {
                name: 'Emoji表情',
                path: 'static/emojiPic/emoji',
                code: '#'
            }
        }
    });


    /**
     * 当页面关闭时,发送信息,通知该用户离开房间
     * */
    window.onbeforeunload = function () {
        var msg = {
            'type': 'leave',
            'time': timeTools.formatTime('H:i:s'),
            'client_name': client_name,
            'room_id': room_id
        };
        sendMessage('chat/service/leaveGroupMsg', msg, 'leave');
    }
</script>
</body>
</html>