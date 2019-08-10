<?php
class BookManager extends Manager
{

    protected $_tab = 'book';

 //   protected static $_db; // Instance de PDO
    private $_books = [];
    private $_episodeManager;
    private $_selection ;     
      

    public function __construct($modelName = null,$method= null)
    {    
         parent::__construct($this->_tab);
       
    }
    public function majTab($class)
    {
        parent:: majTab($class); 
        Redirect::to($this->_tab);
    }

    public function getBooks($parms=null, $level=null)
    { 
        $action = "select * FROM ";
        $join = null;
        
        $orderBy = ' order by EditYear DESC, status, id DESC ';
        if($parms == null)
        {   
            if(ADMIN):
                $orderBy = ' order by blogged ASC, promoted DESC, status ASC ';
                $ksel = array(  'status'    , '<', '90');
            elseif(FRIEND):
               
                $ksel = array(  'blogged'    , '<>', 1,
                                'status'    , '>=', '20',
                                'status'    , '<', '90');
            else:
                $ksel = array(  'blogged'    , '<>', 1,
                                'status'    , '>=', '30',
                                'status'    , '<', '90');
            endif;
        }else{
            $ksel = array('id', '=', $parms);
        }

  
        $this->_selection = DB::getInstance()->get($this->_tab, $ksel, $orderBy, $action, $join);
       
        if(isset($this->_selection) && !empty($this->_selection))
        {
          
            foreach($this->_selection as $table)
            {
               
                $book = new Book($table);
                 // Récup des épisodes
                $nbComm = 0;
                $nbAlt  = 0;
                $nbEps  = 0;
                $maxStEps  = '00';
                $nbEpsAlt  = 0;
                if($level === 'N0')
                {
                    $this->episodeManager = new EpisodeManager();
                    $episodes = $this->episodeManager->getSelection($book->getId(), $level);
                    $book->setEpisodes($episodes);
                    foreach ($episodes as $episode)
                    {
                        if($maxStEps < $episode->getStatus()) : 
                            $maxStEps = $episode->getStatus();
                        endif;
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
                    var_dump($maxStEps); 
                    if( $maxStEps > $book->getStatus()) : 
                        $book->setStatus($maxStEps);
                    endif;
                }  
              
                $this->books[] = $book;
            }
          
        }else{
            $this->books[] = new Book([]);
        }
        return $this->books;
    }

   
}