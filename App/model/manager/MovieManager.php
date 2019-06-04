<?php
class MovieManager
{
    protected static $data_file; // Instance de PDO
    protected $inventory = [];


    public function __construct()
    {
        self::$data_file = DATA . 'movie.csv';
    }

    private function load()
    {
        if(file_exists(DATA . 'movie.csv')){
            // the file function returns the element in an array
            $this->inventory = file(DATA . 'movie.csv');
        }else{
            var_dump('</br>' , 'erreur accès fichier: ' , DATA . 'movie.csv'); die;
        }
    }  

    public function getMovies()
    {
        $this->load();
        return $this->inventory;
    }
        
}