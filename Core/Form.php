<?php

namespace Core;

class Form extends View
{

	public $viewAction;
	private $mode = 'index';
	private $model = null;

	public function __construct($mode = 'index'){
		$this->mode = $mode;
	}

	public function create($form){


		$action = debug_backtrace()[2]['object']->viewAction;

		$html = '';
		if($this->mode == 'index'){
			$url = $_SERVER['REQUEST_URI'];
			$html = '<form action="'.$url.'" id="'.$form.$action.'Form" method="POST" accept-charset="utf-8">'."\n";
		}
		if($this->mode == 'rewrite'){
			$html = '<form action="'.$form.'/'.$action.'" id="'.$form.$action.'Form" method="POST" accept-charset="utf-8">'."\n";
		}
		$this->model = $form;
		echo $html;
        }

	public function input($field){
		$id = $this->model.ucwords($field['field']);

		if(isset($field['label']) && !empty($field['label'])){
			echo '<label for="'.$id.'">'.$field['label'].'</label>'."\n";
		}

		$required = '';
		if(isset($field['required']) && !empty($field['required'])){
			$required = 'required=""';
		}

		$value = '';
		if(isset($field['value'])){
			$value = $field['value'];
		}

		$class = '';
		if(isset($field['class'])){
			$class = 'class="'.$field['class'].'"';
		}

		$placeholder = '';
		if(isset($field['placeholder'])){
			$placeholder = 'placeholder="'.$field['placeholder'].'"';
		}


		if($field['type'] == 'textarea'){
			echo '<textarea class="tiny" name="'.$field['field'].'"  id="'.$id.'" '.$required.'>'.$value.'</textarea>'."\n";
		} else {

			if($value){
				$text_value = 'value="'.htmlspecialchars($value).'"';
			} else {
				$text_value = '';
			}
			echo '<input name="'.$field['field'].'"  type="'.$field['type'].'" id="'.$id.'" '.$required.' '.$text_value.' '.$class.' '.$placeholder.' />'."\n";
		}
	}

	public function end($field){
		$class = '';
		if(isset($field['class'])){
			$class = 'class="'.$field['class'].'"';
		}
		echo '<input type="submit" value="'.$field['value'].'" '.$class.'/>'."\n";
		echo '</form>'."\n";
	}

}

