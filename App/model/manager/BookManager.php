<?php
class BookManager
{
    protected static $_db; // Instance de PDO
    protected $books ;
    protected $selection ;
    protected $query;
    private $_tab = 'book';
    private $episodeManager;
    

    public function __construct($modelName = null,$method= null)
    {    
        $_db = DB::getInstance();
       
    }

    public function getBooks($parms=null, $level=null)
    { 
        $action = "select * FROM ";
        $join = null;
        $orderBy = ' order by EditYear DESC, status, id DESC ';
        if(!isset($parms))
        {   
            $ksel = array(  'blogged'    , '<>', 1,
                            'status'    , '>=', '20',
                            'status'    , '<', '90');

        }else{
            $ksel = array('id', '=', $parms);
        }

    
        $this->selection = DB::getInstance()->get($this->_tab, $ksel, $orderBy, $action, $join);
    
        if(isset($this->selection) && !empty($this->selection))
        {
          
            foreach($this->selection as $table)
            {
               
                $book = new Book($table);
                 // Récup des épisodes
                $nbComm = 0;
                $nbAlt  = 0;
                $nbEps  = 0;
                $nbEpsAlt  = 0;
                if($level === 'N0'):
                    $this->episodeManager = new EpisodeManager();
                    $episodes = $this->episodeManager->getSelection($book->getId(), $level);
                    $book->setEpisodes($episodes);
                    foreach ($episodes as $episode)
                    {
                        $nbComm += $episode->getNbcomments();
                        $nbAlt += $episode->getAlertComm();
                        $nbEps ++;
                        if($episode->getAlertComm() > 0) : 
                            $nbEpsAlt ++ ; 
                        endif;
                    }
                   //  $book->setAlertEpisode($episodes);
                    $book->setNbEpisodes($nbEps);
                    $book->setNbEps($nbEps); 
                    $book->setNbComments($nbComm);
                    $book->setAlertComm($nbAlt);
                    $book->setAlertEpisodes($nbEpsAlt);
                endif;
                $this->books[] = $book;
            }
          
        }else{
            $this->books[] = new Book([]);
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
                                }  
            }
               
        }
        Redirect::to($this->_tab);
    }
}