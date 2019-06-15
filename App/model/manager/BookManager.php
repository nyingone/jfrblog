<?php
class BookManager
{
    protected static $_db; // Instance de PDO
    protected $books =[];
    protected $query;


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
        $x = 0;
        foreach($this->books as $table)
        {
            $book = new Book;
            $book->hydrate($table);
            $this->books[$x] = $book;
            $x++;
        }
        return $this->books;
    }


}