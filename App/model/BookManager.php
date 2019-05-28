<?php
class BookManager extends Bddmanager
{
    protected $books =[];

    public function findAll()
    {
        $query= "SELECT book.* FROM book inner join author on book.author_id= author.id left outer join subject on book.genre= subject.genre order by book.cclord";
        $books= $this->getInventory($query,$objName);
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
