<?php
/**
 * Controller
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
 * Contrôleur de l'application
 *
 * @category Core
 * @package  Core
 * @author   Pierre-Sylvain Augereau <ps.augereau@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://blogjs.lignedemire.eu
 */
abstract class Controller extends View
{
    public $noModel = false;
    public $container = null;

    /**
     * __construct
     */
    public function __construct()
    {

        $this->container = new Container();

        $this->container['html'] = function ($c) {
            return new Html();
        };
        $this->container['form'] = function ($c) {
            return new Form();
        };
        $this->container['auth'] = function ($c) {
            return new Auth();
        };

        // Nom du model qui est le même que
        // le controler sans le namespace et le mot
        // Controller à la fin
        $model = get_called_class();
        $model = preg_replace('#App\\\Controller\\\#', '', $model);
        $model = preg_replace('#Controller$#', '', $model);

        // Charge le model
        if (!isset($this->noModel) || $this->noModel === false) {
            $modelClass = '\\App\\Model\\'.$model;
            $this->{$model}  = new $modelClass();
        }
    }

    /**
     * Container Html
     *
     * @return Container
     */
    public function html()
    {
        return $this->container['html'];
    }

    /**
     * Container Form
     *
     * @return Container
     */
    public function form()
    {
        return $this->container['form'];
    }

    /**
     * Container Auth
     *
     * @return Container
     */
    public function auth()
    {
        return $this->container['auth'];
    }

    /**
     * Défini une méthode réservée à ceux qui sont
     * connectés.
     * Si l'utilisateur n'est pas connecter, il y a une
     * redirection vers User->login()
     *
     * @return void
     */
    public function restricted()
    {
        if ($this->container['auth']->isConnected() === false) {
            header("Location: /Login");
        }
    }

}

