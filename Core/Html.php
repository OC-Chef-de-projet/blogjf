<?php

namespace Core;

class Html
{

	public function __construct(){
	}

	public function js($file){
		$html = '';
		$path = dirname($_SERVER['SCRIPT_NAME']);
		if(file_exists(ROOT.'/App/www/js/'.$file.'.js')){
			$html = '<script type="text/javascript" src="'.$path.'/js/'.$file.'.js"></script>'."\n";
		}
		echo $html;
        }
	public function css($file){
		$html = '';
		$path = dirname($_SERVER['SCRIPT_NAME']);
		if(file_exists(ROOT.'/App/www/css/'.$file.'.css')){
			$html = '<link rel="stylesheet" type="text/css" href="'.$path.'/css/'.$file.'.css"/>'."\n";
		}
		echo $html;
        }

	public function link($text,$url){
		echo '<a href="'.$url.'">'.$text.'</a>';
	}

	public function rewrite($string){
        $speciaux = array('?','!','@','#','%','&amp;','*','(',')','[',']','=','+',' ',';',':','\'','.','_');
        $string = str_replace($speciaux, "-", $string);
        $string = $this->removeAccents($string);
        $string = strtolower(strip_tags($string));
        return $string;

	}
	private function removeAccents($str, $encoding='utf-8') {
		// transformer les caractères accentués en entités HTML
		$str = htmlentities($str, ENT_NOQUOTES, $encoding);

		// remplacer les entités HTML pour avoir juste le premier caractères non accentués
		// Exemple : "&ecute;" => "e", "&Ecute;" => "E", "Ã " => "a" ...
		$str = preg_replace('#&([A-za-z])(?:acute|grave|cedil|circ|orn|ring|slash|th|tilde|uml);#', '\1', $str);

		// Remplacer les ligatures tel que : Œ, Æ ...
		// Exemple "Å“" => "oe"
		$str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str);
		// Supprimer tout le reste
		$str = preg_replace('#&[^;]+;#', '', $str);
		// Supprimer les espaces
		$str = preg_replace('/\s/', '-', $str);

		return $str;
	}
}

