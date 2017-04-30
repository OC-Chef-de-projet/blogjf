<?php
namespace App\Controller;

/**
 * Les episodes du livre
 */
class EpisodeController extends \Core\Controller
{

	// Utiliser pour rechercher le premier ou
	// le dernier épisode
	const FIRST = -1;
	const LAST  = -2;

	const PREV = -1;
	const NEXT = 1;


	/**
	 * Affichage de la liste des episodes
	 * cette page n'est accessible qu'en mode
	 * administrateur
	 */
	public function index(){
		$this->restricted();
		$this->layout('admin');
		$this->set('episodes',\Core\Service::getInstance()['Episode']->getAll());
		$this->display('index');
	}

	/**
	 * Ajout d'un episode
	 * Mode administrateur uniquement
	 */
	public function add(){
		$this->restricted();
		$this->layout('admin');
		$errorMessage = '';

		if(isset($_POST) && !empty($_POST)){
			if(!$this->Episode->save($_POST)){
				$errorMessage = 'Impossible de créer cet épisode';
			}
		}
		$this->set('errorMessage',$errorMessage);
		$this->display();
	}

	/**
	 * Modification d'un episode
	 * Mode administrateur uniquement
	 * @param  integer $id Identifiant episode
	 * @return void
	 */
	public function edit($id = 0){
		$this->restricted();
		$this->layout('admin');

		// Enregistrement des données postées
		if(isset($_POST) && !empty($_POST)){
			$episode = $_POST;
			$episode['id'] = $id;
			$episode = $this->Episode->save($episode);
		}
		$this->set('episode',\Core\Service::getInstance()['Episode']->getById($id));
		$this->display();
	}

	public function getListOfTitles($offset = 0,$direction = ''){
		return \Core\Service::getInstance()['Episode']->getListOfTitles($offset,$direction);
	}

	/**
	 * Visualisation d'un episode et
	 * des commentaires associés
	 *
	 * @param  integer $id Identifiant de l'episode
	 * @return void
	 */
	public function view($id = 0,$focus = ''){

		$this->set('focus',$focus);
		$this->set('episode',\Core\Service::getInstance()['Episode']->getById($id));
		$this->set('comments',\Core\Service::getInstance()['Comment']->findAllWithChildren($id));
		$this->set('maxDepth',\Core\Config::getInstance()->config('maxDepth'));
		$this->display();
	}


	/**
	 * Suppression d'un episode
	 * Mode administrateur uniquement
	 * @param  integer $id Identifiant de l'episode
	 * @return [type]      [description]
	 */
	public function delete($id = 0){
		$this->restricted();
		$this->Episode->delete($id);
		$this->redirect('Episode','index',array());
	}

}
