<?php
class EpisodeController extends Controller
{
  public $data = '';
  private $ctl = 'episode';
  public $params = [];

/** create all the actions we can have */
    public function index($params)
    {
     // var_dump(__CLASS__, '</br>', __METHOD__, '</br>');
    /**
     * charger le manager et les donnéesssss à transmettre à la vue
     * le Controller amont crée le modèle avec  public function model($modelName,$datas=[])
     */
     $this->model($this->ctl, '');
    

      // $this->model('book', ['books => $this->model->getBooks()']);
      $datas = $this->model->getSelection($params);
      var_dump($datas);

      $this->view($this->ctl . DS . 'index', $datas);


      // var_dump($this); exit;
      $this->view->page_title = "This is our Episode show page";
      $this->view->render();
     
    }

    public function edit()
    {
      $this->model($this->ctl, '');
      $datas = $this->model->getbooks();

      $this->view($this->ctl . DS . 'edit', $datas);
      // var_dump($this); exit;
      $this->view->page_title = "xxxxxx";
      $this->view->render();
    }
}
  