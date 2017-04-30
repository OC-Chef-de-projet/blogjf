<?php
namespace Core;
use Pimple\Container;

/**
 * Gestion des services métier
 */
class Service
{
	/**
	 * Instance
	 * @var Session
	 */
	private static $instance;

	/**
	 * Retourne l'instance de la classe
	 * @return Session
	 */
	public static function getInstance(){
		if(!self::$instance){
			self::$instance = new Container();
		}
		return self::$instance;
	}

	/**
	 * Constructeur
	 */
	public function __construct(){
        $this->instance = new Container();
    }
}

