<?php
class EpisodeManager
{
    protected static $_db; // Instance de PDO
    protected $selection ;
   
    protected $episodes = [] ;
    protected $query;

    private $_tab = 'episode';
    private $_commentManager;
    private $_bookManager;
    private $_entity;
    private $_entityFields;

    
    public function __construct($modelName= null,$method= null)
    {    
        $_db = DB::getInstance();
       
        
        $this->_entity = new Episode([]);
        $fieldList =  $this->_entity->getFfd($this->_tab );
        foreach ($fieldList as $field => $specs):
            foreach ($specs as $spec => $value):
                if($spec = 'COLUMN_NAME'):
                     $extractFields[] =  $this->_tab . '.' . $value;
                endif;
            endforeach;
        endforeach;
        $this->_entityFields = implode($extractFields, ',');

        $this->_commentManager = new CommentManager();
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
            if(!isset($_SESSION['logged_in'])) :
                $ksel[] = 'status';
                $ksel[] = '>';
                $ksel[] = '10';
            endif;
            
            if ($x < 2 || $keys[1] <= '999') : 
                $this->selection = DB::getInstance()->get($this->_tab, $ksel, $orderBy);
                $this->formatSelection($level);
            else:
                $this->selection = $this->findUnique($keys, 'N1');
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
                
                    $this->_bookManager = new BookManager();
                    $bookInfo = $this->_bookManager->getBooks($episode->getBookId(), $level); 
                    $episode->setBookInfo($bookInfo);
                endif;  

                if($level === 'N1' || $level === 'N0') :          
                // requete sur tous les comments par episode
                    $refEps= $episode->getBookId() . '.' . $episode->getId();  
                    $comments = $this->_commentManager->getSelection($refEps,$level);
                    $episode->setComments($comments);
                    // var_dump($comments);
                    if(is_array($comments)) :
                        $comment = $comments[0];
                        $episode->setLastCommented($comment->getPostDat());
                    endif;
                    // requete sur tous les commentaires non validés par episode
                    $altComm = $this->_commentManager->getSelAlertComm($refEps,$level);
                    $episode->setAlertComm($altComm);
                endif;
                
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
    public function findLast($parms=null,  $level ) // Regle Gestion: Mise en avant du dernier episode en statut 30 en ligne + validé
    {
        
        $action = "select " . $this->_entityFields . " FROM ";
        $orderBy = 'order by episode.id DESC LIMIT 1';
        $join = ' inner join book on bookId = book.id ';  // ramène Id book au lieu de id Episode
        $ksel = array(  'episode.status'    , '>=', '30',
                        'book.promoted'  , '=', 1);  
        $this->selectionGet($action, $join, $ksel, $orderBy, $level);
        return $this->episodes;
    }

    public function selectionGet($action, $join, $ksel, $orderBy, $level)
    {
        $this->selection = DB::getInstance()->get($this->_tab, $ksel, $orderBy, $action, $join);
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
        return $this->episodes;
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
