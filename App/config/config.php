<?php
session_start();
$_SESSION['id'] = session_id();
$_SESSION['spec'] = '*none';
if(isset($_SESSION['logged_in']))
{
    if($_SESSION['groupId'] >= "90") :
        define('ADMIN' , true);
        define('FRIEND' , false);
        $_SESSION['spec'] = '*all';
     else:
        define('ADMIN' , false);
        if($_SESSION['groupId'] >= "20") :
            define('FRIEND' , true);
            $_SESSION['friend'] = FRIEND;
            $_SESSION['spec'] = '*lvl';
        else:
            define('FRIEND' , false);
        endif;
    endif;
}else{
    define('ADMIN' , false);
    define('FRIEND' , false);
}
var_dump($_SESSION);

ini_set('display-errors', 'on');
error_reporting(E_ALL);

      /* ROOT et APP défini via index
      */
      define ('HOME','http://localhost/jfrblog/');
      define('MODEL', APP . 'model' . DIRECTORY_SEPARATOR);
      define('MANAGER', MODEL . 'manager' . DIRECTORY_SEPARATOR);
      define('ENTITY', MODEL . 'entity' . DIRECTORY_SEPARATOR);
      define('VIEW', APP . 'view' . DIRECTORY_SEPARATOR);
      define('USER', VIEW . 'user' . DIRECTORY_SEPARATOR);
      define('CONTROLLER', APP . 'controller' . DIRECTORY_SEPARATOR);
      define('CORE', APP . 'core' . DIRECTORY_SEPARATOR);
      define('DATA', APP . 'data' . DIRECTORY_SEPARATOR);
      define('CLASSX', APP . 'class' . DIRECTORY_SEPARATOR);
      define('ROUTER', APP . 'router' . DIRECTORY_SEPARATOR);
      define('IMG', HOME . 'img/');
      define('IMG125', IMG . 'min125/');
      define('IMG215', IMG . 'min215/');
   

      define('HOST', $_SERVER['REQUEST_SCHEME'] . DS . $_SERVER['HTTP_HOST'] . DS . 'jfrblog' . DS);
      define('CSS', HOST. 'css' . DS);
// var_dump(HOST, ROOT, HOME);
      $modules = [ROOT,ROUTER,APP,CORE,CONTROLLER,MODEL,DATA,CLASSX, MANAGER, ENTITY];

      set_include_path(get_include_path() . PATH_SEPARATOR . implode(PATH_SEPARATOR,$modules));
      spl_autoload_register('spl_autoload',false);
      
    

    $GLOBALS['config'] = array(
        'mysql'     => array(
            'host'      => 'localhost',
            'username'  =>  'root',
            'password'  =>  '',
            'dbname'    =>  'jfrblog'
    
        ),
        'remember'  => array(
            'cookie_name'    => 'hash',
            'cookie_expiry'  => 604800 // in second
        ),
        'session'   => array(
            'session_name'  =>  'user',
            'token_name'    =>  'token'
        )
    );
    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);
    require_once('functions/sanitize.php');