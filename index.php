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
        if(Session::get('redirect') !== null):
            $url = Session::get('redirect');
        else:   
            $url = 'home';
        endif;
    }
}

$router = new Router ($url);
$router->get('home', "home#index",'home');
$router->get('aboutJFR',"home#aboutJFR",'aboutUs');


$router->get('book-show/:ref',"book#show",'book_show');
$router->get('book-list',"book#list",'book_list');

$router->get('episode-show/:ref',"episode#show",'episode_show');

// $router->get('comment/:id', "comment#edit",'comment_edit');
$router->post('comment/:ref',"comment#maj",'comment_maj');
$router->post('comment-signal/:ref',"comment#signal",'comment_signal');

$router->get('login',"user#login",'login');
$router->get('logout',"user#logout",'logout');
$router->get('register',"user#register",'register');
$router->post('user-login',"user#connect",'connect');
$router->post('user/:ref', "user#maj",'user_maj'); 


if(ADMIN) :
    $router->get('book',"book#index",'book');
    $router->get('book/:id', "book#edit",'book_edit');
    $router->post('book/:id', "book#maj",'book_maj');

    $router->get('episode/:ref',"episode#index",'episodes');
    $router->get('episode-edit/:ref',"episode#edit",'episode_edit');
    $router->post('episode/:ref', "episode#maj",'episode_maj');     

    $router->get('comment/:ref',"comment#index",'comments');
    $router->get('comment-gest/:ref',"comment#gest",'comment_gest');
  
endif;


try
{
    
    $router->run();
   
}
catch(RouterException $e)
{
    $errmsg[] =$e->getMessage();
    header("Location: ". HOME );
}
catch(Exception $e)
{
    $errmsg[] =$e->getMessage();
}







