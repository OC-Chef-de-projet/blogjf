<?php

namespace Core;


class View extends \stdClass
{

	public $vars = [];
	public $viewAction = null;

	private $layout = 'default';


	public function __construct(){
	}


	public function display($template = '',$layout = true){

		$trace = debug_backtrace(); 

		// Utilise le nom de la function appelante pour 
		// le nom de fichier
		if(empty($template)){
			$template = $trace[1]['function'];
		}
		
		$this->viewAction = $template;

		error_log($template);
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

	public function layout($layout){
		$this->layout = $layout;
	}

	public function set($name,$value){
		$this->vars[$name] = $value;
	}

	public function get($model,$file){
		ob_start();
		foreach($this->vars as $key => $var){
			$$key = $var;
		}
		$model = preg_replace('#\\\#',DS,$model);
		include(ROOT.'/App/View/'.$model.'/'.$file.'.php');
		return ob_get_clean();
	}

	public function dateFormat($date){
		if(empty($date))return;
		return(date('d/m/Y H:i:s',strtotime($date)));
	}

	public function redirect($controller,$action = '',$params = array()){
		define('BASE','blogjf');
		$url = '/'.BASE.'/'.$controller.'/'.$action;
		header("Location: $url");
	}
}

