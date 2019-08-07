<?php
class Comment  extends Table
{
    // SELECT `id``bookId``bookVol``bookChap``bookEps``userId``comment``postDat``status``validDat` FROM `comment`
    private $_id;
    private $_bookId;
    private $_bookChap;
    private $_epsId;
    private $_user;
    private $_pseudo;
    private $_comment;
    private $_postDat;
    private $_status;
    private $_validDat;
    private $_nbCon;
    private $_newCon;

    private $_bookInfo;
    private $_episodeInfo;
    private $_AlertComm;
    /**
    * Constructeur de la classe assignant -via fonction hydrate, les données si transmises
    * géré via classe Table.
    * @param array $donnees
    * @return void
    */
    public function __construct($table)
    {
        parent::__construct($table);
        
        if($this->getNewCon() <> 0 ) : 
            if ($this->getStatus() === '30') : 
                $this->setStatus('20'); 
            endif;
        endif;

        if($this->getStatus() < 30) :    // Stt commentaire non validé ou signalé (20)
            $this->setAlertComm(true);
        else:
            $this->setAlertComm(false);
        endif;
    }
    public function inz_POST($comment)
    {
        if($_POST['action'] === 'val') : 
            $comment->setStatus('30');  
            $comment->setNewCon(0);  
            $comment->setValidDat();
        endif;
        if($_POST['action'] === 'signal') : 
            $comment->addNbCon(); 
            unset($_POST['nbCon']);
            unset($_POST['newCon']);
            unset($_POST['status']);
        endif;
        
        $tabVal = get_object_vars($comment); 
        $this->create_POST($tabVal);
        
    }

// Setters
    public function setId($id)
    {
        $this->_id= (int) $id;
    } 
    public function setBookId($bookId)
    {
        $this->_bookId = (int) $bookId;
    } 
       public function setEpsId($epsId)
    {
        $this->_epsId = (int) $epsId;
    }
    public function setUser($user)
    {
        $this->_user = $user;
    }
    public function setPseudo($pseudo)
    {
        $this->_pseudo = $pseudo;
    }
    public function setComment($comment)
    {
        $this->_comment = $comment;
    }
    public function setPostDat($postDat= null)
    {
        $this->_postDat = $this->setDat($postDat, 'Y-m-d H:i:s' );
    }
    public function setStatus($status)
    {
        $this->_status = $status;
    }
    public function setValidDat($validDat=null)
    {
        if($this->getStatus() === '30')
        {
            $this->_validDat = $this->setDat($validDat, 'Y-m-d H:i:s' );
        }else{
            $this->_validDat  = null;
        }
    }
    public function setNbCon($nbCon)
    {
        $this->_nbCon = (int) $nbCon;
    }

    public function setNewCon($newCon)
    {
        $this->_newCon = (int) $newCon;
    }

    public function addNbCon()
    {
        $this->_nbCon ++;
        $this->_newCon ++;
         
        if ($this->getStatus() === '30') : 
            $this->setStatus('20'); 
        endif;
        $this->setAlertComm(true);
       
    }

    // Getters
    public function getId()
    {
        return $this->_id;
    }
    public function getBookId()
    {
        return $this->_bookId;
    }
        
    public function getEpsId()
    {
        return $this->_epsId;
    }
    public function getUser()
    {
        return $this->_user;
    }
    public function getPseudo()
    {
        return $this->_pseudo;
    }
    public function getComment()
    {
        return $this->_comment;
    }
    public function getPostDat($sql= null)
    {
        return $this->getDat($this->_postDat, $sql);
    }
    public function getstatus()
    {
        return $this->_status;
    }
    public function getValidDat($sql= null)
    {
        if(isset($this->_validDat))
        {
            $date = new DateTime("$this->_validDat");
            if ($sql === '*') :
                return $date->format('Y-m-d H:i:s');
            else:
                return $date->format('d-m-Y H:i:s');
            endif;
        }
    }
    public function getNbCon()
    {
        return $this->_nbCon;
    }
    public function getNewCon()
    {
        return $this->_newCon;
    }
    
    /**
     * Fonction annexes _____________________________________________SET
     */
    public function setBookInfo($books)     // tableau d'objets Book
    {
        $this->_bookInfo = $books;
    }

    public function setEpisodeInfo($episodes)     // tableau d'objets Book
    {
        $this->_episodeInfo = $episodes;
    }

    public function setAlertComm($alert)
    {
       
            $this->_alertComm = $alert;
         
      
    }

     /**
    *  Fonction annexes  _____________________________________________GET
    */
    public function getBookInfo()
    {
        return $this->_bookInfo;
    }
    public function getEpisodeInfo()
    {
        return $this->_episodeInfo;
    }

    public function getAlertComm()
    {
        return $this->_alertComm;
    }

    // SELECT `id``bookId```bookChap``c``userId``comment``postDat``status``validDat` FROM `comment`
    public static function validation()
    {
        $validTable =       array(
            'id'        =>array(
                            'Reference'     =>'Identifiant',
                            'required'      => false
                            ),
            'bookId'     =>array(
                            'Reference'     =>'bookId',
                            'required'      => false,
                            ),
            'epsId' =>array(
                            'Reference'     =>'Episode',
                            'required'      => false,    
                            ),
            'user'    =>array(
                            'Reference'     =>'user',
                            'required'      => false,
                            'max'           => 20
                            ),
            'pseudo' =>array(
                            'Reference'     =>'pseudo',
                            'required'      => false,
                            'max'           => 20    
                            ),
            'postDat'     =>array(
                            'Reference'     =>'Commenté le',
                            'required'      => false
                            ),
            'status'      =>array(
                            'Reference'     =>'status',
                            'required'      => false
                            ),
            'validDat'     =>array(
                            'Reference'     =>'Validé le',
                            'required'      => false
                            ),
            'nbCon'      =>array(
                            'Reference'     =>'Signalement',
                            'required'      => false
                            )
           
                    ); 
      return $validTable;
    }
    
}
