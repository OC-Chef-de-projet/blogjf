<?php
/**
 * Contrôleur pour les commentaires
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
 * Commentaires
 *
 * @category App
 * @package  App\Controller
 * @author   Pierre-Sylvain Augereau <ps.augereau@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://blogjs.lignedemire.eu/admin
 */
class CommentController extends Controller
{

    /**
     * Approbation d'un commentaire
     *
     * @param integer $id Identifiant du commentaire
     *
     * @return string      Message d'état
     */
    public function approve($id = 0)
    {
        $this->restricted();
        $this->set('data', Service::getInstance()['Comment']->approve($_POST));
        $this->displayAjax();
    }

    /**
     * Supprime un commentaire
     *
     * @return string Message au format json
     */
    public function remove()
    {
        $this->restricted();
        $this->set('data', Service::getInstance()['Comment']->remove($_POST));
        $this->displayAjax();
    }

    /**
     * Signale un commentaire abusif
     *
     * @return void
     */
    public function setAbuse()
    {
        $this->set('data', Service::getInstance()['Comment']->setAbuse($_POST));
        $this->displayAjax();
    }

    /**
     * Ajout d'un commentaire
     *
     * @return void
     */
    public function add()
    {
        $this->set('data', Service::getInstance()['Comment']->add($_POST));
        $this->displayAjax();
    }
}
