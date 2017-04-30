<?php
/**
 * Biographie de l'auteur
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
 * Biographie de l'auteur
 *
 * @category App
 * @package  App\Controller
 * @author   Pierre-Sylvain Augereau <ps.augereau@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://blogjs.lignedemire.eu/admin
 */
class BiographieController extends Controller
{
    /** @var boolean Pas de modèle de données */
    public $noModel = true;

    /**
     * Page principale de la biographie
     *
     * @return void
     */
    public function index()
    {
        $this->display();
    }
}
