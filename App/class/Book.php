<?php
class Book
{
    private $_id;
    private $_title;
    private $_excerpt;
    private $_onLineDate;
    private $_status;
    private $_isbn;
    private $_editYear;

    /**
     * @param array $donnees
     */
    public function hydrate(array $dtas)
    {
        foreach ($dtas as $key => $value)
        {
            $method = 'set' . ucfirst($key);
            if(method_existe($this, $method))
            {
                $this->method($value);
            }
        }
    }

// Setters
    public function setTitle($title)
    {
        $this->_title = $title;
    }
    public function setExcerpt($excerpt)
    {
        $this->_excerpt = $excerpt;
    }
    public function setOnlineDate($onlineDate)
    {
        $this->_onlineDate = $onlineDate;
    }
    public function setStatus($status)
    {
        $this->_status = $status;
    }
    public function setIsbn($isbn)
    {
        $this->_isbn = $isbn;
    }
    public function setEditYear($edityear)
    {
        $this->_editYear = $editYear;
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
    public function getExcerpt()
    {
        return $this->_excerpt;
    }
    public function getOnlineDat()
    {
        return $this->_onlineDat;
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

}