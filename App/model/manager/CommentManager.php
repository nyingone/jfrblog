<?php
class CommentManager extends Manager
{

    protected $_tab = 'comment';
    protected $_selection ;
     
   
    private $_episodeManager;
    private $_bookManager;
    private $_comments ;
    
    public function __construct($modelName= null,$method= null)
    {   
        parent::__construct($this->_tab); 
        $_db = DB::getInstance();
    }

    public function majTab($class)
    {
        parent:: majTab($class); 
        if($_SESSION['previous'] === 'book') : 
            $ref = $class->getBookId(); 
        else:
            $ref = $class->getBookId() . '.' . $class->getEpsId(); 
        endif;
        Redirect::to( HOME . $_SESSION['redirect']);
    }

    /**
     * Comments selection via sql 
     * 
     * @param   string  (accès key from url $_POST)
     * @return  mixed   ([obj] ou false)
     */

    public function getSelection($parms=null, $level = null)
    {
        $orderBy = ' order by postDat DESC, status, id DESC ';
        if(!isset($parms))
        {
            $this->_selection = DB::getInstance()->query('SELECT * from ' . $this->_tab . $orderBy,'',$this->_tab);
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
                                    'epsId'     , '=', $keys[1]);  
                }else{
                    if($x === 3)
                    {
                    $ksel = array(  'bookId'    , '=', $keys[0],
                                    'epsId'     , '=', $keys[1],
                                    'id'        , '=', $keys[2]);
                    }
                }
            }
            if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] === false) :
                $ksel[] = 'status';
                $ksel[] = '>=';
                $ksel[] = '20';
            endif;

            // $this->selection = DB::getInstance()->get($this->_tab, array('id', '=', $parms));
            $this->_selection = DB::getInstance()->get($this->_tab, $ksel, $orderBy);
        }  
        
        $this->formatSelection($level);

        return $this->_comments;
    }

    /**
     * Alert on comments for Admin to confirm ( status < 20 = New / = 20 = signaled by passer by )
     * 
     * @param   string  (accès key from url $_POST)
     * @return  mixed   ([] ou false)
     */
    public function getSelAlertComm($parms=null)
    {
        $keys = explode('.',$parms);
        $ksel = array(  'bookId'   , '=' , $keys[0],
                        'epsId'    , '=' , $keys[1],
                        'status'   , '<' , '30');  
        
        $this->_selection = DB::getInstance()->get($this->_tab, $ksel);
        
        return $this->_selection;
    }

    /**
    * Format - as Object Table,  and add objects infos to sql result table
     * 
     * @param    [[]]     
     * @return   [objets]
     */
    public function formatSelection($level = null)
    {
        if(isset($this->_selection) && !empty($this->_selection))
        {  
            foreach($this->_selection as $table)
            {
                 $comment = new Comment($table);
                         // recup infos sur le livre
                 if($level ===  'N2'):
                    $this->bookManager = new BookManager();
                    $bookInfo = $this->bookManager->getBooks($comment->getBookId(),$level);
                    $comment->setBookInfo($bookInfo);
                                                  
                   $this->episodeManager = new EpisodeManager();
                    $episodeInfo = $this->episodeManager->getEpisodeId($comment->getEpsId(), $level);
                    $comment->setEpisodeInfo($episodeInfo);

                endif;
               $this->_comments[] = $comment;
            }
        }

        return $this->_comments;
    }

    /**
    * Direct acces to comment record via id.
    * @param    (int)  $id 
    *           (mixed) level(N0 à N2) or null
    *  @return   [objets]
    */
    public function getCommentId($id,  $level = null)
    {
        if(isset($id))
        {
            $ksel = array('id'    , '=', $id);  
            $this->_selection = DB::getInstance()->get($this->_tab, $ksel);
            $this->formatSelection($level);
        }  
        return $this->_comments;
    }
}
