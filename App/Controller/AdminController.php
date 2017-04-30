<?php
/**
 * Administration du site
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
 * Administration du site
 *
 * @category App
 * @package  App\Controller
 * @author   Pierre-Sylvain Augereau <ps.augereau@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://blogjs.lignedemire.eu/admin
 */
class AdminController extends Controller
{

    /** @var boolean Pas de modèle de données */
    public $noModel = true;

    /**
     * Page principale d'administration
     *
     * @return void
     */
    public function index()
    {

        $this->restricted();
        $this->layout('admin');

        $this->set('abuses', Service::getInstance()['Comment']->getAbuseComments());
        $this->set('comments', Service::getInstance()['Comment']->getValidComments());

        $this->display();
    }
}

