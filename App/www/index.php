<?php
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

Core\Session::getInstance()->write('test','12345');

$router = new Core\Router($_GET['url']);



$router->get('/',['controller' => 'Accueil', 'action' => 'index']);
$router->get('/resume/:id',['controller' => 'Accueil', 'action' => 'index']);

$router->get('/Episode/:id-:slug',['controller' => 'Episode', 'action' => 'view']);
$router->post('/Commenter',['controller' => 'Comment', 'action' => 'add']);
$router->post('/CommentaireAbusif',['controller' => 'Comment', 'action' => 'setAbuse']);

$router->post('/Episode/navEpisode',['controller' => 'Episode', 'action' => 'navEpisode']);
$router->post('/Episode/getEpisodesTitle',['controller' => 'Episode', 'action' => 'getEpisodesTitle']);


$router->get('/Biographie',['controller' => 'Biographie', 'action' => 'index']);
$router->get('/Projet',['controller' => 'Page', 'action' => 'projet']);


$router->get('/Logout',['controller' => 'User', 'action' => 'logout']);


// Administrateur
$router->get('/Login',['controller' => 'User', 'action' => 'login']);
$router->post('/Login',['controller' => 'User', 'action' => 'login']);
$router->get('/Admin/',['controller' => 'Admin', 'action' => 'index']);
$router->get('/Episode/add',['controller' => 'Episode', 'action' => 'add']);
$router->post('/Episode/add',['controller' => 'Episode', 'action' => 'add']);
$router->get('/Episode',['controller' => 'Episode', 'action' => 'index']);
$router->get('/Episode/edit/:id',['controller' => 'Episode', 'action' => 'edit']);
$router->post('/Episode/edit/:id',['controller' => 'Episode', 'action' => 'edit']);


$router->run();

