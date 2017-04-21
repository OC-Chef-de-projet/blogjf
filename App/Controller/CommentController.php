<?php
namespace App\Controller;

/**
 * Commentaires
 */
class CommentController extends \Core\Controller
{


	/**
	 * Liste des commentaires
	 * Mode administrateur uniquement
	 * @return void
	 */
	public function index(){
		$episodes = $this->Episode->find();
		$this->set('episodes',$episodes);
		$this->display('index');
	}


	/**
	 * Tous les commentaires par ordre inverse
	 * d'enregistrement
	 * Mode administrateur uniquement
	 * @return void
	 */
	public function getComments(){
		$options = [
			'order' => [
				'id' => 'desc'
			]
		];
		return $this->Comment->find($options);
	}


	/**
	 * Approbation d'un commentaire
	 * Mode administrateur uniquement
	 * @param  integer $id Identifiant du commentaire
	 * @return string      Message d'état
	 */
	public function approve($id = 0){

		$message = "Impossible de changer l'état de ce commentaire";
		try {
			if(isset($_POST['ajax']) && $_POST['ajax']){
				$data['id'] = $_POST['comment_id'];
				$data['abuse'] = 0;
				$this->Comment->save($data);
				$message = 'Commentaire approuvé';
			}
		}
		catch(Exception $ex){
			$message = $ex->getMessage();
		}
		echo json_encode(['message' => $message]);
		exit;

	}

	/**
	 * Supprime un commentaire et tous ceux en dessous
	 * Mode administrateur uniquement
	 * @param  integer $id Identifiant commentaire
	 * @return string      Message au format json
	 */
	public function remove($id = 0){

		$message = "Impossible de supprimer ce commentaire";
		try {
			if(isset($_POST['ajax']) && $_POST['ajax']){
				// Récupartion du commentaire pour
				// avoir le parent_id
				$options = [
					'type' => 'one',
					'conditions' => [
						'id' => $_POST['comment_id']
					]
				];
				$comment = $this->Comment->find($options);
				if(!$comment){
					throw new Exception("Impossible de trouver le commentaire");
				}
				$parent_id = $comment->parent_id;
				$depth = $comment->depth;

				$this->Comment->delete($_POST['comment_id']);

				// Mis à jour des commentaires en dessous pour
				// les remonter d'un niveau
				$sql = 'UPDATE comment SET parent_id = :parent_parent_id, depth = :depth WHERE parent_id = :parent_id';
				$keys = [
					':parent_parent_id' => $parent_id,
					':depth' => $depth,
					':parent_id' => $_POST['comment_id']
				];
				$this->Comment->sql($sql,$keys);
				$message = 'Commentaire supprimé';
			}
		}
		catch(Exception $ex){
			$message = $ex->getMessage();
		}
		echo json_encode(['message' => $message]);
		exit;

	}

	/**
	 * Signale un commentaire abusif
	 */
	public function setAbuse(){
		try {
			$message = 'Nous ne pouvons transmettre votre demande à l\'administrateur';
			if(isset($_POST['ajax']) && $_POST['ajax'] && isset($_POST['comment_id']) && !empty($_POST['comment_id'])){
					$data['abuse'] = true;
					$data['id'] = $_POST['comment_id'];
					$h = $this->Comment->save($data);
					error_log(print_r($h,true));
					if($h){
						$message = 'Votre demande a été transmise à l\'administrateur du site';
					}
			}
		}
		catch(Exception $ex){
			$message = $ex->getMessage();
		}
		echo json_encode(['message' => $message]);
		exit;
	}

	/**
	 * Ajout d'un commentaire
	 */
	public function add(){

		try {
			if(isset($_POST['ajax']) && $_POST['ajax']){
				$data = $_POST;
				unset($data['ajax']);
				$data['depth'] = 0;
				// Recherche de la profondeur
				$options = [
					'type' => 'one',
					'conditions' => [
						'id' => $data['parent_id']
					]
				];
				if(isset($data['parent_id'])){
					$c = $this->Comment->find($options);
					if(isset($c->depth)){
						$data['depth'] = $c->depth + 1;

					}
				}
				$comment = $this->Comment->save($data);
				$message = 'Merci pour votre commentaire';
			}
		}
		catch(Exception $ex){
			$message = $ex->getMessage();
		}
		echo json_encode(['message' => $message]);
		exit;
	}


	/**
	 * Recherche les commentaires d'un episode
	 *
	 * @param  int  $episode_id     Identifiant episode
	 * @param  boolean $unset_children Suppresion des enfants dans le tableau de résultat
	 * @return array                   Tableau de commentaires
	 */
	public function findAllWithChildren($episode_id, $unset_children = true)
    {
    	$comments = $comments_by_id = $this->findAllById($episode_id);

        foreach ($comments as $id => $comment) {
            if ($comment->parent_id != 0) {
                $comments_by_id[$comment->parent_id]->children[] = $comment;
                // Suppresion des enfants
                if ($unset_children) {
                    unset($comments[$id]);
                }
            }
        }
        return $comments;
    }

    /**
     * Recherche des commentaires par episode
     *
     * @param  int $episode_id 	Identifiant episode
     * @return array            Tableau des commentaires
     */
	private function findAllById($episode_id){
		$options = [
			'conditions' => [
				'episode_id' => $episode_id
			]
		];
		$comments = $this->Comment->find($options);
		$comments_by_id = [];
        foreach ($comments as $comment) {
            $comments_by_id[$comment->id] = $comment;
        }
        return $comments_by_id;

	}


}