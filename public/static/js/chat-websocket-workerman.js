if (typeof console == 'undefined') {
    this.console = {
        log: function (msg) {

        }
    }
}
WEB_SOCKET_SWF_LOCATION = 'static/swf/WebSocketMain.swf';
WEB_SOCKET_DEBUG = true;
var ws, client_name, client_header, client_id, room_id = '小仙女', client_list_data = {};
var timer = timeTools.timeStamp();

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
            updateMsgList(data.to_client_id, data.to_client_name, data.form_client_name, data.content, data.time, data.form_client_header,data.msg_type);
            return;
    }
}

/**
 * 添加时间显示
 * */
function NoticeTimer() {
    if (timer + 120 > timeTools.timeStamp()) {
        timer = timeTools.timeStamp();
        return;
    }
    var tpl = "<p style='text-align: center'>" + timeTools.formatTime("H:i:s") + "</p>";
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
        'time': timeTools.formatTime('H:i:s'),
        msg_type:'txt'
    };
    console.log(data, 'data');

    sendMessage(url, data, 'send');
//发送成功后,进行更新聊天
    content = parseContent(content);
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
            "<small>你对 [@<strong>" + to_client_name + "</strong>]说：</small>"
            + content +
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
function updateMsgList(to_client_id, to_client_name, form_client_name, content, time, form_client_header,msg_type) {
    content = parseContent(content);
    var tpl = '';
    if (to_client_id == 'all') {
        if (msg_type==='txt'){
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
        } else if (msg_type==='pic'){
            var src='https://liang914.oss-cn-hangzhou.aliyuncs.com/chat/tmp/'+content;
            var tpl1 = '<div class="msg-other">\n' +
                '                    <img src="static/images//chat/header/' + form_client_header + '"' + ' style="display: inline;margin: auto 7px"\n' +
                '                         class="img-responsive img-circle" width="41" height="41">\n' +
                '                    <div class="msg-other-container">\n' +
                '                        <span>' + form_client_name + '</span>\n' +
                '                        <div class="msg-other-content">\n'  +'<img class="chat-pic" src="'+src+'">'+
                '                        </div>\n' +
                '                    </div>\n' +
                '                </div>';
            $('.msg-list').append(tpl1);
        }

    } else {
        if (to_client_id == client_id && client_name == to_client_name) {
            if (msg_type==='txt'){
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
            } else if (msg_type==='pic'){
                var src='https://liang914.oss-cn-hangzhou.aliyuncs.com/chat/tmp/'+content;
                var tpl1 = '<div class="msg-other">\n' +
                    '                    <img src="static/images//chat/header/' + form_client_header + '"' + ' style="display: inline;margin: auto 7px"\n' +
                    '                         class="img-responsive img-circle" width="41" height="41">\n' +
                    '                    <div class="msg-other-container">\n' +
                    '                        <span>' + form_client_name + '</span>\n' +
                    '                        <div class="msg-other-content">\n' +
                    "<small>[@<strong>" + form_client_name + "</strong>] 对你说：</small>" + '<img class="chat-pic" src="'+src+'">'+
                    '                        </div>\n' +
                    '                    </div>\n' +
                    '                </div>';
                $('.msg-list').append(tpl1);
            }
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
 * 处理发表图片信息
 * */
var plupload = new plupload.Uploader({
    runtimes: 'html5,flash,silverlight,html4',
    browse_button: 'fatupian',
    container: document.getElementById('btn'),
    flash_swf_url: 'static/js/plupload/Moxie.swf',
    silverlight_xap_url: 'static/js/plupload/Moxie.xap',
    url: 'http://oss.aliyuncs.com',
    multi_selection: false,
    filters: {
        max_file_size: '2048kb',
        mime_types: [
            {
                title: "Image files", extensions: 'jpg,gif,png'
            }
        ]
    },
    init: {
        PostInit: function () {

        },
        UploadProgress: function (up, file) {
            // console.log(up,file,"UploadProgress");
        },
    }
});
plupload.init();

plupload.bind('FilesAdded', autoUpload);
plupload.bind("FileUploaded", fileUploaded);
plupload.bind("Error", fileUploadError);
var new_multipart_patams;
//截取图片后缀名
function get_suffix(filename) {
    pos = filename.lastIndexOf('.')
    suffix = ''
    if (pos != -1) {
        suffix = filename.substring(pos)
    }
    return suffix;
}
//生成图片的随机名
function randFileName(len) {
    len = len || 32;
    var chars = 'ABCDEFGHJKMNPQRSTWXYZabcdefhijkmnprstwxyz2345678';
    var maxPos = chars.length;
    var pwd = '';
    for (i = 0; i < len; i++) {
        pwd += chars.charAt(Math.floor(Math.random() * maxPos));
    }
    return pwd;
}

var filePicName='';
function autoUpload(uploader, files) {
    // console.log(uploader,files,'autoUpload');
    var data = JSON.parse(sendRequest());
    // console.log(data);
    // console.log(files[0].name);
    filePicName=randFileName()+get_suffix(files[0].name);
    new_multipart_patams = {
        'key': data.data.dir +filePicName,
        'policy': data.data.policy,
        'OSSAccessKeyId': data.data.accessid,
        'success_action_status': '200',
        'signature': data.data.signature
    };
    uploader.setOption({
        'url': data.data.host,
        'multipart_params': new_multipart_patams
    });
    uploader.start();
}
//上传图片完成后触发的事件
function fileUploaded(uploader, file, response) {
    // console.log(uploader, file, response, 'fileUploaded');
    console.log(filePicName);
    if (response.status===200){
        var file_name=file.name;
        var to_client_id = $('#client_list option:selected').attr('value');
        var to_client_name = $('#client_list option:selected').text();
        var msg={
            type:'say',
            to_client_id:to_client_id,
            to_client_name:to_client_name,
            form_client_header:client_header,
            form_client_name:client_name,
            form_client_id:client_id,
            room_id:room_id,
            content:filePicName,
            msg_type:'pic',
            time:timeTools.formatTime('H:i:s')
        };
        // console.log(msg);
        var url = 'chat/service/sendGroupMsg';
        if (to_client_id != 'all') {
            url = 'chat/service/sendPrivateMsg';
        }
        if (to_client_id == client_id && to_client_name == client_name) {
            return false;
        }
        sendMessage(url, msg, 'send');
        var src='https://liang914.oss-cn-hangzhou.aliyuncs.com/chat/tmp/'+filePicName;
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
                +'<img class="chat-pic" src="'+src+'">'+
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
                "<small>你对 [@<strong>" + to_client_name + "</strong>]说：</small>"
                +'<img class="chat-pic" src="'+src+'">'+
                '                           </p>\n' +
                '                        </div>\n' +
                '                    </div>\n' +
                '                </div>';
            $('.msg-list').append(tpl1);
        }
        $('.msg-list').scrollTop(30000);

    }
}
//上传图片错误时触发的事件
function fileUploadError(uploader, err) {
    console.log(uploader, err, 'fileUploadError');
    switch (err.code) {
        case -600:
            alert("选择文件太大，最大支持1024kb的文件！请重新选择");
            break;
        case -601:
            alert("对不起，选择的文件不是图片！请重新选择。");
            break;
    }
}
//用于请求阿里云OSS秘钥
function sendRequest() {
    var xmlhttp = null;
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    }
    else if (window.ActiveXObject) {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    if (xmlhttp != null) {
        serverUrl = 'chat/service/encryOss';
        xmlhttp.open("GET", serverUrl, false);
        xmlhttp.send(null);
        return xmlhttp.responseText
    }
    else {
        alert("Your browser does not support XMLHTTP.");
    }
}


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