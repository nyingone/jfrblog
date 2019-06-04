<?php
class BookController extends Controller
{
  public $data = '';
  private $ctl = 'book';

/** create all the actions we can have */
    public function index()
    {
    /**
     * charger le manager et les donnéesssss à transmettre à la vue
     * le Controller amont crée le modèle avec  public function model($modelName,$datas=[])
     */
      $this->createModel($this->ctl, '');
      // $this->model('book', ['books => $this->model->getBooks()']);
      $datas = $this->model->getBooks();

      $this->createView($this->ctl . DS . 'index', $datas);
      $this->view->page_title = "This is our Bibliographie page";
      $this->view->render();
     
    }
    public function edit()
    {
      $this->model($this->ctl, '');
      $datas = $this->model->getBooks();

      $this->view($this->ctl . DS . 'edit', $datas);
      // var_dump($this); exit;
      $this->view->page_title = "xxxxxx";
      $this->view->render();
    }
}
  