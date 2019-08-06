<?php
class EpisodeManager
{
    protected static $_db; // Instance de PDO
    protected $selection ;
    protected $episodes = [] ;
    protected $query;
    private $_tab = 'episode';
    private $commentManager;
    
    public function __construct($modelName= null,$method= null)
    {    
        $_db = DB::getInstance();
        $this->commentManager = new CommentManager();
       
    }
/**
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
            $this->selection = DB::getInstance()->query('SELECT * from ' . $this->_tab . $orderBy,'',$this->_tab);
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
    
            if ($x < 2 || $keys[1] <= '999') : 
                $this->selection = DB::getInstance()->get($this->_tab, $ksel, $orderBy);
                $this->formatSelection($level);
            else:
                $this->selection = $this->findUnique($keys);
            endif;
        }  
        return $this->episodes;
    }

    /**
    * Gestion des mises à jour maj, del, add  table Episode de la base de données
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
    public function formatSelection($level)
    {
        if(isset($this->selection) && !empty($this->selection))
        {  
            foreach($this->selection as $table)
            {
                $episode = new Episode($table);
              
                if($level === 'N1') :
                // requete sur le livre de l' episode
                
                    $this->bookManager = new BookManager();
                    $bookInfo = $this->bookManager->getBooks($episode->getBookId(), $level); 
                    $episode->setBookInfo($bookInfo);

                               
                // requete sur tous les comments par episode
                    $refEps= $episode->getBookId() . '.' . $episode->getId();  
                    $comments = $this->commentManager->getSelection($refEps,$level);
                    $episode->setComments($comments);

                    // requete sur tous les commentaires non validés par episode
                    $altComm = $this->commentManager->getSelAlertComm($refEps,$level);
                    $episode->setAlertComm($altComm);
                endif;
                // var_dump($episode);
                $this->episodes[] = $episode;
            }
        }else{
            $this->episodes[] = new Episode([]);
        }
        return $this->episodes;
    }
    /**
    * Recherche dernier épisode
    * @return [objets]
    */
    public function findLast($parms=null,  $level ) // Regle Gestion: Mise en avant du dernier episode en statut 30
    {
        $orderBy = 'order by id DESC LIMIT 1';
        $this->selection = DB::getInstance()->query('SELECT * from ' . $this->_tab . " where status >= '30' " . $orderBy,'', $this->_tab);
        
        $this->formatSelection($level);
        return $this->episodes;
    }
    public function findAboutJFR($parms=null,  $level = null)
    {
        $this->selection = DB::getInstance()->query('SELECT * from ' . $this->_tab . " where status >= '20' order by chapter DESC LIMIT 1",'',$this->_tab);
        $this->formatSelection($level);
        return $this->episodes;
    }

    public function findUnique($keys=null,  $level = null)
    {
       
        if($keys[1] === 'A') :
            $orderBy = ' order by bookId, volume ASC, chapter ASC LIMIT 1';
        else:
            $orderBy = ' order by bookId, volume DESC, chapter DESC LIMIT 1';
        endif;

        $ksel = array(  'bookId'    , '=', $keys[0],
                        'status'    , '>', "10");

        $this->selection = DB::getInstance()->get($this->_tab, $ksel, $orderBy);
        $this->formatSelection($level);
        return $this->episodes;
    }


    public function getEpisodeId($parms=null,  $level = null)
    {
        if(isset($parms))
        {
            $keys = explode('.',$parms);
            $ksel = array('id'    , '=', $keys[0]);  
        
            $this->selection = DB::getInstance()->get($this->_tab, $ksel);
             $this->formatSelection($level);
        }  
      
        return $this->episodes;
    }
}
