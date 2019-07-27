<?php
class CommentManager
{
    protected static $_db; // Instance de PDO
    protected $selection ;
    protected $query;
    private $_tab = 'comment';
    
    public function __construct($modelName= null,$method= null)
    {    
        $_db = DB::getInstance();
    }
/**
    * Sélection comments pour affichage liste ou sélection
    * @param string (klist)
    * @return array [objets] ou null
    */
    public function getSelection($parms=null)
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
                                    'epsId'    , '=', $keys[1]);  
                }else{
                    $ksel = array(  'bookId'    , '=', $keys[0],
                                    'epsId'    , '=', $keys[1],
                                    'id'        , '=', $keys[2]);  
                }
            }
            // $this->selection = DB::getInstance()->get($this->_tab, array('id', '=', $parms));
            $this->selection = DB::getInstance()->get($this->_tab, $ksel);
        }  
        $this->formatSelection();

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
    public function formatSelection()
    {
        
        if(isset($this->selection) && !empty($this->selection))
        {  
            $x = 0;
            foreach($this->selection as $table)
            {
                $comment = new Comment($table);
                $this->selection[$x] = $comment;
                $x++;  
                // att. conserver $x sinon crée un tableau de tableau et non un tableau d'objet
            }
        }else{
            $this->selection[] = new Comment([]);
        }
        return $this->selection;
    }
    /**
    * Recherche dernier épisode
    * @return [objets]
    */
    
}
