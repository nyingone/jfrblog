<?php
class EpisodeManager
{
    protected $selection ;
    protected static $_db; // Instance de PDO
    protected $query;
    private $_tab = 'episode';


    public function __construct($modelName= null,$method= null)
    {    
        $_db = DB::getInstance();
    }

    public function getSelection($parms=null)
    {
        if(!isset($parms))
        {
            $this->selection = DB::getInstance()->query('SELECT * from ' . $this->_tab,'',$this->_tab);
        }else{
            $this->selection = DB::getInstance()->get($this->_tab, array('id', '=', $parms));
        }
        $x = 0;
        if(isset($this->selection) && !empty($this->selection))
        {
          
            foreach($this->selection as $table)
            {
                $episode = new Episode($table);
                $this->selection[$x] = $episode;
                $x++;
            }
          
        }else{
            $this->selection[] = new Episode([]);
        }
        return $this->selection;
    }

    public function majTab($fields = array())
    {
     
        if(isset($_POST['id']) && $_POST['id'] > 0){
            $id = $_POST['id'];
        }else{
            $id = null;
        }     
        
        if($_POST['action'] == 'del')
        {
            $this->delExec($this->_tab, $id,[]);
        }else{
     
            $fields = [
            'id'        => $id,
            'chapter'     => Input::get('chapter'),
            'quote'      => Input::get('quote'),
           // 'onlineDat' => (empty(Input::get('onlineDat'))) ? null : Input::get('onlineDat') , // date('Y-m-d H:i:s'),
            'onlineDat' =>  (Input::get('onlineDat') !='') ? date('Y-m-d', strtotime(Input::get('onlineDat'))) : null , 
            'nbEps'     => (int) Input::get('nbEps'),
            'status'    => Input::get('status'),
            'isbn'      => Input::get('isbn'),
            'editYear'  => (int) Input::get('editYear') 
            ];

            if(isset($_POST['id']) && $_POST['id'] > 0)
            {
                $this->selExec($this->_tab, $id, $fields);
              
            }else{
                $episode = new Episode($fields);
                $this->addExec($this->_tab, $fields);
                
            }   
               
        }
        // Redirect::to($this->_tab);
    }

    function selExec($tab, $id, $fields)
    {
        $succes = DB::getInstance()->update($tab, $id, $fields);
        if($succes == false)
        {
            throw new Exception('problem de maj' . $tab);
        }else{
            Session::flash($tab, 'maj successful' );
        }
    }

    function addExec($tab,  $fields)
    {
        $succes = DB::getInstance()->insert($tab, $fields);
        if($succes == false)
        {
            throw new Exception('problem de creation' . $tab);
        }else{
            Session::flash($tab, 'crt successful' );
        }  
    }

    function delExec($tab, $id,$fields)
    {
        $succes = DB::getInstance()->delete($tab, $id,[]);
        if($succes == false)
        {
            throw new Exception('problem de suppression' . $tab);
        }else{
            Session::flash($tab, 'delete successful' );
        }
    }    
    
    function findLast()
    {

    }
}