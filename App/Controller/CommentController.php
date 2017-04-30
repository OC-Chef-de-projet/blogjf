<?php
namespace App\Controller;

/**
 * Commentaires
 */
class CommentController extends \Core\Controller
{

	/**
	 * Approbation d'un commentaire
	 * Mode administrateur uniquement
	 * @param  integer $id Identifiant du commentaire
	 * @return string      Message d'état
	 */
	public function approve($id = 0){
		$this->restricted();
		$this->set('data',\Core\Service::getInstance()['Comment']->approve($_POST));
		$this->displayAjax();
	}

	/**
	 * Supprime un commentaire et tous ceux en dessous
	 * Mode administrateur uniquement
	 * @param  integer $id Identifiant commentaire
	 * @return string      Message au format json
	 */
	public function remove(){
		$this->restricted();
		$this->set('data',\Core\Service::getInstance()['Comment']->remove($_POST));
		$this->displayAjax();
	}

	/**
	 * Signale un commentaire abusif
	 */
	public function setAbuse(){
		$this->set('data',\Core\Service::getInstance()['Comment']->setAbuse($_POST));
		$this->displayAjax();
	}
	/**
	 * Ajout d'un commentaire
	 */
	public function add(){
		$this->set('data',\Core\Service::getInstance()['Comment']->add($_POST));
		$this->displayAjax();
	}
}

