<?php
class View
{
    protected $view_file;
    protected $view_data = [];
    protected $view_redirect;
       

    public function __construct($view_file,$view_data)
    {
        $this->view_file   = $view_file;
              
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