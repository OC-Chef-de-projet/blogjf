<?php
/**
 * Commentaires métier
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
use \App\Model\Comment as _Comment;
use \Core\Mail;

/**
 * Classe métier pour les commentaires
 *
 * @category App
 * @package  App\Lib
 * @author   Pierre-Sylvain Augereau <ps.augereau@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://blogjs.lignedemire.eu
 */
class Comment
{
    /** @var class Modèle du métier */
    private $_model = null;

    /**
     * __construct
     */
    public function __construct()
    {
        $this->_model = new _Comment();
    }

    /**
     * Retourne les commentaires abusifs
     *
     * @return array
     */
    public function getAbuseComments()
    {
        $options = [
            'conditions' => [
                'abuse' => 1
            ],
            'order' => [
                'id' => 'desc'
            ]
        ];
        return $this->_model->find($options);
    }

    /**
     * Retourne les commentaires qui ne sont pas abusifs
     *
     * @return array
     */
    public function getValidComments()
    {
        $options = [
            'conditions' => [
                'abuse' => 0
            ],
            'order' => [
                'id' => 'desc'
            ]
        ];
        return $this->_model->find($options);
    }

    /**
     * Recherche les commentaires d'un episode
     *
     * @param int     $episode_id     Identifiant episode
     * @param boolean $unset_children Suppresion des enfants dans le tableau de résultat
     *
     * @return array                   Tableau de commentaires
     */
    public function findAllWithChildren($episode_id, $unset_children = true)
    {
        $comments = $comments_by_id = $this->_findAllById($episode_id);

        foreach ($comments as $id => $comment) {
            if ($comment->parent_id != 0) {
                $comments_by_id[$comment->parent_id]->children[] = $comment;
                // Suppresion des enfants
                if ($unset_children) {
                    unset($comments[$id]);
                }
            }
        }
        return $comments;
    }

     /**
     * Recherche des commentaires par episode
     *
     * @param int $episode_id Identifiant episode
     *
     * @return array Tableau des commentaires
     */
    private function _findAllById($episode_id)
    {
        $options = [
            'conditions' => [
                'episode_id' => $episode_id
            ]
        ];
        $comments = $this->_model->find($options);
        $comments_by_id = [];
        foreach ($comments as $comment) {
            $comments_by_id[$comment->id] = $comment;
        }
        return $comments_by_id;

    }

    /**
     * Approbation d'un commentaire
     *
     * @param integer $id Identifiant du commentaire
     *
     * @return string Message d'état
     */
    public function approve($id = 0)
    {
        $message = "Impossible de changer l'état de ce commentaire";
        try {
            if (isset($_POST['ajax']) && $_POST['ajax']) {
                $data['id'] = $_POST['comment_id'];
                $data['abuse'] = 0;
                $this->_model->save($data);
                $message = 'Commentaire approuvé';
            }
        } catch (\Exception $ex) {
            $message = $ex->getMessage();
        }
        $result = ['message' => $message];
        return $result;
    }

    /**
     * Supprime un commentaire et tous ceux en dessous
     *
     * @param array $data Données
     *
     * @return array Message
     */
    public function remove($data)
    {
        $message = "Impossible de supprimer ce commentaire";
        try {
            if (isset($data['ajax']) && $data['ajax']) {
                // Récupération du commentaire pour
                // avoir le parent_id
                $options = [
                    'type' => 'one',
                    'conditions' => [
                        'id' => $data['comment_id']
                    ]
                ];
                $comment = $this->_model->find($options);
                if (!$comment) {
                    throw new \Exception("Impossible de trouver le commentaire", 9000);
                }
                $parent_id = $comment->parent_id;
                $depth = $comment->depth;

                $this->_model->delete($data['comment_id']);

                // Mis à jour des commentaires en dessous pour
                // les remonter d'un niveau
                $sql = 'UPDATE comment SET parent_id = :parent_parent_id, depth = :depth WHERE parent_id = :parent_id';
                $keys = [
                    ':parent_parent_id' => $parent_id,
                    ':depth' => $depth,
                    ':parent_id' => $data['comment_id']
                ];
                $this->_model->sql($sql, $keys);
                $message = 'Commentaire supprimé';
            }
        } catch (\Exception $ex) {
            $message = $ex->getMessage();
        }
        return(['message' => $message]);
    }

    /**
     * Signale un commentaire abusif
     *
     * @param array $data Données
     *
     * @return array Message
     */
    public function setAbuse($data)
    {

        try {
            $message = 'Nous ne pouvons transmettre votre demande à l\'administrateur';
            if (isset($data['ajax']) && $data['ajax'] && isset($data['comment_id']) && !empty($data['comment_id'])) {
                $setData['abuse'] = true;
                $setData['id'] = $data['comment_id'];
                $abuseComment = $this->_model->find(
                    [
                        'type' => 'one',
                        'conditions' => [
                        'id' => $setData['id']
                    ]
                ]
                );
                if ($this->_model->save($setData)) {
                    Mail::sendAbuseNotification($abuseComment);
                    $message = 'Votre demande a été transmise à l\'administrateur du site';
                }
            }
        } catch (\Exception $ex) {
            $message = $ex->getMessage();
        }
        return(['message' => $message]);
    }

    /**
     * Ajout d'un commentaire
     *
     * @param array $data données
     *
     * @return array Message
     */
    public function add($data)
    {
        try {
            if (isset($data['ajax']) && $data['ajax']) {
                unset($data['ajax']);
                $data['depth'] = 0;
                // Recherche de la profondeur
                $options = [
                    'type' => 'one',
                    'conditions' => [
                        'id' => $data['parent_id']
                    ]
                ];
                if (isset($data['parent_id'])) {
                    $c = $this->_model->find($options);
                    if (isset($c->depth)) {
                        $data['depth'] = $c->depth + 1;
                    }
                }
                $this->_model->save($data);
                $message = 'Merci pour votre commentaire';
            }
        } catch (\Exception $ex) {
            $message = $ex->getMessage();
        }
        return(['message' => $message]);
    }
}
