<?php
session_start();
$_session['user'] = 'Anonymous';

/**
 * 
 */
ini_set('display-errors', 'on');
error_reporting(E_ALL);

      /* ROOT et APP défini via index
      */
      define('MODEL', APP . 'model' . DIRECTORY_SEPARATOR);
      define('VIEW', APP . 'view' . DIRECTORY_SEPARATOR);
      define('CONTROLLER', APP . 'controller' . DIRECTORY_SEPARATOR);
      define('CORE', APP . 'core' . DIRECTORY_SEPARATOR);

      /**
       * CSS accédé via adresse url ??? 
       */
      // define('CSS', ROOT . 'public'. DS . 'css' . DS);
      

      define('HOST', $_SERVER['REQUEST_SCHEME'] . DS . $_SERVER['HTTP_HOST'] . DS . 'jfrblog' . DS);

      define('CSS', HOST. 'css' . DS);

      // $bdd = new PDO('"mysql:host =' . $lh . ';dbname =' . $dba . ';charset = UTF8","' . $us . '","'. $pw' . '"')}
     // var_dump($_SERVER);
      define ('DSN', 'mysql:host=localhost;dbname = jfrblog');
      define('USR',  'root');
      define('PWD', ''); 

      $modules = [ROOT,APP,CORE,CONTROLLER,MODEL];

      set_include_path(get_include_path() . PATH_SEPARATOR . implode(PATH_SEPARATOR,$modules));
      spl_autoload_register('spl_autoload',false);
      
    //var_dump(get_include_path());

 /*
      class MyAutoload
      {
          public static function start()
          {
              spl_autoload_register(array(__CLASS__, 'autoload'));
    
           /**
        }
        public static function autoload($class)
        {

        }
    }
    */