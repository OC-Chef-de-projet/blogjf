<?php
namespace App\Controller;

/**
 * Page d'accueil du site
 */
class BiographieController extends \Core\Controller
{
	public $noModel = true;	// pas de model de données

	/**
	 * Biographie de Jean Forteroche
	 */
	public function index(){
	// Affichage de la page
		$this->display();
	}


}





