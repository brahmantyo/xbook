<?php
class Form {
    
    public function isPost($field = NULL){
        if(!empty($field)) {
            if(isset($_POST[$field])) {
                return TRUE;
            }
            return FALSE;
        } else {
            if(!empty($_POST)){
                return TRUE;
            }
            return FALSE;
        }
    }
    
    public function getPost($field = NULL){
        if(!empty($field)){
            return $this->isPost($field)?
                strip_tags($_POST[$field]):
                NULL;
        }
    }
    public function getCountriesSelect($record = NULL){
        $objCountry = new Country();
        $countries = $objCountry->getCountries();
        
    }
    
    public function getPostArray($expected = null){
        $out = array();
        if($this->isPost()){
            foreach($_POST as $key=>$value){
                if(!empty($expected)){
                    if(in_array($key,$expected)){
                        $out[$key] = strip_tags($value);
                    }
                } else {
                        $out[$key] = strip_tags($value);
                }
            }
        }
        return $out;
    }
}
