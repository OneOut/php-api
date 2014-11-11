<?php
require_once('./comon.php');
class Init extends Common {
	public function index(){
		$this->check();
		//获取版本升级信息
		$versionUpgrade = $this->getversionUpgrade($this->app['id']);
		if($versionUpgrade) {
			return Response::show(200, '版本升级信息获取成功', $versionUpgrade);
		}
	}
}

$init = new Init();
$init->index();