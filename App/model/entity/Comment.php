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

    private $_bookInfo;
    private $_episodeInfo;
    /**
    * Constructeur de la classe assignant -via fonction hydrate, les données si transmises
    * géré via classe Table.
    * @param array $donnees
    * @return void
    */
    public function inz_POST($comment)
    {
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

        // $date = new DateTime("$postDat");
        // $this->_postDat =  $date->format('Y-m-d H:i:s');
        $this->_postDat = $this->setDat($postDat, 'Y-m-d H:i:s' );
       // $this->_postDat = ($postDat != '') ? $this->cvtDat($postDat, 'set', false) : $this->cvtDat($postDat, 'set', true);
    }
    public function setStatus($status)
    {
        $this->_status = $status;
    }
    public function setValidDat($validDat)
    {
        if(isset($validDat))
        {
            $date = new DateTime("$validDat");
            $this->_validDat =  $date->format('Y-m-d H:i:s');
        }   
    }
    public function setNbCon($nbCon)
    {
        $this->_nbCon = (int) $nbCon;
    }
    public function addNbCon()
    {
        $this->_nbCon ++;
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
