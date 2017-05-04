<?php
/**
 * Création mot de passe
 *
 * PHP Version 5.6
 *
 * @category Core
 * @package  Core
 * @author   Pierre-Sylvain Augereau <ps.augereau@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://blogjs.lignedemire.eu
 */

if (!isset($argv[1]) |- empty($argv[1])) {
    echo 'Usage: php -f '.$argv[0].' mot_de_passe'."\n";
} else {
	$password = $argv[1];
	$new_password = password_hash($password, PASSWORD_DEFAULT, [ 'cost' => 12]);
	echo "UPDATE user SET password = '$new_password' WHERE id = 1";
}
