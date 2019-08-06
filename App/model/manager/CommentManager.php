<?php
class CommentManager
{
    protected static $_db; // Instance de PDO
    protected $selection ;
    protected $comments ;
    protected $query;
    private $_tab = 'comment';
    private $episodeManager;
    private $bookManager;
    
    public function __construct($modelName= null,$method= null)
    {    
        $_db = DB::getInstance();
    }
/**
    * Sélection comments pour affichage liste ou sélection
    * @param string (klist)
    * @return array [objets] ou null
    */
    public function getSelection($parms=null, $level = null)
    {
        if(!isset($parms))
        {
            $this->selection = DB::getInstance()->query('SELECT * from ' . $this->_tab,'',$this->_tab);
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
            // $this->selection = DB::getInstance()->get($this->_tab, array('id', '=', $parms));
            $this->selection = DB::getInstance()->get($this->_tab, $ksel);
        }  
        
        $this->formatSelection($level);

        return $this->comments;
    }

    public function getSelAlertComm($parms=null)
    {
        $keys = explode('.',$parms);
        $ksel = array(  'bookId'   , '=' , $keys[0],
                        'epsId'    , '=' , $keys[1],
                        'status'   , '<' , '20');  
        
        $this->selection = DB::getInstance()->get($this->_tab, $ksel);
        // var_dump($this->selection); die;
        return $this->selection;
    }

    /**
    * Gestion des mises à jour maj, del, add  table comment de la base de données
    * @param objet class
    * @return [objets]
    */
    public function majTab($class)
    { 
             
        if(isset($_POST['id']) && $_POST['id'] > 0){
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
    }
    /**
    * Formatte tableau d'objets à partir des sélections
    * @return [objets]
    */
    public function formatSelection($level = null)
    {
        if(isset($this->selection) && !empty($this->selection))
        {  
            foreach($this->selection as $table)
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
               $this->comments[] = $comment;
            }
        }else{
            $this->comments[] = new Comment([]);
        }
        return $this->comments;
    }
    /**
    * Accès par Id pour suppression et validation 
    * @param
    * @return 
    */
    public function getCommentId($id,  $level = null)
    {
        if(isset($id))
        {
            $ksel = array('id'    , '=', $id);  
        
            $this->selection = DB::getInstance()->get($this->_tab, $ksel);
             $this->formatSelection($level);
        }  
      
        return $this->comments;
    }
    
}
