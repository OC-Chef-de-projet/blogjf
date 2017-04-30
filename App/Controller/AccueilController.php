<?php
namespace App\Controller;

/**
 * Page d'accueil du site
 */
class AccueilController extends \Core\Controller
{
	public $noModel = true;	// pas de model de données

	/**
	 * Page d'accueil du site
	 */
	public function index($episode_id = 0){

		// Le projet est une page
		$prj = new PageController('Page');
		$project = $prj->getPage(1);
		$this->set('project',$project);

		// Liste des titres de X derniers episodes
		$this->set('episodes',\Core\Service::getInstance()['Episode']->getListOfTitles());

		// Titre du premier épisode
		$this->set('first',\Core\Service::getInstance()['Episode']->getTitle(EpisodeController::FIRST));

		// Résumé de l'épisode
		$this->set('summary',\Core\Service::getInstance()['Episode']->getSummary($episode_id));

		// Navigation dans les épisodes
		$this->set('navEpisode',\Core\Service::getInstance()['Episode']->getPrevAndNextTitle($episode_id));

		// Affichage de la page
		$this->display();
	}


}





