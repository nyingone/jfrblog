<?php

class DB
{
    private static $_instance = null;
    private $_pdo; 
    private $_query = null; 
    private $_error = false;
    private $_results = null;
    private $_count = 0;
    protected $dspffd= [];
    
    protected $_optf= 'select'; 

    private function __construct()
    {
       // ???  PDOStatement::closeCursor() ;
        try
        {
            $this->_pdo = new PDO('mysql:host=' . Config::get('mysql/host') . 
                                ';dbname=' . Config::get('mysql/dbname') .'; charset=utf8'
                                    ,Config::get('mysql/username') ,Config::get('mysql/password'),
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        }
        catch (PDOException $e)
        {
            die('Erreur : ' . $e->getMessage());
        }
    }

    public static function getInstance()
    {
        if(!isset(self::$_instance))
        {
            self::$_instance = new DB();
        }
        return self::$_instance;
    }
/**
 * @params $sql
 * @params  
 */
    public function query($sql,$params= [] ,  $table =null )
    {
        if($this->_query = $this->_pdo->prepare($sql))
        { 
           
            if(is_array($params) && count($params))
            { 
                $x = 1;
               // echo '<br /> liste paramètres to bind';
                
                foreach($params as $parm)
                {   
                    $y = 0;
                    if(is_array($parm))
                    {
                        for($y = 0; $y < count($parm); ++$y)
                        {
                            $val = $parm[$y];
                            $this->_query->bindValue($x, $val); 
                        $x++;
                        }
                        
                    }else{
                        if(is_object($parm)) : // It's probably a date
                            $val = $parm->format('Y-m-d H:i:s');
                        else:
                            $val = $parm;        
                        endif;                       
                        $this->_query->bindValue($x, $val);   
                        $x++;
                    }   
                    
                }
            }
            
            if($this->_query->execute())
            {  
                if( $this->_optf == 'select')
                {
                    $this->_results = $this->_query->fetchAll(PDO::FETCH_ASSOC);
    
                    $this->_count = $this->_query->rowCount();
                    $this->_query->closeCursor();
                    return $this->_results;  
                }
                return true;
                //             
            } else{
                $this->_error = true;
            }
        }else{
            $this->_error = true;   
        }
        return $this->_error;
    }


    public function action($action, $table, $join = null ,  $where = array(), $orderBy= null)
    {
        if(count($where) >= 3 )
        {
            $size = 3;
            $operators = array('=','>','<', '>=', '<=','<>');
            $filter = array_chunk ( $where , $size);
            $y = 0;
            foreach($filter as $sel)
            {
               
                $x = 0;
                $y++;
                $field = $sel[$x];
                $operator = $sel[$x+1];
                $value[] = $sel[$x+2];

                if(in_array($operator,$operators))
                {
                    if($y == 1):
                        $sql = "($action $table $join WHERE $field $operator ? ";   
                    else:
                        $sql .= " and $field $operator ? ";
                    endif;
                }
            }
        

            $sql .= "  ". $orderBy;
            $sql .= " )";
            
            if($this->query($sql,array($value),$table))
            {   
                $this->_query->closeCursor();
               
                return $this->results(); 
            }else{
                return false;
            }         
        }else{
            return false;
        }   
    }
        

    public function get($table, $where , $orderBy= null, $action = null, $join = null)
    {
     
        if (is_null($action)) :  
            return $this->action('SELECT * FROM', $table , $join, $where, $orderBy);
        else:
            return $this->action($action, $table , $join, $where, $orderBy);
        endif;
    }

   
    public function count()
    {
        return $this->_count;
    }

    public function results()
    {
        return $this->_results;
    }

    public function first()
    {
    //    return $this->results()->_results[0];
        return $this->_results[0];
    }

    public function error()
    {
        return $this->_error;
    }

    //******************************************************* */  
    public function addClsRcd($table, $class)
    {
       $this->_optf = 'insert';
       
        return $this->gstFfd($table, $class, $this->_optf);  
    }

    public function dltClsRcd($table, $class)
    {
        $this->_optf = 'delete';
        $id = $class->getId();     
        $sql = "DELETE FROM {$table}  WHERE id = {$id} LIMIT 1";
        return $this->query($sql);
    }


    public function updClsRcd($table, $class)
    {
        $this->_optf = 'update';
        return $this->gstFfd($table, $class); 
    }

    public function gstFfd($table, $class)
    {
        $optsav = $this->_optf;  // update insert => result bool.
        $this->_optf = 'select'; // forçage pour récup table ffd
        $this->dspffd = $class->getFfd($table);
        $this->_optf = $optsav;
    
         if (!empty($this->dspffd))
        {       
            $values = ' ';
            $set = ' ';
            $x = 1;
            foreach($this->dspffd as $zone) 
            {
                $field = implode($zone);
                $fieldNames[] = $field;  
                $method = 'get' . ucfirst($field);
                if(method_exists($class, $method))
                {
                    $fields[] = $class->$method('*');
                    if($field == 'id')
                    {
                        $id = $class->$method();
                    }
                }
                if ($this->_optf == 'insert') 
                {
                    $values .= "?";
                }else{
                    if (  $this->_optf == 'update') 
                    {
                    $set .= "{$field} = ?";
                    }
                }
                
                if($x < count($this->dspffd))
                {
                    if (  $this->_optf == 'insert') 
                    {
                        $values .= ", ";
                    }else{
                        if (  $this->_optf == 'update') 
                        {   
                        $set .= ", ";
                        }
                    }
                } 
                $x++;
            }
            
            
            if (  $this->_optf == 'insert') 
            {
                $sql = "INSERT INTO " . $table . " (" . implode(",", $fieldNames) . ") " . "VALUES({$values})";
            }else{
                if (  $this->_optf == 'update') 
                {   
                    $sql = "UPDATE {$table} SET  {$set} WHERE id = {$id} LIMIT 1";
                }
            }   
       
          return $this->query($sql, $fields);
            
        }else{
            return false;
        }
    }

}