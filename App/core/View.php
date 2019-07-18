<?php
class View
{
    protected $view_file;
    protected $view_data = [];
    protected $view_infos = [];
    protected $redirect_url;
    public $page_opt = '';
    public $button_value = 'none';
    public $page_object ;
    public $page_title = "Visualisation d'un ";

    public function __construct($view_file,$view_data, $view_infos= null)
    {
        $this->view_file   = $view_file;
        $this->view_data   = $view_data;
        $this->view_infos  = $view_infos;
        
        if(isset($_SERVER['REDIRECT_URL']))
        {
        $this->redirect_url =  $_SERVER['REDIRECT_URL'];
        $_SESSION['redirect'] = $_SERVER['REDIRECT_URL'];
        } else{
            if(isset($_POST['url']))
            {
                $_SESSION['redirect'] = $_POST['url'];
            } 
        }
        
    }

    public function render($datas = [], $infos = null)
    {
        if(file_exists(VIEW . $this->view_file . '.phtml'))
        {
           // if($this->view_file == 'home\index' )
           // {
                extract ($datas);
                ob_start();
           // }
          
            include (VIEW . $this->view_file . '.phtml');
           // if($this->view_file =='home/index' )
           // {
                $contentPage = ob_get_clean();
                include_once(VIEW. 'layout.phtml');
           // }
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

    public function page_inzcst($id = null, $opt = null)
    {
        if(isset($opt))
        { 
            if($id == '') 
            {
                $this->page_opt = 'add';
                $this->button_value = 'Ajouter';
                $this->page_title = "Création d'un ";
            }else{
                if($opt == 'upd')
                {
                    $this->page_opt = $opt;
                    $this->button_value = 'Modifier';
                    $this->page_title = "Modification d'un ";
                }else{
                    if($opt == 'del')
                    { 
                        $this->page_opt = $opt;
                        $this->button_value = 'Supprimer';
                        $this->page_title = "Suppression d'un ";
                    }else{
                        $this->page_opt = 'visu';
                        $this->page_title = "Visualisation d'un ";
                    }
                }     
            }    
            $this->page_title .=  $this->page_object;  
        }
    } 
        

}