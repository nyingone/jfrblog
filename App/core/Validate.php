<?php

class Validate{

    private $_passed = false;
    private $_errors = array();
    private $_db = null;
    private $_entity = null;
    protected $class;

    public function __construct(){
        $this->_db = DB::getInstance();
        
    }

    public function check($source, $tab, $items = array()) 
    {
        var_dump($source);
        $this->_entity = $tab;
        foreach($items as $item => $rules)
        {
            foreach($rules as $rule => $rule_value)
            {
                if(is_object($source[$item])) : 
                    $value = $source[$item]->format("Y-m-d");
                else:     
                    $value = trim($source[$item]);
                endif;
                $item = escape($item);

                if($rule === 'required' && $rule_value == true && empty($value))
                {
                    $this->addError("Renseigner obligatoirement l'information:   {$item}  ");
                } else if(!empty($value)){
                    switch($rule)
                    {
                        case 'min':
                        if(strlen($value) < $rule_value){
                            $this->addError("Saisir un minimum de  {$rule_value} caractères pour {$item} ");
                        }
                        break;
                        case 'max':
                        if(strlen($value) > $rule_value){
                            $this->addError("Saisir un maximum de  {$rule_value} caractères pour {$item} ");
                        }
                        break;
                        case 'matches':
                        if(($value) != $source[$rule_value]){
                            $this->addError("{$rule_value} et {$item} doivent correspondre");
                        }
                        break;
                        case 'unique':
                      //  $check = $this->_db->get($rule_value,array($item, '=' , $value));
                        $check = $this->_db->get($this->_entity,array($item, '=' , $value));

                        if(null !== $check)
                        {
                            $this->addError("{$item} / {$value} existe déjà ");
                        }
                        break;
                    }
                }
            }
        }

        if(empty($this->_errors)){
            $this->_passed = true;
            if(isset($tab))
            {
                $this->class = new $tab($source);
                return [$this->_passed , $this->class];
            }else{
                return [$this->_passed , null];
            }
    
            
        }
    }

    private function addError($error){
        $this->_errors[] = $error;
    }

    public function errors(){
        return $this->_errors;
    }

    public function passed(){
        return $this->_passed;
    }
}