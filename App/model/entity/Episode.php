<?php
class Episode extends Table
{
    private $_id;
    private $_quote;
    private $_content;
    private $_excerpt;
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
  


// Setters
    public function setId($id)
    {
        $this->_id = (int) $id;
    }
    public function setQuote($quote)
    {
        $this->_quote = $quote;
    }
    public function setContent($content)
    {
        $this->_content = $content;
    }
    public function setExcerpt($excerpt)
    {
        $this->_excerpt = $excerpt;
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
    public function getExcerpt()
    {
        return $this->_excerpt;
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
    public function getBookId()
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

    public static function ctlMaj()
    {
    array(
        'id'                =>array(
            'Reference'     =>'Identifiant',
            'required'      => false
        ),
        'quote'             =>array(
            'Reference'     =>'Entête',
            'required'      => true,
            'min'           => 3,
            'max'           => 50
        ),
        'content'             =>array(
            'Reference'     =>'texte',
            'required'      => true,
            'min'           => 10,
            'max'           => 600
        ),
        'excerpt'             =>array(
          'Reference'     =>'extrait',
          'required'      => true,
          'min'           => 10,
          'max'           => 600
        ),
        'createdDat'         =>array(
        'Reference'       =>'Date de création',
        'required'        => false,    
        ),
        'status'             =>array(
          'Reference'     =>'statut',
          'required'      => true,
          'max'           => 2,
          'list'          => '00;10;30;80;90'
        ),
        'onlineDat'         =>array(
            'Reference'     =>'En ligne le',
            'required'      => false,    
        ),
        'commented'         =>array(
          'Reference'     =>'Commenté le',
          'required'      => false,    
        ),
        'nbComment'             =>array(
            'Reference'     =>'Nb Commentaires',
            'required'      => false
        ),
        'bookId'          =>array(
          'Reference'     =>'Ref. livre',
          'required'      => true,
          'int'           => true
        ), 
        'chapter'          =>array(
          'Reference'     =>'Chapître',
          'required'      => true,
          'max'           => 3
        ),
        'version'          =>array(
          'Reference'     =>'version',
          'required'      => true,
          'max'           => 4
        ),
        'slugEps'         =>array(
          'Reference'     =>'Slug',
          'required'      => false,
          'max'           => 30
        )
        );
    }

}
