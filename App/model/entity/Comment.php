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

    /**
     * En maj. appelle fonction centralisée de CORE\TABLE 
     * pour complément du  tableau $_POST avec les données issues de l'objet initial
     * @param object
     */
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
        if($user== null  || empty($user))
        {
            if(Session::exists('logged_in')) :
                $user = Session::get('userId');
            else:
                $user = Session::get('id');
            endif;
        } 
        $this->_user = $user;
    }
    public function setPseudo($pseudo)
    {
        if($pseudo == null  || empty($pseudo))
        {
            if(Session::exists('logged_in')) :
            $pseudo = Session::get('pseudo');
            endif;
        }
        $this->_pseudo = $pseudo;
    }
    public function setComment($comment)
    {
        $this->_comment = $comment;
    }
    public function setPostDat($postDat= null)
    {
        if(is_object($postDat)):
            $this->_postDat = $postDat;
        else:
            $this->_postDat = new datetime($postDat);
        endif;
    }
    /**
     * RG en création le statut est initialisé au niveau du groupe du visiteur ==> 
     * * lui permettra à terme de les annuler avant validation. 
     */
    public function setStatus($status)
    {
        if($status == '00' && Session::exists('logged_in'))
        {
            if(ADMIN) : $status = '30';
            else:   
                $status = Session::get('groupId');
            endif;
        }
        $this->_status = $status;

    }
 /**
     * RG  statut du msg validé fixé à 30
     * * 
     */
    public function setValidDat($validDat=null)
    {
        if(is_object($validDat)):
            $this->_validDat = $validDat;
        else:
            if($this->getStatus() === '30')
            {
                $this->_validDat = new datetime($validDat);
            }else{
                $this->_validDat  = null;
            }
        endif;
    }

/**
     * RG Nb de signalement (contre) depuis création d'un message(jamais de raz du compteur) 
     */
    public function setNbCon($nbCon)
    {
        $this->_nbCon = (int) $nbCon;
    }

    /**
     * RG Nb de signalement (contre) depuis validation ADMIN d'un message(stt 30 <=> raz du compteur) 
     */
    public function setNewCon($newCon)
    {
        $this->_newCon = (int) $newCon;
    }

    /**
     * RG Signalement (contre) ==> rétrogradation du statut à 20 <==> commentaire à valider par Admin ou à dlt par émmetteur initial
     */
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
    public function getPostDat()
    {
        return $this->_postDat;
    }
    public function getstatus()
    {
        return $this->_status;
    }
    public function getValidDat()
    {
        return $this->_validDat;
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

    public function setEpisodeInfo($episodes)     // tableau d'objets Episode
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

    
    /**
     * Controle des saisies écran; !!! manque contrôle du pseudo
     */
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
                            'connected'     => true,
                            'max'           => 20
                            ),
            'pseudo' =>array(
                            'Reference'     =>'pseudo',
                            'required'      => false,
                            'connected'     => true,
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
