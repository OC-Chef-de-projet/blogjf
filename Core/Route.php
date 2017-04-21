<?php
namespace Core;

/**
 * Structure d'une route
 */
class Route {
	private $path;
	private $callable;
	private $matches;
	public function __construct($path,$callable){
		$this->path = trim($path,'/');
		$this->callable = $callable;
	}

	/**
	 * Recherche de la corespondance de
	 * la route
	 * @param  string $url URL
	 * @return bool      True si l'url
	 */
	public function match($url){
		$url = trim($url,'/');

		$path = preg_replace('#:([\w]+)#','([^/]+)',$this->path);
		$regex = '#^'.$path.'$#i';

		// Pas de correspondance
		if(!preg_match($regex,$url,$matches)){
			return false;
		}
		array_shift($matches);
		$this->matches = $matches;
		return true;
	}

	/**
	 * Appel la methode
	 *
	 * @return [type] [description]
	 */
	public function call(){

		$controller = '';
		if(isset($this->callable['controller']) && !empty($this->callable['controller'])){
			$controller = $this->callable['controller'];
		}

		$action = 'index';
		if(isset($this->callable['action']) && !empty($this->callable['action'])){
			$action = $this->callable['action'];
		}
		$controller = $controller.'Controller';
		$controller = ucwords($controller);
		$controller = '\\App\\Controller\\'.$controller;

		$app = new $controller();
		return call_user_func_array([$app,$action],$this->matches);
	}
}

