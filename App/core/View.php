<?php
class View
{
    protected $view_file;
    protected $view_data = [];
    protected $redirect_url;
    public $page_opt = '';
    public $button_value = 'none';
    public $page_object ;
    public $page_title = "Visualisation d'un ";

    public function __construct($view_file,$view_data)
    {
        $this->view_file   = $view_file;
        $this->view_data   = $view_data;
        if(isset($_SERVER['REDIRECT_URL']))
        {
        $this->redirect_url =  $_SERVER['REDIRECT_URL'];
        }
    }

    public function render()
    {
        if(file_exists(VIEW . $this->view_file . '.phtml'))
        {
            include (VIEW . $this->view_file . '.phtml');
        }else{ echo VIEW . $this->view_file . '.phtml' . ' accesano';

        }
    }

    public function getAction()
    {
        return(explode('\\', $this->view_file)[1]);
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