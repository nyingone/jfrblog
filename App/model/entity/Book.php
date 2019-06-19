<?php
class Book
{
    private $_id;
    private $_title;
    private $_plot;
    private $_onlineDat;
    private $_nbEps;
    private $_status;
    private $_isbn;
    private $_editYear;

    /**
     * @param array $donnees
     */
    public function __construct($dtas = [])
  {
      if(!empty($dtas))
      {
          $this->hydrate($dtas);
      }
  }
    /**
     * @param array $donnees
     */
    public function hydrate($dtas)
    {
        if(is_array($dtas))
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
    }

// Setters
    public function setId($id)
    {
        $this->_id = (int) $id;
    }
    public function setTitle($title)
    {
        $this->_title = $title;
    }
    public function setPlot($plot)
    {
        $this->_plot = $plot;
    }
    public function setOnlineDate(datetime $onlineDate)
    {
        $date = new DateTime();
       $this->_onlineDate = ($onlineDate !='') ? date('Y-m-d', strtotime(onlineDate)) : null;
    }
    public function setNbEps($nbEps)
    {
        $this->_nbEps = (int) $nbEps;
    }
    public function setStatus($status)
    {
        $this->_status = $status;
    }
    public function setIsbn($isbn)
    {
        $this->_isbn = $isbn;
    }
    public function setEditYear($editYear)
    {
        $this->_editYear = (int) $editYear;
    }

    // Getters
    public function getId()
    {
        return $this->_id;
    }
    public function getTitle()
    {
        return $this->_title;
    }
    public function getPlot()
    {
        return $this->_plot;
    }
    public function getOnlineDat()
    {
        return $this->_onlineDat;
    }
    public function getNbEps()
    {
        return $this->_nbEps;
    }
    public function getStatus()
    {
        return $this->_status;
    }
    public function getIsbn()
    {
        return $this->_isbn;
    }
    public function getEditYear()
    {
        return $this->_editYear;
    }

    public function isNew()
    {
        return empty($this->_id);
    }

    
}
