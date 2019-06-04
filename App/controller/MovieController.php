<?php
class MovieController extends Controller
{
  public $data = '';
  private $ctl = 'movie';

/** create all the actions we can have */
    public function index()
    {
    /**
     * charger le manager et les données à transmettre à la vue
     * le Controller amont crée le modèle avec  public function model($modelName,$datas=[])
     */
      $this->createModel($this->ctl, '');
      
      $datas = $this->model->getMovies();
      $this->createView($this->ctl . DS . 'index', $datas);
      $this->view->page_title = "Filmographie";
      $this->view->render();
     
    }
    
    public function edit()
    {
      $this->createModel($this->ctl, '');
      $datas = $this->model->getMovies();

      $this->view($this->ctl . DS . 'edit', $datas);
      $this->view->page_title = "xxxxxx";
      $this->view->render();
    }
}
  