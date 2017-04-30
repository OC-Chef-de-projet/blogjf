<?php
namespace App\Controller;
use \App\Controller;

/**
 * Les episodes du livre
 */
class EpisodeController extends \Core\Controller
{

	// Utiliser pour rechercher le premier ou
	// le dernier épisode
	const FIRST = -1;
	const LAST  = -2;

	/**
	 * Affichage de la liste des episodes
	 * cette page n'est accessible qu'en mode
	 * administrateur
	 */
	public function index(){
		$this->restricted();
		$this->layout('admin');

		// Tous les episodes dans l'ordre
		// inverse d'enregsitrement.
		$options = [
			'order' => [
				'id' => 'desc'
			]
		];
		$episodes = $this->Episode->find($options);
		$this->set('episodes',$episodes);
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

		$options = [
			'type' => 'one',
			'conditions' => [
				'id' => $id
			]
		];

		// Recherche de l'episode
		$this->set('episode',$this->Episode->find($options));
		$this->display();
	}

	/**
	 * Visualisation d'un episode et
	 * des commentaires associés
	 *
	 * @param  integer $id Identifiant de l'episode
	 * @return void
	 */
	public function view($id = 0,$focus = ''){

		// Récupération de l'episode
		$options = [
			'type' => 'one',
			'conditions' => [
				'id' => $id
			]
		];


		$this->set('focus',$focus);

		$this->set('episode',$this->Episode->find($options));

		// Recherche des commentaires
		$Comment = new CommentController();
		$this->set('comments',$Comment->findAllWithChildren($id));

		// Profondeur max des commentaires
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


	/**
	 * Recherche le dernier épisode publié
	 * @return array Episode
	 */
	public function getLastEpisode(){
		$options = [
			'type' => 'one',
			'limit' => 1,
			'order' => [
				'id' => 'desc'
			]
		];

		$episode = $this->Episode->find($options);
		$episode->url = $this->Html->rewrite($episode->title);
		return($episode);
	}


	/**
	 * Identifiant et titres des episode par groupe
	 * de X episodes
	 *
	 * @param  integer $offset    [description]
	 * @param  string  $direction [description]
	 * @return [type]             [description]
	 */
	public function getEpisodesTitle($offset = 0,$direction = ''){

		$response = array();
		$limit = \Core\Config::getInstance()->config('episodeLimit');
		$response['isLast'] = 0;
		$response['isFirst'] = 0;

		// Requête AJAX
		if(isset($_POST['ajax']) && $_POST['ajax']){
			if(isset($_POST['offset']) && is_numeric($_POST['offset'])){
				$offset = $_POST['offset'];
			}
			if(isset($_POST['direction']) && !empty($_POST['direction'])){
				switch($_POST['direction']){
					case 'prev' : $offset = $offset + $limit;break;
					case 'next' : $offset = $offset - $limit;break;
					default : $offset = 0;break;
				}
			}
		}
		if($offset < 0)$offset = 0;

		$options = [
			'limit' => \Core\Config::getInstance()->config('episodeLimit'),
			'offset' => $offset,
			'order' => [
				'id' => 'desc'
			],
			'field' => [
				'id',
				'title'
			]
		];


		$episodes = $this->Episode->find($options);

		// Traitement du cas ou le nombre d'enregistrements retournés est inférieur
		// au nombre d'enregistrement à afficher. Dans ce cas on décale l'offset pour
		// que le nombdre d'enregistrements retournés soit égal au nombre d'enregistrement
		// à afficher.
		$count = count($episodes);
		if($count < \Core\Config::getInstance()->config('episodeLimit') && $count > 0){
			$offset = $offset - ($count + 1);
			$options = [
				'limit' => \Core\Config::getInstance()->config('episodeLimit'),
				'offset' => $offset,
				'order' => [
					'id' => 'desc'
				],
				'field' => [
					'id',
					'title'
				]
			];
			$episodes = $this->Episode->find($options);
		}

		$response['offset'] = $offset;
		$response['episodes'] = $episodes;

		// Détermine si l'on est sur le dernier groupe
		// d'enregistrements
		if($offset == 0){
			$response['isLast'] = 1;
		}

		// Détermine si l'on est sur le premier groupe
		// d'enregistrements
		$count = $this->Episode->count();
		$calc = $count - $offset;
		if($calc <= $limit){
			$response['isFirst'] = 1;
		}

		// URL rewriting
		foreach($response['episodes'] as $episode){
				$episode->url = $this->Html->rewrite($episode->title);
		}

		// En AJAX on retourne un JSON
		if(isset($_POST['ajax']) && $_POST['ajax']){
			echo json_encode($response);
		} else {
			return($response);
		}
	}

	public function getEpisodeTitle($episode){
		$options = [
			'type' => 'one',
			'limit' => 1,
			'field' => [
				'id',
				'title'
			]
		];
		switch($episode){
			case self::FIRST : $options['order'] = [ 'id' => 'asc'];break;
			case self::LAST : $options['order'] = [ 'id' => 'desc'];break;
			default : $options['conditions'] = [ 'id' => $episode];break;
		}

		$episode = $this->Episode->find($options);
		if($episode){
			$episode->url = $this->Html->rewrite($episode->title);
		}
		return($episode);
	}

	public function getEpisodeSummary($episode){
		$options = [
			'type' => 'one',
			'limit' => 1,
		];
		switch($episode){
			case self::FIRST : $options['order'] = [ 'id' => 'asc'];break;
			case self::LAST : $options['order'] = [ 'id' => 'desc'];break;
			default : $options['conditions'] = [ 'id' => $episode];break;
		}

		$episode = $this->Episode->find($options);
		if($episode){
			$episode->url = $this->Html->rewrite($episode->title);
		}
		return($episode);
	}

	/**
	 * Affichage du résumé d'un épisode
	 * @param  integer $current_episode_id n° de l'épisode
	 * @return [type]                      [description]
	 */
	public function navEpisode($current_episode_id = 0){



		if(empty($current_episode_id))return;

		$options = [
			'type' => 'one',
			'conditions' => [
				'id <'  => $current_episode_id
			],
			'order' => [
				'id' => 'desc'
			],
			'limit' => 1,
			'field' => [
				'id',
				'title'
			]
		];
		$prev_episode = $this->Episode->find($options);

		if($prev_episode){
			$prev_episode->url = $this->Html->rewrite($prev_episode->title);
		}
		$options = [
			'type' => 'one',
			'conditions' => [
				'id >'  => $current_episode_id
			],
			'order' => [
				'id' => 'asc'
			],
			'limit' => 1,
			'field' => [
				'id',
				'title'
			]
		];
		$next_episode = $this->Episode->find($options);
		if($next_episode){
			$next_episode->url = $this->Html->rewrite($next_episode->title);
		}

		$navEpisode = array(
			'previous'  => $prev_episode,
			'next' 		=> $next_episode,
		);

		return($navEpisode);
	}

}
