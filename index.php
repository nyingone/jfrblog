<?php
define('DS', DIRECTORY_SEPARATOR);
// $root = $_SERVER['DOCUMENT_ROOT'];
define('ROOT', $_SERVER['DOCUMENT_ROOT'] . DS . 'jfrblog' . DS);
define('APP', ROOT . 'App'. DS);

include_once(APP . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'config.php');
if(isset($_POST['url']))
{
    $url = $_POST['url'];
}else{
    if(isset($_GET['url']))
    {
        $url = $_GET['url'];
    }else{
   
        $url = 'home';
    }
}
$router = new Router ($url);
$router->get('home', "home#index",'home');
$router->get('aboutJFR',"home#aboutJFR",'aboutUs');

$router->get('book',"book#index",'book');
$router->get('book-show/:ref',"book#show",'book_show');
$router->get('book-list',"book#list",'book_list');
$router->get('book/:id', "book#edit",'book_edit');
$router->post('book/:id', "book#maj",'book_maj');

$router->get('movie',"movie#index",'movie');

$router->get('episode/:ref',"episode#index",'episodes');
$router->get('episode-show/:ref',"episode#show",'episode_show');
$router->get('episode-edit/:ref',"episode#edit",'episode_edit');
$router->post('episode/:ref', "episode#maj",'episode_maj');
// $router->post('episode-edit/:ref',"episode#maj",'episode-p-maj');;

$router->post('comment/:ref',"comment#maj",'comment_maj');
$router->get('comment-gest/:ref',"comment#gest",'comment_gest');
$router->post('comment-signal/:ref',"comment#signal",'comment_signal');
$router->get('comment/:ref',"comment#index",'comments');
// $router->post('comment-index/:ref',"comment#index",'comment_index');

$router->get('login',"user#login",'login');
$router->get('register',"user#register",'register');
$router->post('user-login',"user#connect",'connect');

$router->post('movie', "movie#index",'movie');


// var_dump($router);
try
{
    
    $router->run();
   
}
catch(RouterException $e)
{
    $errmsg[] =$e->getMessage();
}
catch(Exception $e)
{
    $errmsg[] =$e->getMessage();
}
if(isset($errmsg) && (!empty($errmsg)))
{
    var_dump($errmsg);
}








