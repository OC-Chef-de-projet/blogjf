<?php
namespace App\Controller;
use \App\Controller;

/**
 * Page principale d'adminsirration
 * Gestion des épisodes et des commentaires
 * Mode administrateur uniquement
 */
class AdminController extends \Core\Controller
{

	public $noModel = true;

	/**
	 * Page principale
	 * @return void
	 */
	public function index(){

		$this->restricted();
		$this->layout('admin');

		$this->set('abuses',\Core\Service::getInstance()['Comment']->getAbuseComments());
		$this->set('comments',\Core\Service::getInstance()['Comment']->getValidComments());

		$this->display();
	}
}

