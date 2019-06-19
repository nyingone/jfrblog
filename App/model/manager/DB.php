<?php

class DB
{
    private static $_instance = null;
    private $_pdo; 
    private $_query; 
    private $_error = false;
    private $_results;
    private $_count =0;
    
    protected $_optf= 'select'; 

    private function __construct()
    {
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
    public function query($sql,$params= [] , $table =null)
    {
        if($this->_query = $this->_pdo->prepare($sql))
        { 
           
            if(is_array($params) && count($params))
            { 
                $x = 1;
               // echo '<br /> liste paramètres to bind';
                foreach($params as $parm)
                {   
                    if(is_array($parm))
                    {
                        $val = $parm[0];
                    }else{
                        $val = $parm;
                    }
                    $this->_query->bindValue($x, $val);
                    $x++;
                }
            }
            if($this->_query->execute())
            {  
                if( $this->_optf == 'select')
                {
                    $this->_results = $this->_query->fetchAll(PDO::FETCH_ASSOC);
    
                    $this->_count = $this->_query->rowCount();
                    return $this->_results;  
                }
                return true;
                // return $this->errors();                 
            } else{
                $this->_error = true;
            }
        }else{
            $this->_error = true;   
        }
        return $this->_error;
    }


  public function action($action, $table, $where = array())
    {
        if(count($where) === 3)
        {
            $operators = array('=','>','<', '>=', '<=','<>');
            $field = $where[0];
            $operator = $where[1];
            $value[] = $where[2];
            if(in_array($operator,$operators))
            {
                $sql = "($action $table WHERE $field $operator ?)";
               // var_dump($sql);
                // if(!$this->query($sql,array($value),[])->error())
                if($this->query($sql,array($value),$table))
                {
                    return $this->results(); 
                }
            }
        }else{
            return false;
        }   
    }
        

    public function get($table, $where )
    {
      // var_dump($table, $where);
       return $this->action('SELECT * FROM', $table , $where);
    }

    

    public function ctlffd($table)
    {
        $sql = 'SELECT * FROM ' . $table . ' LIMIT 1 ' ;
        $opt = 'FETCH_ALL';
        $this-> _ffd = $this->getInstance()->query($sql, '', $opt );
        if(!$this->query($sql,  $this->_ffd,$opt)->error())
        {
            $this->_ffd = $this->_results;
            return $this->_ffd;
        }else{
            var_dump('<br /> erreur ', $this->_ffd); die; 
        }
       
    }

    public function insert($table, $fields = array())
    {
 
        if(count($fields))
        {       
            $keys = array_keys($fields);
            $values = ' ';
            $x = 1;
                foreach($fields as $field)
            {
                $values .= "?";
                if($x < count($fields))
                {
                    $values .= ", ";
                }
                $x++;
            }
         //   $sql = "INSERT INTO " . $table . " ('" . implode("','", $keys) . "') " . "VALUES({$values})";
            $sql = "INSERT INTO " . $table . " (" . implode(",", $keys) . ") " . "VALUES({$values})";
            $this->_optf = 'insert';
            return $this->query($sql, $fields);         
        }else
        {
            return false;
        }
    }

    public function update($table, $id, $fields = array())
    {
        $this->_optf = 'update';
        $set = '';
        $x = 1;
     //   $sql = "UPDATE " . $TABLE . "SET password = 'newPassword where id = X";
        foreach($fields as $name => $value)
        {
            $set .= "{$name} = ?";
            if($x < count($fields))
            {
                $set .= ", ";
            }
            $x++;
        }

        $sql = "UPDATE {$table} SET  {$set} WHERE id = {$id} LIMIT 1";
        return $this->query($sql, $fields);
                
    }

    public function delete($table, $id, $fields = array())
    {
        $this->_optf = 'delete';
        
        $sql = "DELETE FROM {$table}  WHERE id = {$id} LIMIT 1";
        var_dump($sql);
        return $this->query($sql, $fields);
                
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
}