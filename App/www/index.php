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


$router->get('/Test',['controller' => 'Episode', 'action' => 'test']);


// Administrateur
$router->get('/Admin/',['controller' => 'Admin', 'action' => 'index']);
$router->get('/Episode/add',['controller' => 'Episode', 'action' => 'add']);
$router->post('/Episode/add',['controller' => 'Episode', 'action' => 'add']);
$router->get('/Episode',['controller' => 'Episode', 'action' => 'index']);
$router->get('/Episode/edit/:id',['controller' => 'Episode', 'action' => 'edit']);
$router->post('/Episode/edit/:id',['controller' => 'Episode', 'action' => 'edit']);

/*
$router->get('/sommaire',['controller' => 'Accueil', 'action' => 'index']);
$router->get('/Accueil/index',['controller' => 'Accueil', 'action' => 'index']);
$router->get('/Accueil',['controller' => 'Accueil', 'action' => 'index']);

$router->get('/chapitre/:id-:slug',['controller' => 'Article', 'action' => 'view']);

// Administration
$router->get('/Article/view/:id/:cmtid',['controller' => 'Article', 'action' => 'view']);
$router->get('/Article/view/:id',['controller' => 'Article', 'action' => 'view']);

$router->get('/Article',['controller' => 'Article', 'action' => 'index']);
$router->get('/Article/index',['controller' => 'Article', 'action' => 'index']);


$router->get('/Article/edit/:id',['controller' => 'Article', 'action' => 'edit']);
$router->post('/Article/edit/:id',['controller' => 'Article', 'action' => 'edit']);

$router->get('/Article/add',['controller' => 'Article', 'action' => 'add']);
$router->post('/Article/add',['controller' => 'Article', 'action' => 'add']);


$router->get('/Article/delete/:id',['controller' => 'Article', 'action' => 'delete']);
$router->post('/Article/delete/:id',['controller' => 'Article', 'action' => 'delete']);


$router->get('/Admin/',['controller' => 'Admin', 'action' => 'index']);
$router->get('/Admin/index',['controller' => 'Admin', 'action' => 'index']);


// Fonctions internes
$router->post('/AbusiveComment',['controller' => 'Comment', 'action' => 'setAbuse']);
$router->post('/addComment',['controller' => 'Comment', 'action' => 'add']);
$router->post('/approveComment',['controller' => 'Comment', 'action' => 'approve']);
$router->post('/removeComment',['controller' => 'Comment', 'action' => 'remove']);
$router->post('/Article/getChapters',['controller' => 'Article', 'action' => 'getChapters']);
*/

$router->run();

