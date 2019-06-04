<?php
class BookManager
{
    protected static $_db; // Instance de PDO
    protected $inventory;
    protected $query;


    public function __construct($modelName,$method)
    {
       
        self::setDb('');
        
    }

       public function getBooks()
    {
        print_r('Appel setDb depuis getBooks' . '</br>');
        self::setDb('');

        print_r('lancement qry depuis ' . __METHOD__ . '</br>');
        try
        { 
            $_db = new PDO("mysql:host=localhost;dbname=jfrblog;chartset='utf8'","root","",
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
            $query = "SET NAMES utf8"; // force affichghe en UTF
            $result = $_db->query($query);
            $qry= 'SELECT * FROM book order by id';       
            $pdoStat = $_db->query($qry);  // retour objet PDO statement
            $this->inventory = $pdoStat->fetchALL(); 
            return $this->inventory;
        }
        catch (PDOException $e)
        {
            die('Erreur : ' . $e->getMessage()) . 'probleme PDO dans ' . __METHOD__ . '</br>';
        }
    }

   
    private static function setDb($qry)
    {
        try
        { 
         //   $_db = new PDO(DSN,USR,PWD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
            $_db = new PDO("mysql:host=localhost;dbname=jfrblog;chartset=UTF8","root","",
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
              // $bdd = new PDO("mysql:host=localhost;dbname=bookyshin;chartset=UTF8","root","",

            $query = "SET NAMES utf8"; // force affichghe en UTF
            $result = $_db->query($query);
            print_r('ok pour utf8' .' </br>');   

        }
        catch (PDOException $e)
        {
            die('Erreur : ' . $e->getMessage()) . 'probleme PDO';
        }
    }
}