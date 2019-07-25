<?php
class Comment  extends Table
{
    // SELECT `id``bookId``bookVol``bookChap``bookEps``userId``comment``postDat``status``validDat` FROM `comment`
    private $_id;
    private $_bookId;
    private $_bookVol;
    private $_bookChap;
    private $_epsId;
    private $_user;
    private $_pseudo;
    private $_comment;
    private $_postDat;
    private $_status;
    private $_validDat;

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
    public function setBookId($bookId)
    {
        $this->_bookId = $bookId;
    }
    public function setBookVol($_bookVol)
    {
        $this->_bookVol = $bookVol;
    }
    public function setBookChap($_bookChap)
    {
        $this->_bookChap = $bookChap;
    }
    public function setEpsid($_epsId)
    {
        $this->_bepsId = $epsId;
    }
    public function setUser($user)
    {
        $this->_user = $user;
    }
    public function setPseudo($pseudo)
    {
        $this->_psedo = $pseudo;
    }
    public function setComment($comment)
    {
        $this->_comment = $comment;
    }
    public function setPostDat($postDat)
    {
        $this->_postDat = $postDat;
    }
    public function setStatus($status)
    {
        $this->_status = $status;
    }
    public function setValidDat($validDat)
    {
        $this->_validDat = $validDat;
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
    public function getBookChap()
    {
        return $this->_bookChap;
    }
    public function getBookVol()
    {
        return $this->_bookVol;
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
    
}
