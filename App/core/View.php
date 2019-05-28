<?php
class View
{
    protected $view_file;
    protected $view_datas;

    public function __construct($view_file,$view_datas)
    {
        $this->view_file    = $view_file;
        $this->view_datas   = $view_datas;
    }

    public function render()
    {
       // var_dump( $this->view_file);
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
}