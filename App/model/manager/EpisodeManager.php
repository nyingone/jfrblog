<?php
class EpisodeManager extends Manager
{
     // protected static $_db; // Instance de PDO
    protected   $_tab = 'episode';
    protected   $_selection ;
    protected   $_episodes = [] ;
       
    private     $_commentManager;
    private     $_bookManager;
    // protected $_entity;
   //  private $_entityFields;

    
    public function __construct($modelName= null,$method= null)
    {    
        parent::__construct($this->_tab);
        $this->_commentManager = new CommentManager();
    }

    public function majTab($class)
    {
        parent:: majTab($class); 
        Redirect::to($this->_tab . '/' . 'index-' . $class->getBookId());
    }

/**
 * 
    * Sélection Episodes pour affichage liste ou sélection
    * @param string (klist)
    * @return array [objets] ou null
    */
    public function getSelection($parms=null,  $level = null)
    {
       //  var_dump($level, $parms); die;
        $orderBy = ' order by bookId, volume DESC, chapter DESC ';
        if(!isset($parms))
        {
            $this->_selection = DB::getInstance()->query('SELECT * from ' . $this->_tab . $orderBy,'',$this->_tab);
            $this->formatSelection($level);
        }else
        {
            $keys = explode('.',$parms);
            
            $x = count($keys);
          
            if($x === 1)
            {
                $ksel = array('bookId'    , '=', $keys[0]);  
        
            }else{
                if($x === 2)
                {
                    $ksel = array(  'bookId'    , '=', $keys[0],
                                    'volume'    , '=', $keys[1]);  
                }else{
                    
                    $ksel = array(  'bookId'    , '=', $keys[0],
                                    'volume'    , '=', $keys[1],
                                    'id'        , '=', $keys[2]);  
                }
            }
            // $this->selection = DB::getInstance()->get($this->_tab, array('id', '=', $parms));
            if(!isset($_SESSION['logged_in'])) :
                $ksel[] = 'status';
                $ksel[] = '>';
                $ksel[] = '10';
            endif;
            
            if ($x < 2 || $keys[1] <= '999') : 
                $this->_selection = DB::getInstance()->get($this->_tab, $ksel, $orderBy);
                $this->formatSelection($level);
            else:
                $this->_selection = $this->findUnique($keys, 'N1');
            endif;
        }  
        return $this->_episodes;
    }

    /**
    
   
    * Formatte tableau d'objets à partir des sélections
    * @return [objets]
    */
    public function formatSelection($level)
    {
        if(isset($this->_selection) && !empty($this->_selection))
        {  
            foreach($this->_selection as $table)
            {
                 $episode = new Episode($table);
              
                if($level === 'N1') :
                // requete sur le livre de l' episode
                
                    $this->_bookManager = new BookManager();
                    $bookInfo = $this->_bookManager->getBooks($episode->getBookId(), $level); 
                    $episode->setBookInfo($bookInfo[0]);
                endif;  

                if($level === 'N1' || $level === 'N0') :          
                // requete sur tous les comments par episode  @return  [obj commentaires]  Last In Fist Out 
                    $refEps= $episode->getBookId() . '.' . $episode->getId();  
                    $comments = $this->_commentManager->getSelection($refEps,$level);
                    $episode->setComments($comments);
                             
                    if(is_array($comments)) :
                        $comment = $comments[0];
                        $episode->setLastCommented($comment->getPostDat());
                    endif;

                // requete sur tous les commentaires non validés/et/ou signalés  @return  [obj commentaires]
                    $altComm = $this->_commentManager->getSelAlertComm($refEps,$level);
                    $episode->setAlertComm($altComm);
                endif;
                
                $this->_episodes[] = $episode;
            }
        }else{
            $this->_episodes[] = new Episode([]);
        }
        return $this->_episodes;
    }
    /**
    * Recherche dernier épisode
    * @return [objets]
    */
    public function findLast($parms=null,  $level ) // Regle Gestion: Mise en avant du dernier episode en statut 30 en ligne + validé
    {
        
        $action = "select " . $this->_entityFields . " FROM ";
        $orderBy = 'order by episode.id DESC LIMIT 1';
        $join = ' inner join book on bookId = book.id ';  // ramène Id book au lieu de id Episode
        $ksel = array(  'episode.status'    , '>=', '30',
                        'book.promoted'  , '=', 1);  
        $this->selectionGet($action, $join, $ksel, $orderBy, $level);
        return $this->_episodes;
    }


    public function selectionGet($action, $join, $ksel, $orderBy, $level)
    {
        $this->_selection = DB::getInstance()->get($this->_tab, $ksel, $orderBy, $action, $join);
        $this->formatSelection($level);
    }

    public function findAboutJFR($parms=null,  $level = null)
    {
        $action = "select " . $this->_entityFields . " FROM ";
        $orderBy = 'order by chapter DESC LIMIT 1';
        $join = ' inner join book on bookId = book.id ';  // 
        $ksel = array(  'episode.status'    , '>=', '20',
                        'episode.status'    , '<', '90',
                        'book.blogged'  , '=', 1);  
        $this->selectionGet($action, $join, $ksel, $orderBy, $level);
        return $this->_episodes;
    }

    public function findUnique($keys=null,  $level = null)
    {
       
        if($keys[1] === 'A') :
            $orderBy = ' order by bookId, volume ASC, chapter ASC LIMIT 1';
        else:
            $orderBy = ' order by bookId, volume DESC, chapter DESC LIMIT 1';
        endif;

        $ksel = array(  'bookId'    , '=' , $keys[0],
                        'status'    , '>=', "30",
                        'status'    , '<' , "90");

        $this->_selection = DB::getInstance()->get($this->_tab, $ksel, $orderBy);
        $this->formatSelection($level);
        return $this->_episodes;
    }


    public function getEpisodeId($parms=null,  $level = null)
    {
        if(isset($parms))
        {
            $keys = explode('.',$parms);
            $ksel = array('id'    , '=', $keys[0]);  
        
            $this->_selection = DB::getInstance()->get($this->_tab, $ksel);
             $this->formatSelection($level);
        }  
      
        return $this->_episodes;
    }
}
