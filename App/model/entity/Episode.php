<?php
class Episode
{
    private $_id;
    private $_quote;
    private $_content;
    private $_created;
    private $_status;
    private $_onlinedat;
    private $_commented;
    private $_nbComment;
    private $_bookId;
    private $_chapter;
    private $_version;
    private $_slugEps;

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
    public function setQuote($quote)
    {
        $this->_quote = $quote;
    }
    public function setContent($content)
    {
        $this->_content = $content;
    }
    public function setCreatedDat($createdDat)
    {
        $this->_createdDat = $createdDat;
    }
    public function setStatus($status)
    {
        $this->_status = $status;
    }
    public function setCommented($commented)
    {
        $this->_commented = $commented;
    }
    public function setNbComment($nbComment)
    {
        $this->_nbComment = $nbComment;
    }
    public function setBookId($bookId)
    {
        $this->_bookId = $bookId;
    }
    public function setChapter($chapter)
    {
        $this->_chapter = $chapter;
    }
    public function setVersion($version)
    {
        $this->_version = $version;
    }
    public function setSlugEps($slugEps)
    {
        $this->_slugEps = $slugEps;
    }

    // Getters
    public function getId()
    {
        return $this->_id;
    }
    public function getQuote()
    {
        return $this->_quote;
    }
    public function getContent()
    {
        return $this->_content;
    }
    public function getCreatedDat()
    {
        return $this->_createdDat;
    }
    public function getStatus()
    {
        return $this->_status;
    }
    public function getOnlineDat()
    {
        return $this->_onlineDat;
    }
    public function getCommented()
    {
        return $this->_commented;
    }
    public function getNbComment()
    {
        return $this->_nbComment;
    }
    public function getBooId()
    {
        return $this->_bookId;
    }
    public function getChapter()
    {
        return $this->_chapter;
    }
    public function getVersion()
    {
        return $this->_version;
    }
    public function getSlugEps()
    {
        return $this->_slugEps;
    }

}
