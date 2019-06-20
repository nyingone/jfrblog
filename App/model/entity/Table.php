<?php
// class Table implements arrayAcces
class Table 
{
    protected $zNames = [];

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
