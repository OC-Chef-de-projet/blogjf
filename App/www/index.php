<?php
/**
 * Point d'entrée du site
 *
 * PHP Version 5.6
 *
 * @category App
 * @package  App\www
 * @author   Pierre-Sylvain Augereau <ps.augereau@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://blogjs.lignedemire.eu
 */

if (!defined('DS')) {
        define('DS', DIRECTORY_SEPARATOR);
}

if (!defined('ROOT')) {
        define('ROOT', dirname(dirname(dirname(__FILE__))));
}

if (!defined('APP_DIR')) {
        define('APP_DIR', basename(dirname(dirname(__FILE__))));
}

if (!defined('WEBROOT_DIR')) {
        define('WEBROOT_DIR', basename(dirname(__FILE__)));
}
if (!defined('WWW_ROOT')) {
        define('WWW_ROOT', dirname(__FILE__) . DS);
}


// Autoloader Composer
require __DIR__ . '/../../vendor/autoload.php';
Core\Session::getInstance();
Core\Config::getInstance();

// Definition des objets métier
Core\Service::getInstance()['Episode'] = function ($c) {
    return new \App\Lib\Episode();
};
Core\Service::getInstance()['Comment'] = function ($c) {
    return new \App\Lib\Comment();
};

$router = new Core\Router($_GET['url']);
$router->get('/', ['controller' => 'Accueil', 'action' => 'index']);

// Résumé
$router->get('/resume/:id', ['controller' => 'Accueil', 'action' => 'index']);
$router->get('/resume/:id-:slug', ['controller' => 'Accueil', 'action' => 'index']);

// Episode
$router->get('/Episode/:id-:slug', ['controller' => 'Episode', 'action' => 'view']);
$router->post('/Episode/getListOfTitles', ['controller' => 'Episode', 'action' => 'getListOfTitles']);

$router->get('/Episode', ['controller' => 'Episode', 'action' => 'index']);
$router->get('/Episode/index', ['controller' => 'Episode', 'action' => 'index']);

$router->get('/Episode/add', ['controller' => 'Episode', 'action' => 'add']);
$router->get('/Episode/edit/:id', ['controller' => 'Episode', 'action' => 'edit']);
$router->get('/Episode/delete/:id', ['controller' => 'Episode', 'action' => 'delete']);

$router->post('/Episode/edit/:id', ['controller' => 'Episode', 'action' => 'edit']);
$router->post('/Episode/add', ['controller' => 'Episode', 'action' => 'add']);


$router->post('/Commenter', ['controller' => 'Comment', 'action' => 'add']);
$router->post('/CommentaireAbusif', ['controller' => 'Comment', 'action' => 'setAbuse']);


$router->get('/Biographie', ['controller' => 'Biographie', 'action' => 'index']);
$router->get('/Projet', ['controller' => 'Page', 'action' => 'projet']);

$router->get('/Logout', ['controller' => 'User', 'action' => 'logout']);

// Administrateur
$router->get('/Login', ['controller' => 'User', 'action' => 'login']);
$router->post('/Login', ['controller' => 'User', 'action' => 'login']);
$router->get('/Admin/', ['controller' => 'Admin', 'action' => 'index']);

$router->post('/ApproveComment', ['controller' => 'Comment', 'action' => 'approve']);
$router->post('/RemoveComment', ['controller' => 'Comment', 'action' => 'remove']);

$router->run();

