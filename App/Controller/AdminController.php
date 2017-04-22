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

		// Chargement de la liste des comentaires
		$CommentController = new CommentController('Comment');
		$commentList = $CommentController->getComments();

		$abuses = array();
		$comments = array();
		foreach($commentList as $comment){
			if($comment->abuse == 1){
				$abuses[] = $comment;
			} else {
				$comments[] = $comment;
			}
		}
		$this->set('abuses',$abuses); // Commentaires signalés comme abusif
		$this->set('comments',$comments); // Les autres

		$this->display('index');
	}
}

