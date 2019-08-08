<?php
class View
{
    protected $view_file;
    protected $view_data = [];
    protected $view_redirect;
    public $admin;    

    public function __construct($view_file,$view_data)
    {
        $this->view_file   = $view_file;
        if ( isset($_SESSION['logged_in']) && $_SESSION['logged_in'] = true):
            if($_SESSION['groupId'] >= '50') : 
                $this->admin = true;
            endif;
        endif;

       
       
        if(isset($_SERVER['REDIRECT_URL']))
        {
             $_SESSION['redirect'] = $_SERVER['REDIRECT_URL'];
        } else{
            if(isset($_POST['url']))
            {
                $_SESSION['redirect'] = $_POST['url'];
                
            }  else{
                if(isset($_GET['url']))
                {
                    $_SESSION['redirect'] = $_GET['url'];
                   
                } 
            }
        }
        $this->view_redirect =  $_SESSION['redirect'] ;
    
        
    }

    public function render($datas = [])
    {
        /* if(isset( $_SESSION['redirect']) && !empty(  $_SESSION['redirect'])):
            $_SESSION['previous'] =  $_SESSION['redirect'] ;
        endif; */

        if(file_exists(VIEW . $this->view_file . '.phtml'))
        {
            extract ($datas);
            ob_start();
             
            include (VIEW . $this->view_file . '.phtml');
           
             $contentPage = ob_get_clean();
            include_once(VIEW. 'layout.phtml');
        }else{ echo VIEW . $this->view_file . '.phtml' . ' accesano';

        }
    }

    public function getAction()
    {
        return(explode('\\', $this->view_file)[0]);
    }

    public function redirect($page)
    {
        header("Location: ".$page );
        exit;
    }

}