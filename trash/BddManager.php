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