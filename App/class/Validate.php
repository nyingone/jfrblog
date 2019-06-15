<?php

class Validate{

    private $_passed = false;
    private $_errors = array();
    private $_db = null;
    private $_entity = null;

    public function __construct(){
        $this->_db = DB::getInstance();
        
    }

    public function check($source, $tab, $items = array())
    {
        $this->_entity = $tab;
        foreach($items as $item => $rules)
        {
            foreach($rules as $rule => $rule_value)
            {
                $value = trim($source[$item]);
                $item = escape($item);
                if($rule === 'required' && $rule_value == true && empty($value))
                {
                    $this->addError("Renseigner obligatoirement:   {$item}  ");
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

                        if($check->count()){
                            $this->addError("{$item} / {$value} existe déjà ");
                        }
                        break;
                    }
                }
            }
        }

        if(empty($this->_errors)){
            $this->_passed = true;
        return $this;
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