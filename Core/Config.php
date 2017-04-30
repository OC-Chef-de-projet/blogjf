<?php
/**
 * Config
 *
 * PHP Version 5.6
 *
 * @category Core
 * @package  Core
 * @author   Pierre-Sylvain Augereau <ps.augereau@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://blogjs.lignedemire.eu
 */
namespace Core;

/**
 * Gestion de la configuration de l'application et
 * de la base de données.
 * Les fichiers de configuration sont :
 *  - App/Config/config.php
 *  - App/Config/database.php
 *
 * @category Core
 * @package  Core
 * @author   Pierre-Sylvain Augereau <ps.augereau@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://blogjs.lignedemire.eu
 */
class Config
{

    /** @var array Tableau des paramètres */
    private $_settings = array();

    /** @var Config instance */
    private static $_instance =  null;

    /**
     * Retourne l'instance de la classe
     *
     * @return Config instance de la classe
     */
    public static function getInstance()
    {

        if (is_null(self::$_instance)) {
            self::$_instance = new Config();
        }
        return self::$_instance;
    }

    /**
     * Constructeur
     * Chargement des fichier de config
     */
    public function __construct()
    {
        include ROOT.'/'.APP_DIR.'/Config/database.php';
        $this->_settings['database'] = $database;

        include ROOT.'/'.APP_DIR.'/Config/config.php';
        $this->_settings['config'] = $config;
    }

    /**
     * Configuration de l'accès à la base de données
     *
     * @param string $key nom du paramètre
     *
     * @return string valeur du paramètre
     */
    public function db($key)
    {
        if (isset($this->_settings['database'][$key])) {
            return $this->_settings['database'][$key];
        }
        return null;
    }

    /**
     * Configuration de l'aplication
     *
     * @param sring $key nom du paramètre
     *
     * @return string valeur du paramètre
     */
    public function config($key)
    {
        if (isset($this->_settings['config'][$key])) {
            return $this->_settings['config'][$key];
        }
        return null;
    }
}

