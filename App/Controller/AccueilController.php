<?php
namespace App\Controller;
use \App\Controller;

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


		// Episodes
		$ep = new EpisodeController();


		// Liste des titres de X derniers episodes
		$episodes = $ep->getEpisodesTitle();
		$this->set('episodes',$episodes);


		// Premier episode, c'est pour le lien
		// vers le premier chapitre du roman
		$first = $ep->getEpisodeTitle('first');
		$this->set('first',$first);

		// résumé d'un épisode
		if(!$episode_id){
			$episode_id = 'last';
		}

		$summary = $ep->getEpisodeSummary($episode_id);
		$this->set('summary',$summary);

		// Navigation dans les titres des épisodes
		$navEpisode = $ep->navEpisode($summary->id);
		$this->set('navEpisode',$navEpisode);

		// Affichage de la page
		$this->display();
	}


}





