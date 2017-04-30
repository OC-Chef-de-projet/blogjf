<?php

namespace Core;

/**
 * Vue
 */
abstract class View extends \stdClass
{

	public $vars = [];
	public $viewAction = null;

	private $layout = 'default';


	public function __construct(){
	}


	/**
	 * Affichage HTML
	 * @param  string  $template Nom du template
	 * @param  boolean $layout   Utilisation d'un layout
	 * @return [type]            [description]
	 */
	public function display($template = '',$layout = true){

		$trace = debug_backtrace();

		// Utilise le nom de la function appelante pour 
		// le nom de fichier
		if(empty($template)){
			$template = $trace[1]['function'];
		}

		$this->viewAction = $template;

        $model = get_called_class();
        $model = preg_replace('/Controller/','',$model);
        $model = preg_replace('#App\\\#','',$model);

		ob_start();
		foreach($this->vars as $key => $var){
			$$key = $var;
		}
		$contents = $this->get($model,$template);
		// Ajout de la template de base
		if($layout === true){
			include_once(ROOT.'/App/View/Layout/'.$this->layout.'.php');
		}
		ob_end_flush();
	}

	/**
	 * Assigne le nom du layout de base
	 * @param  [type] $layout nom du layout
	 * @return [type]         [description]
	 */
	public function layout($layout){
		$this->layout = $layout;
	}

	/**
	 * Assigne des variables
	 * @param string $name  Nom de la variable
	 * @param object $value valeur sous forme d'Objet, tableau, string,...
	 */
	public function set($name,$value){
		$this->vars[$name] = $value;
	}

	/**
	 * Formatage de la date
	 * @param  string $date
	 * @return string
	 */
	public function dateFormat($date){
		if(empty($date))return;
		return(date('d/m/Y H:i:s',strtotime($date)));
	}

	/**
	 * Redirection
	 * @param  string $controller
	 * @param  string $action
	 * @param  array  $params
	 */
	public function redirect($controller,$action = '',$params = array()){
		$url = '/'.$controller.'/'.$action;
		header("Location: $url");
	}

	/**
	 * Traitement de la vue
	 * @param  string $model
	 * @param  string $file
	 * @return string
	 */
	private function get($model,$file){
		ob_start();
		foreach($this->vars as $key => $var){
			$$key = $var;
		}
		$model = preg_replace('#\\\#',DS,$model);
		include(ROOT.'/App/View/'.$model.'/'.$file.'.php');
		return ob_get_clean();
	}
}

