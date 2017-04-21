<?php
namespace App\Controller;
use \App\Controller;

/**
 * Pages
 */
class PageController extends \Core\Controller
{


	/**
	 * Affichage d'une page
	 * @return void
	 */
	public function projet(){
		$project = $this->getPage(1);
		$this->set('project',$project);
		$this->display();
	}

	/**
	 * Retourne le contenu d'une page
	 * @param  integer $id Identifiant de la page
	 * @return Object      Page
	 */
	public function getPage($id = 0){
		// Récupération de la page
		$options = [
			'type' => 'one',
			'conditions' => [
				'id' => $id
			]
		];
		return $this->Page->find($options);
	}

}
