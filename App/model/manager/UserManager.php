<?php

class UserManager 
{
    protected static $_db; // Instance de PDO
 
    protected $query;
    private $_tab = 'user';
    protected $selection ;
    protected $users = [] ;
    
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
                foreach($this->selection as $table) :
                    $user = new User($table);
                    $this->users[] = $user;
                endforeach;
                
                return $this->users;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public function login($visiteur)
    {
        $is_loggedIn = false;
        unset($_SESSION['logged_in']);
       
        $users = $this->find($visiteur->getUserId());
        if(is_array($users)  && !empty($users))
        {        
            foreach($users as $friend) :                
                if($visiteur->getPassword() === $friend->getPassword())
                {
                    $visiteur->setEmail($friend->getEmail());
                    $visiteur->setPseudo($friend->getPseudo());
                    $visiteur->setGroupId($friend->getGroupId());
                    $is_loggedIn = true;
                   
                    $_SESSION['logged_in']  =  $is_loggedIn; 
                    $_SESSION['email']      = $visiteur->getEmail();
                    $_SESSION['userId']     = $visiteur->getUserId();
                    $_SESSION['pseudo']     = $visiteur->getPseudo();
                    $_SESSION['groupId']    = $visiteur->getGroupId();
                }
            endforeach;
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
       public function majTab($class)
    { 
     
        if(isset($_POST['id']) && $_POST['id'] > 0){
            $id = $_POST['id'];
        }else{
            $id = null;
        }    
        if($_POST['action'] == 'del')
        {
            $succes = DB::getInstance()->dltClsRcd($this->_tab, $class);
            if($succes == false)
            {
                throw new Exception('problem de suppression' . $this->_tab);
            }else{
                Session::flash($this->_tab, 'delete successful' );
            }
        }else{
     
            if(isset($_POST['id']) && $_POST['id'] > 0)
            {
                $succes = DB::getInstance()->updClsRcd($this->_tab, $class);
                if($succes == false)
                {
                    throw new Exception('problem de maj' . $this->_tab);
                }else{
                    Session::flash($this->_tab, 'maj successful' );
                }
            }else{
                $succes = DB::getInstance()->addClsRcd($this->_tab, $class);
                if($succes == false)
                {
                    throw new Exception('problem de creation' . $this->_tab);
                }else{
                    Session::flash($this->_tab, 'crt successful' );
                }  
            }
        }
    }

}