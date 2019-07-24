<?php

class UserManager 
{
    protected static $_db; // Instance de PDO
    protected $selection ;
    protected $query;
    private $_tab = 'user';
    
    public function __construct($modelName= null,$method= null)
    {    
        $_db = DB::getInstance();
    }


    public function find($selusr)
    {
        if(!empty($selusr))
        {
            $field = (is_numeric($selusr)) ? 'id' : 'userId';
            $this->selection = DB::getInstance()->get('user', array($field, '=', $selusr));
            if(is_array($this->selection) && count($this->selection))
            {
                return $this->selection;
                // return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public function login($userObj)
    {
        $userTx = get_object_vars($userObj );  
        $userT = $this->find($userTx['_userId']);
        $userT0 = $userT[0];
        $is_loggedIn = false;
        if(isset($userT0)  && !empty($userT0))
        {        
            // $user0 = new User($userT0);    
            // if($userT0['password'] === Hash::make($userTx['_password'], $userT0['salt']))
            if($userT0['password'] === $userTx['_password'])
            {
                $is_loggedIn = true;
            }
        }
        return $is_loggedIn;
    }

    public function logout()
    {
        Session::delete($this->_sessionName);
    }
   public function data()
    {
        return $this->_data;
    }

    public function isLoggedIn()
    {
        return $this->_isLoggedIn;
    }
    public function create($fields = array())
    {
        if(!$this->_db->insert('user', $fields))
        {
            throw new Exception('problem de creation profil');
        }
    }



// to get all users
    public function getUsers()
    {
        
    }
    // login

    //logout

    // register
    public function register()
    {
        
    }
  // edit/update profile & Password
}