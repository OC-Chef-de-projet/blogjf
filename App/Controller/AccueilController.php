<?php
/**
 * Accueil Contrôleur
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

/**
 * Page d'accueil du site
 *
 * @category App
 * @package  App\Controller
 * @author   Pierre-Sylvain Augereau <ps.augereau@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://blogjs.lignedemire.eu
 */
class AccueilController extends Controller
{
    /** @var boolean Pas de model de données */
    public $noModel = true;

    /**
     * Page principale du site
     *
     * @param integer $episode_id N° de l'épisode
     *
     * @return void
     */
    public function index($episode_id = 0)
    {
        // Le projet est une page
        $prj = new PageController('Page');
        $project = $prj->getPage(1);
        $this->set('project', $project);

        // Liste des titres de X derniers episodes
        $this->set('episodes', Service::getInstance()['Episode']->getListOfTitles());

        // Titre du premier épisode
        $this->set('first', Service::getInstance()['Episode']->getTitle(EpisodeController::FIRST));

        // Résumé de l'épisode
        $this->set('summary', Service::getInstance()['Episode']->getSummary($episode_id));

        // Navigation dans les épisodes
        $this->set('navEpisode', Service::getInstance()['Episode']->getPrevAndNextTitle($episode_id));

        // Affichage de la page
        $this->display();
    }


}





