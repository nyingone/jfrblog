<?php
class User extends Table
{
    public $_id;
    public $_userId;
    public $_password;
    private $_salt;
    private $_email;
    private $_lastName;
    private $_pseudo;
    private $_joigned;
    private $_groupId;

    public $_remember;

   /**
     * Constructeur de la classe assignant -via fonction hydrate, les données si transmises
     * géré via classe Table.
     * @param array $donnees
     * @return void
     */
    public function __construct($table)
    {      
        parent::__construct($table);
    }  

    public function inz_POST($user)
    {      
        $tabVal = get_object_vars($user); 
        $this->create_POST($tabVal);    
    }
    // Setters
    public function setId($id)
    {
        $this->_id = (int) $id;
    }
    public function setUserId($userId)
    {
        $this->_userId =  $userId;
    }
    public function setPassword($password)
    {
        $this->_password =  $password;
    }
    public function setSalt($salt)
    {
        $this->_salt =  $salt;
    }
    public function setEmail($email)
    {
        $this->_email =  $email;
    }
    public function setLastName($lastName)
    {
        $this->_lastName =  $lastName;
    } 
    public function setPseudo($pseudo)
    {
        $this->_pseudo =  $pseudo;
    }
    public function setJoigned($joigned=null)
    {
        $date = new DateTime();
        $this->_joigned = ($joigned !='') ? date('Y-m-d', strtotime($joigned)) : null;
    }
    public function setGroupId($groupId)
    {
        $this->_groupId =  $groupId;
    }

     // Getters
     public function getId()
     {
         return $this->_id;
     }
     public function getUserId()
    {
        return $this->_userId;
    }
     public function getPassword()
    {
        return $this->_password;
    }
    public function getSalt($salt)
    {
        return $this->_salt ;
    }
    public function getEmail()
    {
        return $this->_email;
    }
    public function getLastName()
    {
        return $this->_lastName;
    } 
    public function getPseudo()
    {
        return $this->_pseudo;
    }
    public function getJoigned()
    {
        return $this->_joigned;
    }
    public function getGroupId()
    {
        return $this->_groupId;
    }

    /**
     * Contrôle validité des saisies
     * @return 
     */
    public static function validation($opt= null)
    {
        var_dump($_POST);
       if(is_null($opt)):
        $opt = escape($_POST['action']);
       endif;

       //  var_dump($_POST); die;
       if($opt ===  'login' || $opt === 'connect') 
       {
        $validTable =       array(
            'userId'        => array(
                'required'  => true
                ),
            'password'      => array(
                'required'  => true
            ));
       }else{
            if($opt == 'register')
            {
                $validTable =       array(
                    'userId'        => array(
                        'Reference' => 'Identifiant',
                        'required'  => true,
                        'min'       => 2,
                        'max'       => 30,
                        'unique'    => 'user',
                        ),
                    'password'      => array(
                        'Reference' => 'Mot de passe',
                        'required'  => true,
                        'min'       => 6
                        ),
                    'passwordBis'   => array(
                        'Reference' => 'Confirmation du Mot de passe',
                        'required'  => true,
                        'matches'   =>  'password'
                    ),
                    'email'         => array(
                        'Reference' => 'Adresse mail',
                        'required'  => false
                    ),
                    'lastName'      => array(
                        'Reference' => 'Nom ',
                        'required'  => false,
                        'max'       => 50
                    ),
                    'pseudo'        => array(
                        'Reference' => 'Pseudo',
                        'required'  => false,
                        'max'       => 50
                    )
                
                ); 
            }
        }
        
        return $validTable;
    }   
}