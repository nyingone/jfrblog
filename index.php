<?php
define('DS', DIRECTORY_SEPARATOR);
// $root = $_SERVER['DOCUMENT_ROOT'];
define('ROOT', $_SERVER['DOCUMENT_ROOT'] . DS . 'jfrblog' . DS);
define('APP', ROOT . 'App'. DS);
define('HOME', ROOT . 'public'. DS);

include_once(APP . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'config.php');

new Application;

//
$users = DB::getInstance(); // lance connection
$users = DB::getInstance()->query('SELECT * FROM user');
// $users = DB::getInstance()->get('user', array('pseudo', '=', 'alex'));
if($users->error())
{
echo 'Erreur accès table User';
}else{
    if(!$users->count())
    {
        echo 'No user found';
    }else{
        foreach($users->results() as $user)
        {
            echo $user->userId, $user->email;
        }
    }
    
}

// SELECT `id``userId``userId``passWord``salt``email``lastName``pseudo``joigned``groupId` 
echo 'Appel pour insert';
$userInsert = DB::getInstance()->insert('user', array(
    'id'    => null,
    'userId' => 'alex',
    'password' => 'xxx',
    'salt' => 'salt',
    'email' => 'alex@gmail.com',
    'lastName' => 'Thunderbird',
    'pseudo'   =>   '',
    'joigned'  =>   '191231',  
    'groupId' => '10'
    ));






