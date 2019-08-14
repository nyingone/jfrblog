<?php
class View
{
    protected $view_file;
    protected $view_data = [];
    protected $view_redirect;
    public $admin;    

    public function __construct($view_file)
    {
        $this->view_file   = $view_file;
        if ( Session::exists('logged_in')):
            if(Session::get('groupId') >= '50') : 
            //     $this->admin = true; ????
            endif;
        endif;

       
       
        if(isset($_SERVER['REDIRECT_URL']))
        {
             Session::put('redirect', $_SERVER['REDIRECT_URL']);
        } else{
            if(isset($_POST['url']))
            {
                Session::put('redirect',  $_POST['url']);
                
            }  else{
                if(isset($_GET['url']))
                {
                    Session::put('redirect',  $_GET['url']);
                   
                } 
            }
        }
        // $this->view_redirect =  $X_SESSION['redirect'] ;
    
        
    }

    public function render($datas = [])
    {

        if(file_exists(VIEW . $this->view_file . '.phtml'))
        {
            
            extract ($datas);
            ob_start();
             
            include (VIEW . $this->view_file . '.phtml');
           
             $contentPage = ob_get_clean();
            
            if(Session::exists('promoted')) :
                $this->view_headerData = Session::get('promoted');
            endif;
            if(Session::exists('printed')) :
                $this->view_footerData = Session::get('printed');
            endif;

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