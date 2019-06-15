<?php
class User
{
    private $_db;                                                                             
    private $_data;
    private $_sessionName;
    private $_isLoggedIn;

    public function __construct($user = null){
        $this->_db = DB::getInstance();
        $this->_sessionName = Config ::get('session/session_name');
        
        if(!$user){
            if(Session::exists($this->_sessionName)){
               if($this->find($user)){
                   $this->_isLoggedIn = true;
               } else {
                   // process Logout
               }
            }
        } else {
            $this->find($user);
        }
    }

    public function create($fields = array())
    {
        if(!$this->_db->insert('user', $fields))
        {
            throw new Exception('problem de creation profil');
        }
    }

    public function find($user = null)
    {
        if($user){
            $field = (is_numeric($user)) ? 'id' : 'userId';
            $data = $this->_db->get('user', array($field, '=', $user));
            
            if($data->count()){
                $this->_data = $data->first() ; // $data->first();
                return true;
            }
        }
        else {
            return false;
        }
    }

    public function login($userId= null, $password = null, $remember)
    {
        $user = $this->find($userId);
        // if(isset($userId) )
        if($user)
        {           
            if($this->data()->password === Hash::make($password, $this->data()->salt))
            {
               // echo  'ok';
               Session::put($this->_sessionName, $this->data()->id);
               
               if($remember) {
                   
               }
               
               return true;
            }
        }
        
        return false;

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
}