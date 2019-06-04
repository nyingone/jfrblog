<?php
class Comment
{
    private $_id;
    private $_bookId;
    private $_chapterId;
    private $_userId;
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
    public function setChapterId($chapterId)
    {
        $this->_chapterId = $chapterId;
    }
    public function setUserId($userId)
    {
        $this->_userId = $userId;
    }
    public function setComment($comment)
    {
        $this->_comment = $comment;
    }
    public function setpostDat($postDat)
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
    public function getChapterId()
    {
        return $this->_chapterId;
    }
    public function getUserId()
    {
        return $this->_userId;
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
