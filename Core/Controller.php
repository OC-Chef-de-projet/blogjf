<?php 
namespace Core;

class Controller extends \Core\View
{
	public $noModel = false;
	protected $twig;
	public $Form;
	public $HTML;

	public function __construct(){

		// Nom du model qui est le même que 
		// le controler sans le namespace et le mot
		// Controler à la fin
		$model = get_called_class();
		$model = preg_replace('#App\\\Controller\\\#','',$model);
		$model = preg_replace('#Controller$#','',$model);

		// Charge le model
		if(!isset($this->noModel) || $this->noModel === false){
			$modelClass = '\\App\\Model\\'.$model;
			$this->{$model}  = new $modelClass();
		}
		$this->Form = new Form();
		$this->Html = new Html();
	}

}

