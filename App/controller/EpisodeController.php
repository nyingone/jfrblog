<?php
class EpisodeController extends Controller
{
  public $data = '';
  private $_ctl = 'episode';
  public $params = [];

/** create all the actions we can have */
    public function index($params)
    {
    /**
     * charger le manager et les donnéesssss à transmettre à la vue
     * le Controller amont crée le modèle avec  public function model($modelName,$datas=[])
     */
      $this->createmodel($this->ctl, '');
      $datas = $this->model->getSelection($params);
      $this->createView($this->ctl . DS . 'index', $datas);
      $this->view->page_object = "Episode";
      $this->view->page_inzcst();
      $this->view->render();
     
    }

    public function edit($id,$opt=null)
    {
      $this->model($this->_ctl, '');
      $datas = $this->model->getSelection();
      $this->view($this->_ctl . DS . 'edit', $datas);
      $this->view->page_object = "Episode";
      $this->view->page_inzcst($id,$opt);
      $this->view->render();
    }
}
  