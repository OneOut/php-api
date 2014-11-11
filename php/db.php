<?php
/**
数据库单例类
*/
class Db {
	/** 存储数据库单例 */
	static private $_instance;
	static private $_connectSource;
	private $_dbConfig = array(
		'host' => '127.0.0.1',
		'user' => 'root',
		'password' => '',
		'database' => 'video'
	);
	private function __construct() {
		
	}

	static public function getInstance() {
		if(!(self::$_instance instanceof self)) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function connect() {
		self::$_connectSource = mysql_connect($this->_dbConfig['host'], $this->_dbConfig['user'], $this->_dbConfig['password']);
		if(!self::$_connectSource) {
			throw new Exception('mysql connect error', mysql_error());
			// die('mysql connect error', mysql_error());
		}

		mysql_select_db($this->_dbConfig['database'], self::$_connectSource);
		mysql_query("SET NAMES UTF8", self::$_connectSource);
		return self::$_connectSource;
	}
}

/**
Example:

$connect = Db::getInstance()->connect();

$sql = "SELECT * from video";
$result = mysql_query($sql);
echo mysql_num_rows($result);
var_dump($result);
*/