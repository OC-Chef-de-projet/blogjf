<?php
/**
 * Session
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
 * Gestion des sessions
 *
 * @category Core
 * @package  Core
 * @author   Pierre-Sylvain Augereau <ps.augereau@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://blogjs.lignedemire.eu
 */
class Session
{
    /** @var class instance */
    private static $instance;

    /**
     * Constructeur
     */
    public function __construct()
    {
        session_start();
    }

    /**
     * Retourne l'instance de la classe
     *
     * @return Session
     */
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new Session();
        }
        return self::$instance;
    }


    /**
     * Ecrit dans la variable de session
     *
     * @param string $key   Clé
     * @param mixed  $value Valeur
     *
     * @return void
     */
    public function write($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Lecture d'une variable de session
     *
     * @param string $key Clé
     *
     * @return mixed Valeur
     */
    public function read($key)
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }


    /**
     * Effacement d'une variable de session
     *
     * @param string $key Clé
     *
     * @return void
     */
    public function delete($key)
    {
        unset($_SESSION[$key]);
    }
}
