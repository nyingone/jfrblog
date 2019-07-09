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
$router->get('book/:id', "book#edit",'book_detail');
$router->post('book/:id', "book#maj",'book_maj');

$router->get('movie',"movie#index",'movie');

$router->get('episode/:ref',"episode#index",'episodes');
$router->get('episode-show/:ref',"episode#show",'episode_show');
$router->get('episode-edit/:ref',"episode#edit",'episode_edit');
$router->post('episode/:ref', "episode#maj",'episode_maj');
// $router->post('episode-edit/:ref',"episode#maj",'episode-p-maj');;

$router->get('login',"user#login",'login');
$router->get('register',"user#register",'register');

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








