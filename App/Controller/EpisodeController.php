<?php
/**
 * Contrôleur pour les épisodes
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
use \Core\Service;
use \Core\Config;

/**
 * Episodes
 *
 * @category App
 * @package  App\Controller
 * @author   Pierre-Sylvain Augereau <ps.augereau@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://blogjs.lignedemire.eu/admin
 */
class EpisodeController extends Controller
{
    const FIRST = -1;   // Premier épisode
    const LAST  = -2;   // Dernier épisode

    const PREV = -1;    // Episode précédent
    const NEXT = 1;     // Episode suvant


    /**
     * Affichage de la liste des épisodes
     *
     * @return void
     */
    public function index()
    {
        $this->restricted();
        $this->layout('admin');
        $this->set('episodes', Service::getInstance()['Episode']->getAll());
        $this->display('index');
    }

    /**
     * Ajout d'un episode
     *
     * @return void
     */
    public function add()
    {
        $this->restricted();
        $this->layout('admin');
        $errorMessage = '';

        if (isset($_POST) && !empty($_POST)) {
            if (!$this->Episode->save($_POST)) {
                $errorMessage = 'Impossible de créer cet épisode';
            }
        }
        $this->set('errorMessage', $errorMessage);
        $this->display();
    }

    /**
     * Modification d'un episode
     *
     * @param integer $id Identifiant episode
     *
     * @return void
     */
    public function edit($id = 0)
    {
        $this->restricted();
        $this->layout('admin');

        // Enregistrement des données postées
        if (isset($_POST) && !empty($_POST)) {
            $episode = $_POST;
            $episode['id'] = $id;
            $episode = $this->Episode->save($episode);
        }
        $this->set('episode', Service::getInstance()['Episode']->getById($id));
        $this->display();
    }

    /**
     * Liste d'un groupe de titre
     *
     * @param integer $offset    Position dans la table
     * @param string  $direction Sens(précédent, suivant)
     *
     * @return array             tableau des titres
     */
    public function getListOfTitles($offset = 0,$direction = '')
    {
        return Service::getInstance()['Episode']->getListOfTitles($offset, $direction);
    }

    /**
     * Visualisation d'un episode et
     * des commentaires associés
     *
     * @param integer $id    Identifiant de l'épisode
     * @param integer $focus Identifiant du commentaire pointé
     *
     * @return void
     */
    public function view($id = 0,$focus = '')
    {

        $this->set('focus', $focus);
        $this->set('episode', Service::getInstance()['Episode']->getById($id));
        $this->set('comments', Service::getInstance()['Comment']->findAllWithChildren($id));
        $this->set('maxDepth', Config::getInstance()->config('maxDepth'));
        $this->display();
    }


    /**
     * Suppression d'un episode
     *
     * @param integer $id Identifiant de l'épisode
     *
     * @return [type]      [description]
     */
    public function delete($id = 0)
    {
        $this->restricted();
        $this->Episode->delete($id);
        $this->redirect('Episode', 'index', array());
    }

}
