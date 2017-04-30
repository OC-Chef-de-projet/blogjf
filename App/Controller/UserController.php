<?php
/**
 * Contrôleur pour les utilisateurs
 *
 * PHP Version 5.6
 *
 * @category App
 * @package  App\Controller
 * @author   Pierre-Sylvain Augereau <ps.augereau@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://blogjs.lignedemire.eu
 */
namespace App\Controller;
use \Core\Controller;
use \Core\Auth;

/**
 * Gestion des utilisateurs
 *
 * @category App
 * @package  App\Controller
 * @author   Pierre-Sylvain Augereau <ps.augereau@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://blogjs.lignedemire.eu/admin
 */
class UserController extends Controller
{

    /**
     * Connexion à l'administration
     *
     * @return void
     */
    public function login()
    {
        $error = '';
        if (isset($_POST['login']) && isset($_POST['password'])) {
            if (Auth::login($_POST['login'], $_POST['password'])) {
                header('Location: /Admin');
                $error = '';
            } else {
                $error = 'Identifiant ou mot de passe incorrect';
            }
        }
        $this->set('error', $error);
        $this->display();
    }

    /**
     * Déconnexion
     *
     * @return void
     */
    public function logout()
    {
        Auth::logout();
        header('Location: /');
    }
}

