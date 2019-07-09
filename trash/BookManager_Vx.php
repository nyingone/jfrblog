<?php
class BookManager
{
    protected static $_db; // Instance de PDO
    protected $books ;
    protected $query;
    private $_tab = 'book';

    public function __construct($modelName,$method)
    {    
        $_db = DB::getInstance();
    }

    public function getBooks($parms=null)
    {
        if(!isset($parms))
        {
            $this->books = DB::getInstance()->query('SELECT * from book','','book');
        }else{
            $this->books = DB::getInstance()->get('book', array('id', '=', $parms));
        }
        if(isset($this->books) && !empty($this->books))
        {
          $x = 0; 
            foreach($this->books as $table)
            {
                $book = new Book($table);
                $this->books[$x] = $book;
                $x++;
                // att. conserver $x sinon crée un tableau de tableau et non un tableau d'objets
            }
          
        }else{
            $this->books[] = new Book();
        }
        return $this->books;
    }

    public function majTab($fields = array())
    {
     
        if(isset($_POST['id']) && $_POST['id'] > 0){
            $id = $_POST['id'];
        }else{
            $id = null;
        }     
        if($_POST['action'] == 'del')
        {
            $succes = DB::getInstance()->delete($this->_tab, $id,[]);
            if($succes == false)
            {
                throw new Exception('problem de suppression' . $this->_tab);
            }else{
                Session::flash($this->_tab, 'delete successful' );
            }
            Redirect::to(HOME . $this->_tab);
        }else{
     
        $fields = [
            'id'        => $id,
            'title'     => Input::get('title'),
            'plot'      => Input::get('plot'),
           // 'onlineDat' => (empty(Input::get('onlineDat'))) ? null : Input::get('onlineDat') , // date('Y-m-d H:i:s'),
            'onlineDat' =>  (Input::get('onlineDat') !='') ? date('Y-m-d', strtotime(Input::get('onlineDat'))) : null , 
            'nbEps'     => (int) Input::get('nbEps'),
            'status'    => Input::get('status'),
            'isbn'      => Input::get('isbn'),
            'editYear'  => (int) Input::get('editYear') 
        ];
        if(isset($_POST['id']) && $_POST['id'] > 0)
        {
           $succes = DB::getInstance()->update($this->_tab, $id, $fields);
           // if(!DB::getInstance()->update($this->_tab, $id, $fields))
            if($succes == false)
            {
                throw new Exception('problem de maj' . $this->_tab);
            }else{
                Session::flash($this->_tab, 'maj successful' );
            }
        }
        else{
            $book = new Book($fields);
            $succes = DB::getInstance()->insert($this->_tab, $fields);
            if($succes == false)
            {
                throw new Exception('problem de creation' . $this->_tab);
            }else{
                Session::flash($this->_tab, 'crt successful' );
                // header('location: index.phtml');
               //  Redirect::to($this->_tab);
            }  
        }
               
    }
        // Redirect::to($this->_tab);
    }
}