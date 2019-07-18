<?php
class BookManager
{
    protected static $_db; // Instance de PDO
    protected $books ;
    protected $query;
    private $_tab = 'book';


    public function __construct($modelName = null,$method= null)
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
                // att. conserver $x sinon crée un tableau de tableau et non tableau d'objets
            }
          
        }else{
            $this->books[] = new Book();
        }
        return $this->books;
    }

    public function majTab($class)
    {
        if(isset($_POST['id']) && $_POST['id'] > 0)
        {
            $id = $_POST['id'];
        }else{
            $id = null;
        }     
        if($_POST['action'] == 'del')
        {
            $succes = DB::getInstance()->dltClsRcd($this->_tab, $class);
            if($succes == false)
            {
                throw new Exception('problem de suppression' . $this->_tab);
            }else{
                Session::flash($this->_tab, 'delete successful' );
            }
        }else{
     
            if(isset($_POST['id']) && $_POST['id'] > 0)
            {
                $succes = DB::getInstance()->updClsRcd($this->_tab, $class);
                // if(!DB::getInstance()->update($this->_tab, $id, $fields))
                if($succes == false)
                {
                    throw new Exception('problem de maj' . $this->_tab);
                }else{
                    Session::flash($this->_tab, 'maj successful' );
                }
            }else{
                $succes = DB::getInstance()->addClsRcd($this->_tab, $class);
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