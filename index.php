<?php
define('DS', DIRECTORY_SEPARATOR);
// $root = $_SERVER['DOCUMENT_ROOT'];
define('ROOT', $_SERVER['DOCUMENT_ROOT'] . DS . 'jfrblog' . DS);
define('APP', ROOT . 'App'. DS);
define('HOME', ROOT . 'public'. DS);

include_once(APP . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'config.php');

if(isset($_GET['url']))
{
    $url = $_GET['url'];
}else{
    if(isset($_POST['url']))
    {
        $url = $_POST['url'];
    }else{
        $url = 'home';
    }
}
$router = new Router ($url);
$router->get('home', "home#index",'home');
$router->get('aboutJFR',"home#aboutJFR",'aboutUs');
$router->get('book',"book#index",'book');
$router->get('book-add',"book#add",'book_add');
$router->get('movie',"movie#index",'movie');
$router->get('episode',"episode#index",'episode');

$router->get('login',"user#login",'login');
$router->get('register',"user#register",'register');

// $router->get('book/:id', function($id){echo 'livre' . $id;});
 $router->get('book/:id', "book#edit",'book_detail');
// $router->get('episode/:id-:slug', function($id,$slug){echo "episode $id : $slug";})->with('id', '[0-9]+')->with('slug', '[a-z\-0-9]+');

$router->post('movie', "movie#index",'movie');
$router->post('book/:id', function($id){echo 'poster pour 1 livre';});
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








