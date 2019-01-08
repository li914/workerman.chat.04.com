#### 基于thinkphp5.1和workerman框架,HTML5的websocket即时通讯

##### 在线体验
[传送门](https://api.li914.com/chat)

![演示图片](https://gitee.com/li914/workerman-websocket/raw/master/public/static/images/demo/01.png)

##### 写在前面：deepin系统，php7.2,thinkphp5.1

1.下载该项目

```
git clone git@github.com:li914/workerman.chat.04.com.git
```

2.进行项目目录

```
cd workerman.chat.04.com
```

3.添加依赖******

```
composer install
```
4.启动workerman服务
####### linux系统启动方式：
```aidl
cd ChatWorker
php start.php start
```
####### Windows系统启动方式：
打开项目文件夹，进入ChatWorker目录，然后双击start_for_win.bat文件（本人在虚拟机，系统windows7专业版，可以正常启动workerman服务）

5.然后在浏览器 输入:URL/chat

注意:URL是你thinkphp绑定的的网址

6.最后

该项目里的名字以及图片,均来自网络,如有侵权,请联系我来删除:1837725661@qq.com
