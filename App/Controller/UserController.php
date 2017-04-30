<?php
namespace App\Controller;

/**
 * Gestion des utilisateurs
 */
class UserController extends \Core\Controller
{

	/**
	 * Connexion à l'administration
	 * @return void
	 */
	public function login(){
		$error = '';
		if(isset($_POST['login']) && isset($_POST['password'])){
			if(\Core\Auth::login($_POST['login'],$_POST['password'])){
				header('Location: /Admin');
				$error = '';
			} else {
				$error = 'Identifiant ou mot de passe incorrect';
			}
		}
		$this->set('error',$error);
		$this->display();
	}

	/**
	 * Déconnexion
	 * @return void
	 */
	public function logout(){
		\Core\Auth::logout();
		header('Location: /');
	}
}

