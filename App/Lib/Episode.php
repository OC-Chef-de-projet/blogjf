<?php
/**
 * Episodes métier
 *
 * PHP Version 5.6
 *
 * @category App
 * @package  App\Lib
 * @author   Pierre-Sylvain Augereau <ps.augereau@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://blogjs.lignedemire.eu
 */
namespace App\Lib;
use \App\Model\Episode as _Episode;

/**
 * Classe métier pour les épisodes
 *
 * @category App
 * @package  App\Lib
 * @author   Pierre-Sylvain Augereau <ps.augereau@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://blogjs.lignedemire.eu
 */
class Episode
{

    /** @var class Modèle du métier */
    private $_model = null;

    /**
     * __construct
     */
    public function __construct()
    {
        $this->_model = new _Episode();
    }

    /**
     * Tous les episodes dans l'ordre
     * inverse d'enregsitrement.
     *
     * @return [type] [description]
    */
    public function getAll()
    {
        $options = [
            'order' => [
                'id' => 'desc'
            ]
        ];
        return $this->_model->find($options);
    }

    /**
     * Retourne un épisode
     *
     * @param integer $id N° de l'épisode
     *
     * @return object
    */
    public function getById($id = 0)
    {
        $options = [
            'type' => 'one',
            'conditions' => [
                'id' => $id
            ]
        ];
        return $this->_model->find($options);
    }

    /**
     * Identifiant et titres des episode par groupe
     * de X episodes
     *
     * @return string liste des titres
     */
    public function getListOfTitles()
    {

        $response = array();
        $limit = \Core\Config::getInstance()->config('episodeLimit');
        $response['isLast'] = 0;
        $response['isFirst'] = 0;

        // Requête AJAX
        if (isset($_POST['ajax']) && $_POST['ajax']) {
            if (isset($_POST['offset']) && is_numeric($_POST['offset'])) {
                $offset = $_POST['offset'];
            }
            if (isset($_POST['direction']) && !empty($_POST['direction'])) {
                switch ($_POST['direction']) {
                case \App\Controller\EpisodeController::PREV:
                    $offset = $offset + $limit;
                    break;
                case \App\Controller\EpisodeController::NEXT:
                    $offset = $offset - $limit;
                    break;
                default:
                    $offset = 0;
                    break;
                }
            }
        }
        if ($offset < 0) {
            $offset = 0;
        }

        $options = [
            'limit' => \Core\Config::getInstance()->config('episodeLimit'),
            'offset' => $offset,
            'order' => [
                'id' => 'desc'
            ],
            'field' => [
                'id',
                'title'
            ]
        ];


        $episodes = $this->_model->find($options);

        // Traitement du cas ou le nombre d'enregistrements retournés est inférieur
        // au nombre d'enregistrement à afficher. Dans ce cas on décale l'offset pour
        // que le nombdre d'enregistrements retournés soit égal au nombre d'enregistrement
        // à afficher.
        $count = count($episodes);
        if ($count < \Core\Config::getInstance()->config('episodeLimit') && $count > 0) {
            $offset = $offset - ($count + 1);
            $options = [
                'limit' => \Core\Config::getInstance()->config('episodeLimit'),
                'offset' => $offset,
                'order' => [
                    'id' => 'desc'
                ],
                'field' => [
                    'id',
                    'title'
                ]
            ];
            $episodes = $this->_model->find($options);
        }

        $response['offset'] = $offset;
        $response['episodes'] = $episodes;

        // Détermine si l'on est sur le dernier groupe
        // d'enregistrements
        if ($offset == 0) {
            $response['isLast'] = 1;
        }

        // Détermine si l'on est sur le premier groupe
        // d'enregistrements
        $count = $this->_model->count();
        $calc = $count - $offset;
        if ($calc <= $limit) {
            $response['isFirst'] = 1;
        }

        // URL rewriting
        foreach ($response['episodes'] as $episode) {
            $episode->url = \Core\Html::rewrite($episode->title);
        }

        // En AJAX on retourne un JSON
        if (isset($_POST['ajax']) && $_POST['ajax']) {
            echo json_encode($response);
        } else {
            return($response);
        }
    }

    /**
     * Retourne le titre d'un épisode
     *
     * @param int $id N° de l'épisode
     *
     * @return object
     */
    public function getTitle($id)
    {
        $options = [
            'type' => 'one',
            'limit' => 1,
            'field' => [
                'id',
                'title'
            ]
        ];
        switch ($id){
        case \App\Controller\EpisodeController::FIRST:
            $options['order'] = [ 'id' => 'asc'];
            break;
        case \App\Controller\EpisodeController::LAST:
            $options['order'] = [ 'id' => 'desc'];
            break;
        default:
            $options['conditions'] = [ 'id' => $id];
            break;
        }

        $episode = $this->_model->find($options);
        if ($episode) {
            $episode->url = \Core\Html::rewrite($episode->title);
        }
        return($episode);
    }

    /**
     * Résumé d'un épisode
     * Si aucun épisode n'est précisé, le dernier est retourné
     *
     * @param integer $episode N° de l'épisode (episode.id)
     *
     * @return object
     */
    public function getSummary($episode = 0)
    {
        // 1 seul épisode à la fois
        $options = [
            'type' => 'one',
            'limit' => 1,
        ];

        if (empty($episode)) {
            $episode = \App\Controller\EpisodeController::LAST;
        }
        switch ($episode) {
        case \App\Controller\EpisodeController::FIRST:
            $options['order'] = [ 'id' => 'asc'];
            break;
        case \App\Controller\EpisodeController::LAST:
            $options['order'] = [ 'id' => 'desc'];
            break;
        default:
            $options['conditions'] = [ 'id' => $episode];
            break;
        }

        $episode = $this->_model->find($options);
        if ($episode) {
            $episode->url = \Core\Html::rewrite($episode->title);
        }
        return($episode);
    }

    /**
     * Retourne le numéroi et le titre de l'épisode
     * précédent et le n° et le titre de l'épisode suivant
     *
     * @param integer $id N° de l'épisode
     *
     * @return array
     */
    public function getPrevAndNextTitle($id = 0)
    {

        $options = [
            'type' => 'one',
            'conditions' => [
                'id <'  => $id
            ],
            'order' => [
                'id' => 'desc'
            ],
            'limit' => 1,
            'field' => [
                'id',
                'title'
            ]
        ];


        // Recherche du dernier épisode
        // si pas d'épisode de précisé
        if (empty($id)) {
            unset($options['conditions']);
        }


        $prev_episode = $this->_model->find($options);

        if ($prev_episode) {
            $prev_episode->url = \Core\Html::rewrite($prev_episode->title);
        }
        $options = [
            'type' => 'one',
            'conditions' => [
                'id >'  => $id
            ],
            'order' => [
                'id' => 'asc'
            ],
            'limit' => 1,
            'field' => [
                'id',
                'title'
            ]
        ];
        $next_episode = $this->_model->find($options);
        if ($next_episode) {
            $next_episode->url = \Core\Html::rewrite($next_episode->title);
        }

        $navEpisode = array(
            'previous'  => $prev_episode,
            'next'      => $next_episode,
        );

        return($navEpisode);
    }
}
