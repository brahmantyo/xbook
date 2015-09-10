<?php

class Validation {
    
    // form object
    private $objForm;
    
    // for storing all error ids
    private $_errors = array();
    
    // validation messages
    public $_message = array(
        "login" => "Input Login and / or Password cannot empty",
        "wrong-user" => "Maaf user salah",
        "login_user" => "User belum terisi atau tidak tersedia",
        "login_email" => "Format email masih salah",
        "login_password" => "Password belum terisi atau salah"
    );
    
    // list of expected fields
    public $_expected = array();
    
    // list of required fields
    public $_required = array();
    
    // list of special fields
    // array('field_name' => 'format')
    public $_special = array();
    
    // post array
    public $_post = array();
    
    // fields to be removed from $_post_array
    public $_post_remove = array();
    
    // fields to be specifically formatted
    // array('field_name' => 'format')
    public $_post_format = array();
    
    public function __construct($objForm) {
        $this->objForm = $objForm;
    }
    
    
    public function process(){
        if($this->objForm->isPost() && !empty($this->_required)){
            // get only expected fields and remove all other ones
            $this->_post = $this->objForm->getPostArray($this->_expected);
            if(!empty($this->_post)){
                foreach($this->_post as $key=>$value){
                    $this->check($key,$value);
                }
            }
        }
    }
    
    public function check($key,$value){
        if(!empty($this->_special) && array_key_exists($key, $this->_special)){
            
            $this->checkSpecial($key,$value);
        } else {
            if(in_array($key, $this->_required) && empty($value)){
                $this->add2Errors($key);
            }
        }
    }
    
    public function checkSpecial($key, $value){
        switch ($this->_special[$key]) {
            case 'email':
                
                if(!$this->isEmail($value)){
                    $this->add2Errors($key);
                }
            break;
        }
    }
    
    public function isEmail($email = NULL){
        if(!empty($email)){
            $result = filter_var($email, FILTER_VALIDATE_EMAIL);
            return !$result ? FALSE : TRUE;
        }
        return FALSE;
    }
    
    public function isValid(){
        $this->process();
        if(empty($this->_errors) && !empty($this->_post)){
            //remove all unwanted fields
            if(!empty($this->_post_remove)) {
                foreach ($this->_post_remove as $key => $value) {
                    unset($this->_post[$value]);
                }
            }
            //remove all required fields
            if(!empty($this->_post_format)){
                foreach($this->_post_format as $key=>$value){
                    $this->format($key,$value);
                }
            }
            return TRUE;
        }
        return FALSE;
    }
    
    public function add2Errors($key){
        $this->_errors[] = $key;
    }
    
    public function format($key, $value) {
        switch($value){
            case 'password':
                $this->_post[$key] = Login::string2hash($this->_post[$key]);
                break;
        }
    }
    
    public function validate($key){
        if(!empty($this->_errors)&& in_array($key, $this->_errors)){
            return $this->wrapWarn($this->_message[$key]);
        }
    }
    
    public function wrapWarn($mess = NULL){
        if(!empty($mess)){
            return "<span >{$mess}</span>";
        }
    }
}