<?php
/**
处理接口公共业务
*/
require_once('./response.php');
require_once('./db.php');
class Common {
	public $params;
	public $app;
	public function check(){
		$this->params['app_id'] = $appId = isset($_POST['app_id']) ? $_POST['app_id'] : '';
		$this->params['version_id'] = $versionId = isset($_POST['version_id']) ? $_POST['version_id'] : '';
		$this->params['version_mini'] = $versionMini = isset($_POST['version_mini']) ? $_POST['version_mini'] : '';
		$this->params['did'] = $did = isset($_POST['did']) ? $_POST['did'] : '';
		$this->params['encrypt_did'] = $encryptDid = isset($_POST['encrypt_did']) ? $_POST['encrypt_did'] : '';

		if(!is_numeric($appId) || !is_numeric($versionId)) {
			return Response::show(401, '参数不合法');
		}

		//判断app是否需要加密
		$this->app = $this->getApp($appId);
		if(!$this->app){
			return Response::show(402, 'app_id不存在');
		}

		if ($this->app['is_encryption'] && $encryptDid!=md5($did.$this->app['key'])) {
			return Response::show(403, "没有该权限");
		}
	}

	public function getApp($id) {
		$sql = "SELECT *
				FROM `app`
				WHERE id=".$id."
				AND status =1
				LIMIT 1";
		$connect = Db::getInstance()->connect();
		$result = mysql_query($sql, $connect);
		return mysql_fetch_assoc($result);
	}

	public function getversionUpgrade($appId) {
		$sql = "SELECT *
				FROM `version_upgrade`
				WHERE app_id=".$appId."
				AND status =1
				LIMIT 1";
		$connect = Db::getInstance()->connect();
		$result = mysql_query($sql, $connect);
		return mysql_fetch_assoc($result);		
	}


}
