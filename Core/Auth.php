<?php
/**
 * Authentification
 *
 * PHP Version 5.6
 *
 * @category Core
 * @package  Core
 * @author   Pierre-Sylvain Augereau <ps.augereau@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://blogjs.lignedemire.eu
 */
namespace Core;

/**
 * Authentification des utilisateurs
 *
 * @category Core
 * @package  Core
 * @author   Pierre-Sylvain Augereau <ps.augereau@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://blogjs.lignedemire.eu
 */
class Auth
{
    /**
     * Authentification
     *
     * @param string $username Login
     * @param string $password Mot de passe
     *
     * @return boolean
     */
    public function login($username, $password)
    {
        // Recherche l'utilisateur
        $options = [
            'type' => 'one',
            'conditions' => [
                'login' => $username
            ]
        ];
        $user = $this->User->find($options);
        if (empty($user)) {
            Session::getInstance()->write('isConnected', false);
            return false;
        }

        // Vérifie que le mot de passe saisi est le même que celui stocké
        $hash = $user->password;
        // Mot de passe correct
        if (password_verify($password, $hash)) {
            // Recalcul du hash si nécessaire
            if (password_needs_rehash($hash, PASSWORD_DEFAULT, [ 'cost' => 12])) {
                $user->password = password_hash($password, PASSWORD_DEFAULT, [ 'cost' => 12]);
                $this->User->save($user);
            }
        } else {
            Session::getInstance()->write('isConnected', false);
            return false;
        }
        Session::getInstance()->write('isConnected', true);
        return true;
    }

    /**
     * Déconnexion
     *
     * @return void
     */
    public function logout()
    {
        Session::getInstance()->write('isConnected', false);
    }

    /**
     * Vérifie si l'utilisateur est connecté
     *
     * @return boolean
     */
    public function isConnected()
    {
        return Session::getInstance()->read('isConnected');

    }
}

