<?php
namespace Core;

class Config {
	private $settings = array();

	private static $_instance =  null;

	public static function getInstance(){

		if(is_null(self::$_instance)){
			self::$_instance = new Config();
		}
		return self::$_instance;
	}

	public function __construct(){
		require ROOT.'/'.APP_DIR.'/Config/database.php';
		$this->settings['database'] = $database;

		require ROOT.'/'.APP_DIR.'/Config/config.php';
		$this->settings['config'] = $config;

	}

	public function db($key) {
		if(isset($this->settings['database'][$key])){
			return $this->settings['database'][$key];
		}
		return null;
	}

	public function config($key) {
		if(isset($this->settings['config'][$key])){
			return $this->settings['config'][$key];
		}
		return null;
	}

	/*
	public function get($key){
		if(!isset())
		return $this->settings[$key];
	}
	*/
}

