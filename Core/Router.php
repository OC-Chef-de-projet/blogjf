<?php

namespace Core;

class Router {
	private $url;
	private $routes = array();

	public function __construct($url){
		$this->url = $url;
	}


	/**
	 * Ajoute au tableau des routes pour les types GET
	 * @param  [type] $path     [description]
	 * @param  [type] $callable [description]
	 * @return [type]           [description]
	 */
	public function get($path,$callable){
		$this->routes['GET'][] = new Route($path,$callable);
	}

	/**
	 * Ajoute au tableau des routes pour les types POST
	 * @param  [type] $path     [description]
	 * @param  [type] $callable [description]
	 * @return [type]           [description]
	 */
	public function post($path,$callable){
		// Ajoute au tableau des routes
		$this->routes['POST'][] = new Route($path,$callable);
	}

	public function run(){
		// Vérifie que la méthode (GET/POST) existe bien
		// dans le tableau des routes
		$method = $_SERVER['REQUEST_METHOD'];
		if(!isset($this->routes[$method ])){
			throw new \Exception("Méthode $method inconnue ".$this->url,9000);
		}

		foreach($this->routes[$method] as $route){

			if($route->match($this->url)){
				return $route->call();
			}
		}
		throw new \Exception("Routage inconnu ".$this->url,404);
	}

}

