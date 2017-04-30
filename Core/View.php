<?php
/**
 * View
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
 * Gestion de l'affichage
 *
 * @category Core
 * @package  Core
 * @author   Pierre-Sylvain Augereau <ps.augereau@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://blogjs.lignedemire.eu
 */
abstract class View extends \stdClass
{

    public $vars = [];
    public $viewAction = null;

    private $_layout = 'default';

    /**
     * Affichage HTML
     *
     * @param string  $template Nom du template
     * @param boolean $layout   Utilisation d'un layout
     *
     * @return void
     */
    public function display($template = '',$layout = true)
    {
        $trace = debug_backtrace();

        // Utilise le nom de la function appelante pour 
        // le nom de fichier
        if (empty($template)) {
            $template = $trace[1]['function'];
        }

        $this->viewAction = $template;

        $model = get_called_class();
        $model = preg_replace('/Controller/', '', $model);
        $model = preg_replace('#App\\\#', '', $model);
        $model = preg_replace('#\\\#', '', $model);

        ob_start();
        foreach ($this->vars as $key => $var) {
            $$key = $var;
        }
        $contents = $this->_get($model, $template);
        // Ajout de la template de base
        if ($layout === true) {
            include_once ROOT.'/App/View/Layout/'.$this->_layout.'.php';
        }
        ob_end_flush();
    }

    /**
     * Affichage suite à une requête Ajax.
     * Retourne un objet JSON
     *
     * @return string
     */
    public function displayAjax()
    {
        ob_start();
        foreach ($this->vars as $key => $var) {
            $$key = $var;
        }
        include_once ROOT.'/App/View/Layout/json.php';
        ob_end_flush();
    }

    /**
     * Assigne le nom du layout de base
     *
     * @param string $layout nom du layout
     *
     * @return void
     */
    public function layout($layout)
    {
        $this->layout = $layout;
    }

    /**
     * Assigne des variables
     *
     * @param string $name  Nom de la variable
     * @param object $value valeur sous forme d'Objet, tableau, string,...
     *
     * @return void
     */
    public function set($name,$value)
    {
        $this->vars[$name] = $value;
    }

    /**
     * Formatage de la date
     *
     * @param string $date date
     *
     * @return string
     */
    public function dateFormat($date)
    {
        if (empty($date)) {
            return;
        }
        return (date('d/m/Y H:i:s', strtotime($date)) );
    }

    /**
     * Redirection
     *
     * @param string $controller Contrôleur
     * @param string $action     Methode
     * @param string $params     Paramètres
     *
     * @return void
     */
    public function redirect($controller,$action = '',$params = array())
    {
        $url = '/'.$controller.'/'.$action;
        error_log($url);
        header("Location: $url");
    }

    /**
     * Traitement de la vue
     *
     * @param string $model Modèle
     * @param string $file  Fichier
     *
     * @return string
     */
    private function _get($model,$file)
    {
        ob_start();
        foreach ($this->vars as $key => $var) {
            $$key = $var;
        }
        $model = preg_replace('#\\\#', DS, $model);
        include ROOT.'/App/View/'.$model.'/'.$file.'.php';
        return ob_get_clean();
    }
}

