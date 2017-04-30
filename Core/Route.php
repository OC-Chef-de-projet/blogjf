<?php
/**
 * Route
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
 * Gestion des routes
 *
 * @category Core
 * @package  Core
 * @author   Pierre-Sylvain Augereau <ps.augereau@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://blogjs.lignedemire.eu
 */
class Route
{
    private $_path;
    private $_callable;
    private $_matches;

    /**
     * __construct
     *
     * @param string   $path     Chemin
     * @param Callable $callable call back
     *
     * @return void
     */
    public function __construct($path,$callable)
    {
        $this->_path = trim($path, '/');
        $this->_callable = $callable;
    }

    /**
     * Recherche de la corespondance de
     * la route
     *
     * @param string $url URL
     *
     * @return bool True si l'url
     */
    public function match($url)
    {
        $url = trim($url, '/');

        $path = preg_replace('#:([\w]+)#', '([^/]+)', $this->_path);
        $regex = '#^'.$path.'$#i';

        // Pas de correspondance
        if (!preg_match($regex, $url, $matches)) {
            return false;
        }
        array_shift($matches);
        $this->_matches = $matches;
        return true;
    }

    /**
     * Appel la methode
     *
     * @return [type] [description]
     */
    public function call()
    {
        $controller = '';
        if (isset($this->_callable['controller']) && !empty($this->_callable['controller'])) {
            $controller = $this->_callable['controller'];
        }

        $action = 'index';
        if (isset($this->_callable['action']) && !empty($this->_callable['action'])) {
            $action = $this->_callable['action'];
        }
        $controller = $controller.'Controller';
        $controller = ucwords($controller);
        $controller = '\\App\\Controller\\'.$controller;

        $app = new $controller();
        return call_user_func_array([$app,$action], $this->_matches);
    }
}

