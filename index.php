<?php
var_dump($_GET);
/*
$url = '';
if(isset($_GET['url']))
{
    $url = explode('/', $_GET['url']);
}
var_dump($url);
if($url == '')
{
    echo "Page d'accueil";  
}elseif($url[0] == 'book' AND !empty($url[1])) {
    echo "Artice n°" . $url[1];
}
die;
*/

define('DS', DIRECTORY_SEPARATOR);
// $root = $_SERVER['DOCUMENT_ROOT'];
define('ROOT', $_SERVER['DOCUMENT_ROOT'] . DS . 'jfrblog' . DS);
define('APP', ROOT . 'App'. DS);
define('HOME', ROOT . 'public'. DS);
// ??? defined('APPLICATION_PATH') || define('APPLICATION_PATH', (dirname(__FILE__) . '/../App'));
// var_dump(APP, '</br>', APPLICATION_PATH);

include_once(APP . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'config.php');
// MyAutoload::start();

new Application;
$users = DB::getInstance(); // lance connection
$users = DB::getInstance()->query('SELECT * FROM user');
if($users->error())
{
echo 'No user';
}else{
    echo 'Users found';
}

// $users = DB::getInstance()->get('users', array('username', '=', 'alex'));






