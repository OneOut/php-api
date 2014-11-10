PHP 开发APP接口

#Capeter 1

APP接口介绍
APP接口和PHP面向对象中的接口是不一样的，希望大家不要混淆。APP接口是供客户端通信用的，客户端APP可以通过接口获取数据和提交数据等操作。 APP接口包括以下内容： 1、接口地址 如 http://app.com/init.php?did=sd54656&client_id=1、这个地址可以理解为客户端APP抛送的http请求地址。 2、接口文件(init.php)-处理业务逻辑的 3、返回接口数据(xml、josn等数据格式)

##Learning Session 1
**学习要点**
1. APP接口简介
2. 封装通信接口方法
3. 核心技术
4. APP接口实例

> `服务器端 --> 数据库|缓存 --> 调用接口 --> 客户端`

##Learning Session 2
一、APP接口简介
- APP接口介绍
- APP如何进行通信
- 通信格式区别
- APP接口做的哪些事儿

|PHP面向对象|  APP|    |
|:----------|----:|:--:|
|接口|接口  |     |    |
|抽象类     |	  |    |
|Interface  |	  |    |

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
?>
```

> App的接口
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

`接口数据`
```
 <?xml version="1.0" encoding="UTF-8"?>
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
```
<?php
//获取首页数据
?>
```
3. 接口数据


##Learning Session 3
> APP如何进行通信

`
			发送http请求
客户端(APP)-C	--------------------------------------	服务器-S
			http://api.com/index.php
`

`类似BS架构的通信模式`


##Learning Session 4
			
`
			发送http请求
客户端(APP)-C	---------------------------------->	服务器-S
		<----------------------------------
			返回数据(xml, json)
`
**重点：**
(xml,json)和它们的区别

XML定义
扩展标记语言(Extensible Markup Language, XML), 可以用来标记数据、定义数据类型，是一种允许用户对自己的标记语言进行定义的源语言。XML格式统一，跨平台和语言，非常适合数据传输和通信，早已成为业界公认的标准。

	区别：
	- XML  --> 节点可以自定义
	- HTML --> 标签不可以自定义
	平台：Linux / Windows
	语言：Python | PHP | Java | OC

**XML数据**
```
<?xml version="1.0" encoding="UTF-8"?>
<item>
	<title>dcj<title>
	<test id="1" />
	<description>dcj1</description>
	<address>beijing</address>
</item>
```

JSON定义
JSON(JavaScript Object Notation)一种轻量级的数据交换格式，具有良好的可读和便于快速编写的特性。可在不同平台之间进行数据交换。JSON采用兼容性很高的、完全独立于语言文本格式。这些特性使JSON成为理解的数据交换语言。

`根节点只能有一个` `标签必须要有结束标签`
```
{"title":"sina","from":"beijing","description":"sin","address":"beijing"}
```

**`通信数据格式xml/json区别`**
1. 可读性方面	-->  xml胜出
2. 生成数据方面 -->  json胜出
3. 传输速度方面 -->  json胜出

```
<?php
/**
michael du
*/

$arr = array(
	'title' => 'michael',
	'from' => 'it',
	'description' => 'michaeldu',
	'address' => 'beijing',
);

function json($arr) {
	echo json_encode($arr);
	exit;
}

function xml($arr) {
	header("Content-type: text/xml");
	$result = "<?xml version='1.0' encoding='UTF-8'?>";
	$result.= "<item>";
	$result.= "<title>michaeldu</title>\n<test id='1'/>";
	$result.= "<description>michaeldu</description>\n";
	$result.= "<address>beijign</address>\n";
	$result.= "</item>\n";
	echo $result;exit;

	/*
		$dom = new DomDocument('1.0', 'utf-8');
		//创建根节点
		$article = $dom->createElement('item');
		$dom->appendchild();
	*/
	/* XMLWriter */
	/* SimpleXML */
}

if($_GET['format'] == 'json') {
	json($arr);
} else if($_GET['format'] == 'xml') {
	xml($arr);
}
?>
```

##Learning Session 5

**APP接口做的那些事儿

|获取数据|  从数据库中或缓存中获取数据，然后通过接口数据返回给客户端|
|-------:| --------------------------------------------------------:|
|提交数据|通过接口提交数据给服务器，然后服务器入库处理，或者其他处理|


#Capeter 2
二、封装通信接口数据方法
2.1 JSON方式封装接口数据方法
2.2 XML方式封装接口数据方法
2.3 综合通信方式封装

2.1.1 PHP生成JSON数据
	> 方法：`json_encode`($value);
`*注：该函数只能接受UTF-8编码的数据，如果传递其他格式的数据该函数会返回null*`
```
<?php
$arr = array(
	'id' => 1,
	'name' => 'michaeldu'
);
$data = "输出json数据";
$newData = iconv('UTF-8', 'GBK', $data); //将UTF-8的格式转化为GBK的格式
echo json_encode($arr);
echo json_encode($newData);//测试GBK会返回null
?>
```

2.1.2 通信数据标准格式
code		状态码(200, 400等)
message		提示信息(邮箱格式不正确；数据返回成功等)
data		返回信息
JSON
	code: 200
	message:"数据返回成功"
	data
		id:1
		name:"michaeldu"

```
<?php
class Response {
	/**
	 *  按JSON方式输出通信数据
	 * @param integer $code 状态码
	 * @param string  $message 提示信息
	 * @param integer $data 数据
	 * return string
	 **/
	public static function json($code, $message = '', $data = array()) {
		
		if(!is_numeric($code)) {
			return '';
		}

		$result = array(
			'code' => $code, 
			'message' => $message,
			'data' => $data
		);
		echo json_encode($result);
		exit;
	}
}
?>

--new file test.php
<?php
require_once('./response.php');
$arr = array(
	'id' => 1,
	'name' => 'michaeldu'
);
Response::json(200, '数据返回成功', $arr);
?>
```
