<?php
/**
 * Router
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
 * Gestion du routage
 *
 * @category Core
 * @package  Core
 * @author   Pierre-Sylvain Augereau <ps.augereau@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://blogjs.lignedemire.eu
 */
class Router
{
    private $url;
    private $routes = array();

    /**
     * __construct
     *
     * @param string $url URL
     */
    public function __construct($url)
    {
        $this->url = $url;
    }


    /**
     * Ajoute au tableau des routes pour les types GET
     *
     * @param string $path     Chemin
     * @param array  $callable call back
     *
     * @return void
     */
    public function get($path,$callable)
    {
        $this->routes['GET'][] = new Route($path, $callable);
    }

    /**
     * Ajoute au tableau des routes pour les types POST
     *
     * @param string $path     chemin
     * @param array  $callable call back
     *
     * @return void
     */
    public function post($path,$callable)
    {
        $this->routes['POST'][] = new Route($path, $callable);
    }

    /**
     * Execution d'un routage
     *
     * @return void
     */
    public function run()
    {
        // Vérifie que la méthode (GET/POST) existe bien
        // dans le tableau des routes
        $method = $_SERVER['REQUEST_METHOD'];
        if (!isset($this->routes[$method ])) {
            throw new \Exception("Méthode $method inconnue ".$this->url, 9000);
        }
        foreach ($this->routes[$method] as $route) {
            if ($route->match($this->url)) {
                return $route->call();
            }
        }
        header('Location: /ErrorPages/HTTP404.html');
    }
}

