<?php
namespace Core;

/**
 * Gestion de la configuraion de l'application et
 * de la base de données.
 *
 * Les fichiers de configuration sont :
 * App/Config/config.php
 * App/Config/database.php
 */
class Config {

	/**
	 * Tableau des paramètres
	 * @var array
	 */
	private $settings = array();

	/**
	 * Instance
	 * @var null
	 */
	private static $_instance =  null;

	/**
	 * Retourne l'instance de la classe
	 * @return Config instance de la classe
	 */
	public static function getInstance(){

		if(is_null(self::$_instance)){
			self::$_instance = new Config();
		}
		return self::$_instance;
	}

	/**
	 * Constructeur
	 * Chargement des fichier de config
	 */
	public function __construct(){
		require ROOT.'/'.APP_DIR.'/Config/database.php';
		$this->settings['database'] = $database;

		require ROOT.'/'.APP_DIR.'/Config/config.php';
		$this->settings['config'] = $config;
	}

	/**
	 * Configuration de l'accès à la base de données
	 * @param  sring $key nom du paramètre
	 * @return string     valeur du paramètre
	 */
	public function db($key) {
		if(isset($this->settings['database'][$key])){
			return $this->settings['database'][$key];
		}
		return null;
	}

	/**
	 * Configuration de l'aplication
	 * @param  sring $key nom du paramètre
	 * @return string     valeur du paramètre
	 */
	public function config($key) {
		if(isset($this->settings['config'][$key])){
			return $this->settings['config'][$key];
		}
		return null;
	}
}

