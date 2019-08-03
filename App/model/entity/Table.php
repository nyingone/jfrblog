<?php
// class Table implements arrayAcces
class Table 
{
    protected $zNames = [];

    public function __construct($dtas = [])
    {
        if(!empty($dtas) && is_array($dtas))
        {      
            $this->hydrate($dtas);
        }
    }
  
    public function hydrate(array $dtas)
    {
        foreach ($dtas as $key => $value)
        {
            $method = 'set' . ucfirst($key);
            if(method_exists($this, $method))
            {
                $this->$method($value);
            }
        }
    }

    public function cvtDat($dat0, $action, $init=false)
    {
       if($action ==='set') :
            $fmt0 = "d-m-Y";
            $fmtx = "Y-m-d";

            if(!isset($dat0) && $init = true): $dat0 = date($fmt0); endif;
        else:
            $fmt0 = "Y-m-d";
            $fmtx = "d-m-Y";
        endif;
        
        if(isset($dat0))
        {
            $item = explode('-', $dat0);
            // $datx = new DateTime();
            // $datx->setDate($item[2], $item[1],$item[0]);
            // return $datx->format($fmtx);      
            $datx = $item[2] . '-' . $item[1] . '-' . $item[0];
            return $datx;
        }else{
            return $dat0;
        }
    }

   
    public function isNew()
    {
        return empty($this->id);
    }

    /**
     * Display field file description
     * @param string $table  <= Nom table recherchée
     * @return array $zNames <= Noms des zones
     */
    public function getFfd($table)
    {
        $sql = "SELECT COLUMN_NAME
        FROM   INFORMATION_SCHEMA.COLUMNS
        WHERE Table_Schema = 'jfrblog' and Table_Name='". $table . "'";

        $this->zNames = DB::getInstance()->query($sql,'','');
        return $this->zNames; 
    }
}
