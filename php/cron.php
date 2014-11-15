<?php
//让crontab 定时执行的脚本程序  */5 * * * * /usr/bin/php /data/www/app/cron.php
//想获取video中6条数据
date_default_timezone_set("PRC");
require_once('./db.php');
require_once('./file.php');

$sql = "select * from test where status=1 order by id desc limit 0,6";
try{
	$connect = Db::getInstance()->connect();
}catch(Exception $e){
	file_put_contents('./logs/'.date('y-m-d').'.txt', $e->getMessage());
	return;
}

$result = mysql_query($sql, $connect);
$videos = array();
while($video = mysql_fetch_assoc($result)){
	$videos[] = $video;
}

$file = new File();
if($videos){
	$file->cacheData('index_mk_cache1-6', $videos);
} else {
	file_put_contents('./logs/'.date('y-m-d').'.txt', '没有相关数据');
}
return;
