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

    public function create_POST($tabval)
    {
        if(is_array($tabval) && !empty($tabval))
        {
            foreach($tabval as $key => $value) 
            {
                $field = trim($key, "_");
                $method = 'get' . ucfirst($field);
                if(method_exists($this, $method))
                {
                    if (!isset($_POST[$field])): 
                        $_POST[$field] = $this->$method($value);
                    endif;
                }
            }


        }
    }

    public function setDat($datx= null, $fmt)
    {

        $date = new DateTime("$datx"); 
        return   $date->format("$fmt");
        
       // $this->_postDat = ($postDat != '') ? $this->cvtDat($postDat, 'set', false) : $this->cvtDat($postDat, 'set', true);
    }

    public function getDat($datx,$sql= null, $lgz= null)
    {
        $date = new DateTime("$datx");
        if ($sql === '*') :
            if ($lgz === 8) : 
                return $date->format('Y-m-d'); 
            else:
                return $date->format('Y-m-d H:i:s');
            endif;
        else:
            if ($lgz === 8) : 
                return $date->format('d-m-Y'); 
            else:
                return $date->format('d-m-Y H:i:s');
            endif;
        endif;
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
