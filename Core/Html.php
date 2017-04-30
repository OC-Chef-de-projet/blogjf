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
 * Affichage Html
 *
 * @category Core
 * @package  Core
 * @author   Pierre-Sylvain Augereau <ps.augereau@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://blogjs.lignedemire.eu
 */
class Html
{
    /**
     * Ajout d'un fichier javascript
     *
     * @param string $file Nom du fichier
     *
     * @return string
     */
    public function js($file)
    {
        $html = '';
        $path = dirname($_SERVER['SCRIPT_NAME']);
        if (file_exists(ROOT.'/App/www/js/'.$file.'.js')) {
            $html = '<script type="text/javascript" src="'.$path.'/js/'.$file.'.js"></script>'."\n";
        }
        return $html;
    }

    /**
     * Ajout d'un fichier css
     *
     * @param string $file Nom du fichier
     *
     * @return string
     */
    public function css($file)
    {
        $html = '';
        $path = dirname($_SERVER['SCRIPT_NAME']);
        if (file_exists(ROOT.'/App/www/css/'.$file.'.css')) {
            $html = '<link rel="stylesheet" type="text/css" href="'.$path.'/css/'.$file.'.css"/>'."\n";
        }
        return $html;
    }

    /**
     * Création d'une balise <a>
     *
     * @param string $text Texte
     * @param string $url  URL
     *
     * @return string
     */
    public function link($text,$url)
    {
        return '<a href="'.$url.'">'.$text.'</a>';
    }

    /**
     * Création d'une URL pour la redirection
     *
     * @param string $string Nom
     *
     * @return string
     */
    public static function rewrite($string)
    {
        $speciaux = array('?', '!', '@', '#', '%', '&amp;', '*', '(', ')', '[', ']', '=', '+', ' ', ';', ':', '\'', '.', '_');
        $string = str_replace($speciaux, "-", $string);
        $string = self::removeAccents($string);
        $string = strtolower(strip_tags($string));
        return $string;
    }

    /**
     * Suppression des caractères accentués
     *
     * @param string $str      Chaine de caractères
     * @param string $encoding Type d'encodage
     *
     * @return string
     */
    private static function removeAccents($str, $encoding='utf-8')
    {
        // Transformer les caractères accentués en entités HTML
        $str = htmlentities($str, ENT_NOQUOTES, $encoding);

        // Remplacer les entités HTML pour avoir juste le premier caractères non accentués
        $str = preg_replace('#&([A-za-z])(?:acute|grave|cedil|circ|orn|ring|slash|th|tilde|uml);#', '\1', $str);

        // Remplacer les ligatures tel que : Œ, Æ ...
        $str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str);

        // Supprimer tout le reste
        $str = preg_replace('#&[^;]+;#', '', $str);

        // Supprimer les espaces
        $str = preg_replace('/\s/', '-', $str);

        return $str;
    }
}

