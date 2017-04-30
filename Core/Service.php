<?php
/**
 * Service
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
use Pimple\Container;

/**
 * Gestion des services métier
 *
 * @category Core
 * @package  Core
 * @author   Pierre-Sylvain Augereau <ps.augereau@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://blogjs.lignedemire.eu
 */
class Service
{
    /** @var class instance */
    private static $_instance;

    /**
     * Constructeur
     */
    public function __construct()
    {
        $this->_instance = new Container();
    }

    /**
     * Retourne l'instance de la classe
     *
     * @return Session
     */
    public static function getInstance()
    {
        if (!self::$_instance) {
            self::$_instance = new Container();
        }
        return self::$_instance;
    }

}

