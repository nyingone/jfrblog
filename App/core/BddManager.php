<?php
class BddManager
{
    private $_db; // Instance de PDO
    protected $bdd;
    protected $inventory = [];
    protected $query;


    public function __construct($modelName,$method,$request)
    {
        try
        { 
            $_db = new PDO(DSN,USR,PWD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
              // $bdd = new PDO("mysql:host=localhost;dbname=bookyshin;chartset=UTF8","root","",
            $this->_db = $_db;

            $query = "SET NAMES utf8"; // force affichghe en UTF
            $result = $_db->query($query);
            print_r('try PDO utf8 ok');
            
            if (method_exists($this, $method))
            {
                // 
                $query = $request;
                var_dump($method); var_dump($query);die;
                $this->$method(''); 
            }else
            {
                echo('ras sur action ' . $method);
            } 
        var_dump($this);
        }
        catch (PDOException $e)
        {
            die('Erreur : ' . $e->getMessage());
        }
    }

   private function load($query)
    {
       //  $req = $this->_db->prepare($query);      prepare() on null in
        //$result = $this->_db->query($query);
        /*
        $result = $_db->query($query);
        $result = $req->execute;
        var_dump($result);
        $this->inventory = $result->fetchAll();
*/
   //     $req = $this->_db->prepare($query);
        $pdoStat = $_db->query($query);  // retour objet PDO statement
        $inventory = $pdoStat->fetchALL();
        
        /*$inventory = array();
        while ($row = $req->fetch(PDO::FETCH_ASSOC))
        {
            $inventory[] = $row;            // Tableau d'enregistrements
        };
        return $inventory; */
    }
   public function getInventory($query)
    {
        $this->load($query);
        return $this->inventory;
    }

    public function setDb(PDO $db)
    {
      $this->_db = $db;
    }
}