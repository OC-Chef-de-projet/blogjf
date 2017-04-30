<?php
namespace Core;
use Pimple\Container;

abstract class Controller extends \Core\View
{
	public $noModel = false;
	private $container = null;


	public function __construct(){


		$this->container = new Container();

		$this->container['html'] = function($c) {
			return new Html();
		};
		$this->container['form'] = function($c) {
			return new Form();
		};
		$this->container['auth'] = function($c) {
			return new Auth();
		};

		// Nom du model qui est le même que
		// le controler sans le namespace et le mot
		// Controller à la fin
		$model = get_called_class();
		$model = preg_replace('#App\\\Controller\\\#','',$model);
		$model = preg_replace('#Controller$#','',$model);

		// Charge le model
		if(!isset($this->noModel) || $this->noModel === false){
			$modelClass = '\\App\\Model\\'.$model;
			$this->{$model}  = new $modelClass();
		}
	}

	public function Html(){
		return $this->container['html'];
	}
	public function Form(){
		return $this->container['form'];
	}
	public function Auth(){
		return $this->container['auth'];
	}


	/**
	 * Défini une méthode réservée à ceux qui sont
	 * connectés.
	 * Si l'utilisateur n'est pas connecter, il y a une
	 * redirection vers User->login()
	 */
	public function restricted(){
		if($this->Auth->isConnected() === false){
			header("Location: /Login");
		}
	}

}

