<?php
class BookManager extends Bddmanager
{
    protected $books =[];

 
    public function findAll($query)
    {
        $query= "SELECT * FROM book order by id";
        // echo '<br/>' . 'appel inventory ' . $query;
        parent::getInventory($query);
        // var_dump($this);
        //  $books= $this->getInventory($query,$objName);
       //  $books = $this->getResult($query, 'Book');
       // var_dump($this->getInventory($query,$objName));
       // die;
        return $books;
    }

    public function findOne($id)
    {
        $query= "SELECT * FROM book where book.id = $id" ;
        $books = $this->getResult($query, 'Book');
        return $books;
    }

    public function addBook()
    {

    }

    public function delBook()
    {
        
    }
}
