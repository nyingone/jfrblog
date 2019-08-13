<?php
class BookManager extends Manager
{

    protected $_tab = 'book';
    protected $_selection = [];  
    protected $_books = null;

    private $_episodeManager;
      
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
                $orderBy = ' order by blogged ASC, promoted DESC, status ASC, EditYear DESC ';
                $ksel = array(  'status'    , '<', '90');
            elseif(FRIEND):
               
                $ksel = array(  'blogged'    , '<>', 1,
                                'status'    , '>=', '20',
                                'status'    , '<', '80');
            else:
                $ksel = array(  'blogged'    , '<>', 1,
                                'status'    , '>=', '30',
                                'status'    , '<', '80');
            endif;
        }else{
            $ksel = array('id', '=', $parms);
        }
        $this->selectionGet($action, $join, $ksel, $orderBy, $level);
        return $this->books;
    }

   public function selBookPromotedList($level)
   {
    $action = "select * FROM ";
    $join = null;
    $orderBy = ' order by EditYear DESC ';
    $ksel = array(  'promoted'    , '=', 1,
                    'status'    , '<', '90');
                    
    $this->selectionGet($action, $join, $ksel, $orderBy, $level);
    $promotedList[] = $this->books;

    $action = "select * FROM ";
    $join = null;
    $orderBy = ' order by EditYear DESC ';
    $ksel = array( 'status' , '=', '80');
                    
    $this->selectionGet($action, $join, $ksel, $orderBy, $level);
    $promotedList[] = $this->books;
    return $promotedList;
    
   }

   public function selectionGet($action, $join, $ksel, $orderBy, $level)
   {
        $this->_selection = null;
        $this->_selection = DB::getInstance()->get($this->_tab, $ksel, $orderBy, $action, $join);
        $this->formatSelection($level);
   }

   public function formatSelection($level)
   {
    $this->books = null;

        if(isset($this->_selection) && !empty($this->_selection))
        {
        
            foreach($this->_selection as $table)
            {  
                $book = new Book($table);
                
                if($level === 'N0')
                {
                        // Récup des épisodes
                    $nbComm = 0;
                    $nbAlt  = 0;
                    $nbEps  = 0;
                    $maxStEps  = '00';
                    $nbEpsAlt  = 0;
                    $firstOnlineDat  = new Datetime();
                    $this->episodeManager = new EpisodeManager();
                    $episodes = $this->episodeManager->getSelection($book->getId(), $level);
            
                    if($episodes !== false && is_array($episodes)) :
                        $book->setEpisodes($episodes);
                        foreach ($episodes as $episode)
                        {
                            if($maxStEps < $episode->getStatus()) : 
                                $maxStEps = $episode->getStatus();
                            endif;
                            if( $firstOnlineDat > $episode->getOnlineDat()) : 
                                $firstOnlineDat  = $episode->getOnlineDat();
                            endif;
                            $nbComm += $episode->getNbcomments();
                            $nbAlt += $episode->getAlertComm();
                            $nbEps ++;
                            if($episode->getAlertComm() > 0) : 
                                $nbEpsAlt ++ ; 
                            endif;
                        }

                        if($firstOnlineDat !== null) : $book->setOnlineDat($firstOnlineDat->format("Y-m-d")); endif;
                        $book->setNbEpisodes($nbEps);
                        $book->setNbEps($nbEps); 
                        $book->setNbComments($nbComm);
                        $book->setAlertComm($nbAlt);
                        $book->setAlertEpisodes($nbEpsAlt);
                    endif;
                    
                    if( $maxStEps > $book->getStatus()) : 
                        $book->setStatus($maxStEps);
                    endif;
                }  
            
                $this->books[] = $book;
            }
        
        }else{
            $this->books[] = new Book();
        }
    // var_dump($this->books);
    return $this->books;
   }

}