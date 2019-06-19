<?php
class EpisodeManager
{
    protected $selection ;
    protected $query;
    private $_tab = 'episode';


    public function __construct($modelName,$method)
    {    
        $_db = DB::getInstance();
    }

    public function getSelection($parms=null)
    {
        if(!isset($parms))
        {
            $this->selection = DB::getInstance()->query('SELECT * from ' . $_tab . 'order by id, chapter DESC','',$_tab);
        }else{
            $this->books = DB::getInstance()->get($_tab, array('id', '=', $parms));
        }
        $x = 0;
        if(isset($this->selection) && !empty($this->selection))
        {
          
            foreach($this->selection as $table)
            {
                $this->selection[$x] = new Episode($table);
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
        $fields = [
            'id'        => $id,
            'title'     => Input::get('title'),
            'plot'      => Input::get('plot'),
           // 'onlineDat' => (empty(Input::get('onlineDat'))) ? null : Input::get('onlineDat') , // date('Y-m-d H:i:s'),
            'onlineDat' =>  (Input::get('onlineDat') !='') ? date('Y-m-d', strtotime(Input::get('onlineDat'))) : null , 
            'nbEps'     => (int) Input::get('nbEps'),
            'status'    => Input::get('status'),
            'isbn'      => Input::get('isbn'),
            'editYear'  => (int) Input::get('editYear') 
        ];
        if(isset($_POST['id']) && $_POST['id'] > 0)
        {
           $succes = DB::getInstance()->update($this->_tab, $id, $fields);
           // if(!DB::getInstance()->update($this->_tab, $id, $fields))
            if($succes == false)
            {
                throw new Exception('problem de maj' . $this->_tab);
            }else{
                Session::flash($this->_tab, 'maj successful' );
            }
        }
        else{
            $episode = new Episode($fields);
            $succes = DB::getInstance()->insert($this->_tab, $fields);
            if($succes == false)
            {
                throw new Exception('problem de creation' . $this->_tab);
            }else{
                Session::flash($this->_tab, 'crt successful' );
                // header('location: index.phtml');
                Redirect::to($this->_tab);
            }  
        }
    }

}