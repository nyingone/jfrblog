<?php
/**
* 
*/
class BddManager
{
    /**
     * @var
     */
    private $bdd;
    /**
     * @var retourne tableau fetch all PDO
     */
    protected $inventory = [];

    public function __construct()
    {
        try
        {
            
      // $_db = new PDO(DSN,USR,PWD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]); Erreur : could not find driver
        $bdd = new PDO("mysql:host=localhost;dbname=jfrblog;chartset=UTF8","root","",
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        }
        catch (PDOException $e)
        {
            die('Erreur : ' . $e->getMessage());
        }
        $this->bdd = $bdd;
    
        $query  = "SET NAMES utf8"; // force affichage en eUTF8
        $result = $bdd->query($query);
        if (!$result) die("Erreur fatale SET utf8");
    }
    /**
     * @param string $query
     * @return array $inventory
     */
    public function getInventory($query)
    {
        var_dump($query);
        $req = $this->bdd->prepare($query);
        $req->execute();
        $pdoStat = $this->bdd->query($query);  // retour objet PDO statement
            $this->inventory = $pdoStat->fetchALL(); 
            return $this->inventory;
    }
    /**
     * @param string $query
     * @param array  $valBind 
     */
    public function delItem($query, $objName)
    {
        $req = $this->bdd->prepare($query);
        $req->execute();
        if (!$req) die("Erreur Ã  la suppression.$objname");
    }

    public function addItem($query, $objName)
    {
        $req = $this->bdd->prepare($query);
        $req->execute();
        if (!$req) die("Erreur Ã  la mise Ã  jour.$objname");
    }

}