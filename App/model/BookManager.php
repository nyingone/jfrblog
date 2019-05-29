<?php
class BookManager
{
    private $_db; // Instance de PDO
    public $inventory;
    protected $query;


    public function __construct($modelName,$method)
    {
        try
        { 
         //   $_db = new PDO(DSN,USR,PWD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
            $_db = new PDO("mysql:host=localhost;dbname=jfrblog;chartset=UTF8","root","",
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
              // $bdd = new PDO("mysql:host=localhost;dbname=bookyshin;chartset=UTF8","root","",
            $this->_db = $_db;

            $query = "SET NAMES utf8"; // force affichghe en UTF
            $result = $_db->query($query);
            print_r('try PDO utf8 ok');
            var_dump ('</br>' ,DSN );

            if (method_exists($this, $method))
            {
                $this->$method($_db); 
               // return $inventory; ne connait plus la variable
               return $this;
            }else
            {
                echo('ras sur action ' . $method);
            } 
        }
        catch (PDOException $e)
        {
            die('Erreur : ' . $e->getMessage()) . 'probleme PDO';
        }
        return $this;
    }

      
    public function findAll($_db)
    {
        $query= "SELECT * FROM book order by id";
        $pdoStat = $_db->query($query);  // retour objet PDO statement
    
        $inventory = $pdoStat->fetchALL(); 
        $this->inventory = $pdoStat->fetchALL(); 
        var_dump($inventory);  
        
        var_dump('côté manager: ' , '</br>' , $this);
        $this->inventory = $inventory;
        var_dump($this); 
        return $inventory;
    }
}