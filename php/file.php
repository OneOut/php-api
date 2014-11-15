<?php

class File{
	private $_dir;

	const EXT = ".txt";
	public function __construct() {
		$this->_dir = dirname(__FILE__).'/files/';
	}

	public function cacheData($key, $value='', $cacheTime=0, $path='') {
		$filename = $this->_dir.$path.$key.self::EXT;

		if($value!==''){//将value值写入缓存
			if(is_null($value)){//清除缓存
				return @unlink($filename);
			}

			$dir = dirname($filename);
			if(!is_dir($dir)) {
				mkdir($dir, 0777);
			}

			$cacheTime = sprintf('%011d', $cacheTime);
			return file_put_contents($filename, $cacheTime.json_encode($value));
		}
		
		if(!is_file($filename)) {
			return FALSE;
		} 
		$contents = file_get_contents($filename);
		$cacheTime = substr($contents, 0, 11);
		$value = substr($contents, 11);
		if($cacheTime+filemtime($filename)<time()) {
			unlink($filename);
			return FALSE;
		}
		return json_decode($value, true);
	}
}

/**
Example: 


$file = new File();
if($file->cacheData('index_mk_cache', null)) {
	echo 'success';
} else {
	echo 'error';
}
*/
