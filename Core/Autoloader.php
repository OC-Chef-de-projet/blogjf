<?php
namespace Core;

class Autoloader {
	public static function register(){
		spl_autoload_register(array(__CLASS__,'autoload'));
	}
	public static function autoload($class){	
		$class = preg_replace('#\\\#',DS,$class);		
		require ROOT.'/'.$class.'.php';
	}
}
