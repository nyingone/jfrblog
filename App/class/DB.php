<?php

class DB
{
    private static $_instance = null;
    private $_pdo; 
    private $_query; 
    private $_error = false;
    private $_results;
    private $_count =0;

    private function __construct()
    {
        try
        {
            $this->pdo = new PDO(   'mysql:host=' . Config::get('mysql/host') . 
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
        if($this->_query = $this->pdo->prepare($sql))
        { 
            echo 'ok prepare';
            if(count($params))
            {
                foreach($params as $parm)
                {
                    $this->_query->bindValue($x, $parm);
                    $x++;
                }
            }
            if($this->_query->execute())
            {
                echo 'qry prepare lancé avec succes';
                $this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
                $this->_count = $this->_query->rowCount();
            } else{
                $this->_error = true;
            }
        }
        return $this;
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
                $sql = "($action FROM $table WHERE $fied $operator ?)";
                
                if(!$this->_query($sql,array($value))->error())
                {
                    return $this;
                }

            }

        }
        return false;
    }

    public function get($table, $where = array())
    {
        return $this->action('SELECT *', $table, $where);
    }

    public function delete($table, $where = array())
    {
        return $this->action('SELECT *', $table, $where);
    }

    public function add()
    {

    }

    public function count()
    {
        return $this->_count;
    }

    public function error()
    {
        return $this->error;
    }
}