PHP 开发APP接口

Learning Session 1
**学习要点**
1. APP接口简介
2. 封装通信接口方法
3. 核心技术
4. APP接口实例

> `服务器端 --> 数据库|缓存 --> 调用接口 --> 客户端`

Learning Session 2
一、APP接口简介
- APP接口介绍
- APP如何进行通信
- 通信格式区别
- APP接口做的哪些事儿

|PHP面向对象|APP|
|接口|接口|
|抽象类|
|Interface|

```
<?php
//PHP面向对象中的接口
/**
  * 定义一个接口
  * 定义一个标准
  */
interface video {
        public function getVideos();
        public function getCount();
}
class movie implements video {
        public function getVideos() {
                echo 1;
        }

        public function getCount() {
                echo 2;
        }
}

movie::getVideos();
```

App的接口
App接口介绍
    ||
通信接口
APP开发需要两类人员
        - 客户端开发工程师
                - 界面布局
                - 获得数据填充


请求APP地址(调用地址)
        |
返回接口数据
        |
解析数据
        |
客户端

接口数据
> <?xml version="1.0" encoding="UTF-8"?>
        <item>
                <title> singwa<title>
                <test id="1"/>
                <description> tracymcgrody is for three<description>
                <image> http://image.com/thumb/20130882345.jpg<image>
        </item>

```

> 接口示例
1. 接口地址：(http://app.com/api.php?format=xml)
2. 接口文件：(api.php处理一些业务逻辑)
<?php
//获取首页数据
```
3. 接口数据
