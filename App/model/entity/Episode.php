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
    private $_image;
    private $_imageAlt;
    /**
     * Variablea ajoutés à l'objet
     */
    private $_comments;
    private $_bookInfo;
    private $_statusLabel;
    private $_statusType;
    private $_nbComments;
    private $_alertComm;
    private $_idDel;
    private $_idMaj;

    
     /**

     * Constructeur de la classe assignant -via fonction hydrate, les données si transmises
     * géré via classe Table.
     * @param array $donnees
     * @return void
     */

    public function __construct($table)
    {
        parent::__construct($table);
        
        if($this->getStatus() >= 20)     // publié en ligne
        {
            $this->setStatusLabel("Mis en ligne le....:");
            $this->setStatusType("date");
            $this->setIdDel(false);
            $this->setIdMaj(true);

        }else{
            $this->setStatusLabel("hors ligne:");
            $this->setStatusType("hidden");
            $this->setIdDel(true);
            $this->setIdMaj(true);
        }

        if($this->getStatus() >= 70):    // publié hard cover ou définitif 
            $this->setIdMaj(false);
        endif;
    }
  
  
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
        $this->_createdDat = $this->setDat($createdDat, 'Y-m-d H:i:s' );
      
    }

    
    public function setStatus($status)
    {
        $this->_status = $status;
    }

   
    public function setOnlineDat($onlineDat=null)
    {
        if(! is_null($onlineDat)) 
        {
            $this->_onlinedDat = $this->setDat($onlineDat, 'Y-m-d H:i:s' );
        }
        
    }

    public function setCommented($commented= null)
    {
        if(!is_null($commented)) 
        {
        $this->_commented = $this->setDat($commented, 'Y-m-d H:i:s' );
        }
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

    public function setImage($image)
    {
        $this->_image = $image;
    }
    public function setImageAlt($imageAlt)
    {
        $this->_imageAlt = $imageAlt;
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
    public function getCreatedDat($sql = null)
    { 
        // var_dump($this->getDat($this->_createdDat, $sql)); 
        // return $this->getDat($this->_createdDat, $sql);
        $date = new DateTime("$this->_createdDat");
        if ($sql === '*') :
            return $date->format('Y-m-d');
        else:
            return $date->format('d-m-Y');
        endif;
    }
    public function getStatus()
    {
        return $this->_status;
    }
    public function getOnlineDat($sql = null)
    {
        return $this->getDat($this->_onlineDat, $sql);
    }
    public function getCommented($sql = null)
    {
        return $this->getDat($this->_commented, $sql);
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
    public function getImage()
    {
        return $this->_image;
    }
    public function getImageAlt()
    {
        return $this->_imageAlt;
    }

    /**
     * Fonction annexes _____________________________________________SET
     */
    public function setComments($comments)   // tableau d'objets Comment
    {
        $this->_comments = $comments;
        if(is_array($comments)):
            $this->setNbComments(count($comments));
        endif;
    }

    public function setNbComments($nbComments)
    {
        $this->_nbComments = $nbComments;
    }

    /**
     * @parm mixed      (tableau ou false)
     * @return mixed    (count ou false)
     */
    public function setAlertComm($alt)
    {
        if(is_array($alt)) : 
            $alt = count( array_column($alt, 'status'));          
        endif;
        $this->_alertComm = (int) $alt;
      
    }

    public function setBookInfo($books)     // tableau d'objets Bok
    {
        $this->_bookInfo = $books;
    }
 
    public function setStatusLabel($label)
    {

        $this->_statutLabel = $label;
    }
    public function setStatusType($type)
    {

        $this->_statutType = $type;
    }

    public function setIdDel($idDel)
    {
        $this->_idDel = $idDel;
    }

    public function setIdMaj($idMaj)
    {
        $this->_idMaj = $idMaj;
    }
    /**
    *  Fonction annexes  _____________________________________________GET
    */
   
   public function getBookInfo()
   {
       return $this->_bookInfo;
   }

       public function getComments()
    {
        return $this->_comments;
    }
    public function getNbComments()
    {
        return $this->_nbComments;
    }
    public function getAlertComm()
    {
        return $this->_alertComm;
    }

    public function getStatusLabel()
    {

        return $this->_statutLabel;
    }
    public function getStatusType()
    {

        return $this->_statutType;
    }
    public function getIdDel()
    {

        return $this->_idDel;
    }
    public function getIdMaj()
    {

        return $this->_idMaj;
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
                            'max'           => 5000
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
                            ),
            'image'      =>array(
                            'Reference'     =>'Image',
                            'required'      => false,
                            'max'           => 30
                            ),
            'imageAlt'      =>array(
                            'Reference'     =>'Légende',
                            'required'      => false,
                            'max'           => 50
                            )
      ); 
      return $validTable;
    }
}
