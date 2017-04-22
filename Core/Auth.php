<?php

namespace Core;

/**
* Authentification
*/
class Auth
{

	/**
	 * Authentification
	 * @param  string $username Login
	 * @param  tring $password  Mot de passe
	 * @return boolean
	 */
	public function login($username, $password){

		// Cryptage du mot de passe
		$salt = \Core\Config::getInstance()->config('salt');
		$pwd = md5($salt.$password);
		$options = [
			'conditions' => [
				'login' => $username,
				'password' => $pwd
			]
		];
		// Recherche l'utilisateur
		$user = $this->User->find($options);
		if(empty($user)){
			// Pas nécessaire
			Session::getInstance()->write('isConnected',false);	
			return false;
		}
		Session::getInstance()->write('isConnected',true);
		return true;
	}

	/**
	 * Déconnexion
	 * @return void
	 */
	public function logout(){
		Session::getInstance()->write('isConnected',false);
	}

    /**
     * Vérifie si l'utilisateur est connecté
     * @return boolean [description]
     */
    public function isConnected(){
    	return Session::getInstance()->read('isConnected');

    }
}