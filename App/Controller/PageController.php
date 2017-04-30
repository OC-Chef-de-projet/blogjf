<?php
/**
 * Contrôleur pour les pages
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

/**
 * Pages
 *
 * @category App
 * @package  App\Controller
 * @author   Pierre-Sylvain Augereau <ps.augereau@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://blogjs.lignedemire.eu/admin
 */
class PageController extends Controller
{

    /**
     * Affichage d'une page
     *
     * @return void
     */
    public function projet()
    {
        $project = $this->getPage(1);
        $this->set('project', $project);
        $this->display();
    }

    /**
     * Retourne le contenu d'une page
     *
     * @param integer $id Identifiant de la page
     *
     * @return Object      Page
     */
    public function getPage($id = 0)
    {
        // Récupération de la page
        $options = [
            'type' => 'one',
            'conditions' => [
                'id' => $id
            ]
        ];
        return $this->Page->find($options);
    }
}
