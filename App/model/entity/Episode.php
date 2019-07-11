<?php
/**
 * Classe représentant un épisode Table Episode de la base de donnée JFRBLOG
 */
class Episode extends Table
{
    private $_id;
    private $_quote;
    private $_content;
    private $_excerpt;
    private $_createdDat;
    private $_status;
    private $_onlineDat;
    private $_commented;              
    private $_nbComment;
    private $_bookId;
    private $_chapter;
    private $_volume;
    private $_slugEps;

    
     /**
 * Constantes relatives aux erreurs liées aux méthodes ???
 */
const BOOK_ANO = 1;
const CHAPTER_ANO = 2;
const CONTENT_ANO = 3;

/**
     * Constructeur de la classe assignant -via fonction hydrate, les données si transmises
     * géré via classe Table.
     * @param array $donnees
     * @return void
     */


  
// Setters
    public function setId($id)
    {
        $this->_id = (int) $id;
    }
    public function setQuote($quote)
    {
        if (!empty($quote) && is_string($quote))
        {
            $this->_quote = $quote;
        }
        
    }
    public function setContent($content)
    {
            $this->_content = $content;
    }
    public function setExcerpt($excerpt)
    {
        if (empty($excerpt))
        {
            substr(strip_tags($this->_content), 0, 300);
        }
        else
        {
            $this->_excerpt = $excerpt;
        }
        
    }

    public function setCreatedDat($createdDat=null)
    {
        $date = new DateTime();
        $this->_createdDat = ($createdDat !='') ? date('Y-m-d', strtotime($createdDat)) : null;
    }

    public function setStatus($status)
    {
        $this->_status = $status;
    }

    public function setOnlineDat($onlineDat=null)
    {
        $date = new DateTime();
        $this->_onlineDat = ($onlineDat !='') ? date('Y-m-d', strtotime($onlineDat)) : null;
    }

    public function setCommented($commented= null)
    {
        $date = new DateTime();
        $this->_commented = ($commented !='') ? date('Y-m-d', strtotime($commented)) : null; 
    }

    public function setNbComment($nbComment)
    {
        $this->_nbComment = (int) $nbComment;
    }

    public function setBookId($bookId)
    {
        $this->_bookId = (int) $bookId;
    }

    public function setVolume($volume)
    {
        $this->_volume = (int) $volume;
    }
    
    public function setChapter($chapter)
    {
        $this->_chapter = (int) $chapter;
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
    public function getVolume()
    {
        return $this->_volume;
    }
    public function getSlugEps()
    {
        return $this->_slugEps;
    }


    /**
     * @return bool nouvel épisode fonction  isNew() géré classe amont Table
     */
   
    /**
     * Contrôle validité des saisies
     * @return bool nouvel épisode
     */
    public static function validation()
    {
        $validTable =       array(
            'id'        =>array(
                            'Reference'     =>'Identifiant',
                            'required'      => false
                            ),
            'quote'     =>array(
                            'Reference'     =>'Intro',
                            'required'      => true,
                            'min'           => 3,
                            'max'           => 2000
                            ),
            'content'     =>array(
                            'Reference'     =>'texte',
                            'required'      => true,
                            'min'           => 50
                            ),
            'excerpt'     =>array(
                            'Reference'     =>'Extrait',
                            'required'      => false,
                            'max'           => 300
                            ),
            'createdDat' =>array(
                            'Reference'     =>'Créé le',
                            'required'      => false,    
                            ),
            'status'    =>array(
                            'Reference'     =>'statut',
                            'required'      => true,
                            'max'           => 2,
                            'list'          => '00;10;30;80;90'
                            ),
            'onlineDat' =>array(
                            'Reference'     =>'En ligne',
                            'required'      => false    
                            ),
            'commented'     =>array(
                            'Reference'     =>'Commenté le',
                            'required'      => false
                          ),
            'nbComment'      =>array(
                            'Reference'     =>'Nb commentaires',
                            'required'      => false,
                            'max'           => 5
                          ),
            'bookId'     =>array(
                            'Reference'     =>'Livre',
                            'required'      => true,
                            'max'           => 2
                            ),
            'volume'     =>array(
                            'Reference'     =>'Tome',
                            'required'      => false,
                            'max'           => 2
                            ),
            'chapter'      =>array(
                            'Reference'     =>'Chapître',
                            'required'      => true,
                            'max'           => 3
                            ),
            'slugEps'      =>array(
                            'Reference'     =>'Slug',
                            'required'      => false,
                            'max'           => 30
                          )
      ); 
      return $validTable;
    }
}
