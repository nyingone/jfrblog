<?php

class DB
{
    private static $_instance = null;
    private $_pdo; 
    private $_query; 
    private $_error = false;
    private $_results;
    private $_count =0;
    
    protected $_optf= ''; 

    private function __construct()
    {
        try
        {
            $this->_pdo = new PDO(   'mysql:host=' . Config::get('mysql/host') . 
                                    ';dbname=' . Config::get('mysql/dbname')
                                    ,Config::get('mysql/username') ,Config::get('mysql/password'),
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        echo 'connected';
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
    public function query($sql,$params= array())
    {
        $this->error = false;
        if($this->_query = $this->_pdo->prepare($sql))
        { 
           
            if(is_array($params) && count($params))
            { $x = 1;
               // echo '<br /> liste paramètres to bind';
                foreach($params as $parm)
                {
                    $this->_query->bindValue($x, $parm);
                    $x++;
                }
            }
            if($this->_query->execute())
            {  
                if(! $this->_optf == 'insert')
                {
                    $this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
                    $this->_count = $this->_query->rowCount();
                }
                                
            } else{
                $this->_error = true;
         
            }
        }
        return $this;
        return $this->_results;
    }


  public function action($action, $table, $where = array())
    {
        if(count($where) === 3)
        {
            $operators = array('=','>','<', '>=', '<=','<>');
            $field = $where[0];
            $operator= $where[1];
            $value = $where[2];

            if(in_array($operator,$operators))
            {
                $sql = "($action $table WHERE $field $operator ?)";
                
                if(!$this->query($sql,array($value),[])->error())
                {
                    return $this;
                }

            }

        }
        return false;
    }

    public function get($table, $where )
    {
        return $this->action('SELECT * FROM', $table, $where);
    }

    public function delete($table, $where = array())
    {
        return $this->action('SELECT ', $table, $where);
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
            if(!$this->query($sql, $fields)->error())
            {
            return true;
            }
           
        }else
        {
            return false;
        }
    }

    public function update($table, $id, $fields = array())
    {
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

        $sql = "UPDATE {$tableE} SET  {$set} WHERE id = {$id}";
        if(!$this->query($sql, $fields)->error())
        {
        return true;
        }else{
            return false;
        }
        
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
        return $this->results()->_results[0];
    }

    public function error()
    {
        return $this->error;
    }
}