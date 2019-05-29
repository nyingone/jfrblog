<?php
class EpisodeManager extends BddManager
{
    protected $query;
    /**
     * @param array $params (sel. user transmis via Application/Controller)
     * @return inventory
     */
    public function getSelection($params = [])
    {
        $query= 'SELECT * FROM episode order by bookId, chapter,version';       
        parent:: getInventory($query);  
        return $this->inventory;
    }
}