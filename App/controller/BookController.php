<?php
class BookController extends Controller
{
  public $data = [];
  private $ctl = 'book';

/** create all the actions we can have */
    public function index()
    {
    /**
     * charger le manager et les donnéesssss à transmettre à la vue
     * le Controller amont crée le modèle avec  public function model($modelName,$datas=[])
     */
      $this->createModel($this->ctl, '');
      $datas = $this->model->getBooks();
      $this->createView($this->ctl . DS . 'index', $datas);
      $this->view->page_title = "This is our Bibliographie page";
      $this->view->render($datas);
     
    }
    public function edit($id)
    {
      $this->createmodel($this->ctl, '');
      $datas = $this->model->getBooks($id);

      $this->createview($this->ctl . DS . 'editx', $datas);
      // var_dump($this); exit;
      $this->view->page_title = "xxxxxx";
      $this->view->render($datas);
    }

    public function add()
    {
      $this->createmodel($this->ctl, '');
      
      $this->createview($this->ctl . DS . 'edit', $datas=[]);
      $this->view->page_title = "xxxxxx";
      $this->view->render([$datas]);
    }
}
  