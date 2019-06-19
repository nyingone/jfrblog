<?php
session_start();

ini_set('display-errors', 'on');
error_reporting(E_ALL);

      /* ROOT et APP défini via index
      */
      define ('HOME','http://localhost/jfrblog/');
      define('MODEL', APP . 'model' . DIRECTORY_SEPARATOR);
      define('MANAGER', MODEL . 'manager' . DIRECTORY_SEPARATOR);
      define('ENTITY', MODEL . 'entity' . DIRECTORY_SEPARATOR);
      define('VIEW', APP . 'view' . DIRECTORY_SEPARATOR);
      define('CONTROLLER', APP . 'controller' . DIRECTORY_SEPARATOR);
      define('CORE', APP . 'core' . DIRECTORY_SEPARATOR);
      define('DATA', APP . 'data' . DIRECTORY_SEPARATOR);
      define('CLASSX', APP . 'class' . DIRECTORY_SEPARATOR);
      define('ROUTER', APP . 'router' . DIRECTORY_SEPARATOR);

      define('HOST', $_SERVER['REQUEST_SCHEME'] . DS . $_SERVER['HTTP_HOST'] . DS . 'jfrblog' . DS);
      define('CSS', HOST. 'css' . DS);
// var_dump(HOST, ROOT, HOME);
      $modules = [ROOT,ROUTER,APP,CORE,CONTROLLER,MODEL,DATA,CLASSX, MANAGER, ENTITY];

      set_include_path(get_include_path() . PATH_SEPARATOR . implode(PATH_SEPARATOR,$modules));
      spl_autoload_register('spl_autoload',false);
      
    //var_dump(get_include_path());

    // modele ini.php
    // define ('DSN', '"mysql:host=localhost;dbname=jfrblog;chartset=UTF8"');
    // define('USR',  'root');
    // define('PWD', ''); 

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