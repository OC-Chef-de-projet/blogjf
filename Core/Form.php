<?php
/**
 * Form
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
 * Affichage des Formes Html
 *
 * @category Core
 * @package  Core
 * @author   Pierre-Sylvain Augereau <ps.augereau@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://blogjs.lignedemire.eu
 */
class Form extends View
{

    public $viewAction;
    private $mode = 'index';
    private $model = null;

    /**
     * __construct
     *
     * @param string $mode Nom de l'action
     */
    public function __construct($mode = 'index')
    {
        $this->mode = $mode;
    }

    /**
     * Creation de la balise <form>
     *
     * @param string $form nom
     *
     * @return string
     */
    public function create($form)
    {
        $action = debug_backtrace()[2]['object']->viewAction;

        $html = '';
        if ($this->mode == 'index') {
            $url = $_SERVER['REQUEST_URI'];
            $html = '<form action="'.$url.'" id="'.$form.$action.'Form" method="POST" accept-charset="utf-8">'."\n";
        }
        if ($this->mode == 'rewrite') {
            $html = '<form action="'.$form.'/'.$action.'" id="'.$form.$action.'Form" method="POST" accept-charset="utf-8">'."\n";
        }
        $this->model = $form;
        return $html;
    }

    /**
     * Creation des champs de type input
     *
     * @param array $field définition du champ
     *
     * @return string
     */
    public function input($field)
    {
        $html = '';

        $id = $this->model.ucwords($field['field']);

        if (isset($field['label']) && !empty($field['label'])) {
            $html .= '<label for="'.$id.'">'.$field['label'].'</label>'."\n";
        }

        $required = '';
        if (isset($field['required']) && !empty($field['required'])) {
            $required = 'required=""';
        }

        $value = '';
        if (isset($field['value'])) {
            $value = $field['value'];
        }

        $class = '';
        if (isset($field['class'])) {
            $class = 'class="'.$field['class'].'"';
        }

        $placeholder = '';
        if (isset($field['placeholder'])) {
            $placeholder = 'placeholder="'.$field['placeholder'].'"';
        }

        if ($field['type'] == 'textarea') {
            $html .= '<textarea class="tiny" name="'.$field['field'].'"  id="'.$id.'" '.$required.'>'.$value.'</textarea>'."\n";
        } else {
            if ($value) {
                $text_value = 'value="'.htmlspecialchars($value).'"';
            } else {
                $text_value = '';
            }
            $html .= '<input name="'.$field['field'].'"  type="'.$field['type'].'" id="'.$id.'" '.$required.' '.$text_value.' '.$class.' '.$placeholder.' />'."\n";
        }
        return $html;
    }

    /**
     * Fin de la forme
     *
     * @param array $field Definition du champ
     *
     * @return string
     */
    public function end($field)
    {
        $html = '';
        $class = '';
        if (isset($field['class'])) {
            $class = 'class="'.$field['class'].'"';
        }
        $html .= '<input type="submit" value="'.$field['value'].'" '.$class.'/>'."\n";
        $html .= '</form>'."\n";
        return($html);
    }

}

