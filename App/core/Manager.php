<?php

class Manager
{
    protected static $_db; // Instance de PDO
    protected static $_visit; // Instance de session visiteur
   
    protected $_tab;
    protected $_entity;
    protected $_entityFields;

    
    public function __construct($tableName= null,$method= null)
    {    
        $_db = DB::getInstance();
        $_visit = Session::getInstance();

        $this->setTab($tableName);
        $this->setEntity($tableName);
    }


    public function setTab($tableName)
    {
        $this->_tab = $tableName;
    }

    public function setEntity($tableName)
    {
        $entityName = ucfirst($tableName);   
        $this->_entity = new $entityName([]);

        $fieldList =  $this->_entity->getFfd($this->_tab );
        foreach ($fieldList as $field => $specs):
            foreach ($specs as $spec => $value):
                if($spec = 'COLUMN_NAME'):
                     $extractFields[] =  $this->_tab . '.' . $value;
                endif;
            endforeach;
        endforeach;
        $this->_entityFields = implode($extractFields, ',');
    }


    /* Management of data base updates for this entity
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
}