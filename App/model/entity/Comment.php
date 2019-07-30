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

    /**
    * Constructeur de la classe assignant -via fonction hydrate, les données si transmises
    * géré via classe Table.
    * @param array $donnees
    * @return void
    */


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
        
        $date = new DateTime();
        $this->_postDat = ($postDat !='') ? date('Y-m-d', strtotime($postDat)): null;
    }
    public function setStatus($status)
    {
        $this->_status = $status;
    }
    public function setValidDat($validDat)
    {
        $date = new DateTime();
        $this->_validDat = ($validDat !='') ? date('Y-m-d', strtotime($validDat)): null;
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
    public function getPostDat()
    {
        return $this->_postDat = ($this->_postDat !='') ? date('d-m-Y', strtotime($this->_postDat)): null;; 
    }
    public function getstatus()
    {
        return $this->_status;
    }
    public function getValidDat()
    {
        return $this->_validDat = ($this->_validDat !='') ? date('d-m-Y', strtotime($this->_validDat)): null;; 
    }
    public function getNbCon()
    {
        return $this->_nbCon;
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
