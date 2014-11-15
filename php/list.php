<?php
	//http://app.com/list.php?page=1&pagesize=12

/**
直接从缓存读数据
step 1: linux计划任务定时生成缓存数据
step 2: 接口直接读取缓存内容
*/
require_once('./response.php');
require_once('./file.php');

$file = new File();
$data = $file->cacheData('index_cron_cache');
if ($data) {
	return Response::show(200, '首页数据获取成功', $data);
} else {
	return Response::show(400, '首页数据获取失败', $data);
}
exit;

/**
传统的形式获取内容
*/
require_once('./response.php');
require_once('./file.php');
require_once('./db.php');

$page = isset($_GET['page']) ? $_GET['page'] : 1;
$pageSize = isset($_GET['pagesize']) ? $_GET['pagesize'] : 6;
if(!is_numeric($page) || !is_numeric($pageSize)){
	return Response::show(401, "数据不合法");
}

$offset = ($page-1)*$pageSize;
$cache = new File();
if( !$videos = $cache->cacheData('index_mk_cache'.$page.'-'.$pageSize) ) {

	$sql = "SELECT * FROM test where status=1 ORDER BY id DESC LIMIT ".$offset.",".$pageSize;

	try{
		$connect = Db::getInstance()->connect();
	}catch(Exception $e){
		// $e->getMessage();
		return Response::show(403, "数据库连接失败");
	}
	$result = mysql_query($sql, $connect);
	$videos = array();
	while($video = mysql_fetch_assoc($result)) {
		$videos[] = $video;
	}

	if($videos) {
		$cache->cacheData('index_mk_cache'.$page.'-'.$pageSize, $videos, 1200);
	}
}

if($videos) {
	return Response::show(200, '首页数据获取成功', $videos);
} else {
	return Response::show(400, '首页数据获取失败', $videos);
}


