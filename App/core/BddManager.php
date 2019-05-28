<?php
class BddManager
{
    protected $bdd;
    protected $inventory = [];


    public function __construct()
    {
        try
        { 
            $bdd = new PDO(DSN,USR,PWD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
              // $bdd = new PDO("mysql:host=localhost;dbname=bookyshin;chartset=UTF8","root","",
            $this->bdd = $bdd;

            $query = "SET NAMES utf8"; // force affichghe en UTF
            $result = $bdd->query($query);

            
        }
        catch (PDOException $e)
        {
        // die ('Erreur : ' $e->getMessage());
        }
    }

   private function load()
    {
        $req = $this->bdd->prepare($query);
        $result = $req->execute;
        var_dump($result);
        $this->inventory = $result->fetchAll();
    }

   public function getInventory($query,$objName)
    {
        $this->load();
        return $this->inventory;
    }


}