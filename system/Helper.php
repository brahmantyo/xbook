<?php
class Helper {
    public static function getActive($page = null) {
        if(!empty($page)){
            if(is_array($page)){
                $error = array();
                foreach ($page as $key => $value) {
                    if(Url::getParam($key) != $value){
                        array_push($error,$key);
                    }
                }
                return empty($error) ? "class=\"act\"" : null;
            }
        }
        return $page == Url::cPage()? "class=\"act\"" : null;
    }
    
    public static function encodeHTML($string, $case = 2) {
        switch($case){
            case 1:
                return htmlentities($string, ENT_NOQUOTES, 'UTF-8', false);
                break;
            case 2:
                $pattern = '<([a-zA-Z0-9\.\, "\'_\/\-\+~=;:\(\)?&#%![\]@]+)>';
                
                // put text only, devided with html into array
                $textMatches = preg_split('/'. $pattern . '/', $string);
                
                // array for sanitised output
                $textSanitised = array();
                foreach ($textMatches as $key => $value){
                    $textSanitised[$key] = htmlentities(html_entity_decode($value, ENT_QUOTES, 'UTF-8'), ENT_QUOTES, 'UTF-8');
                }
                foreach ($textMatches as $key => $value){
                     $string = str_replace($value, $textSanitised[$key], $string);
                }
                return $string;
                break;
        }
    }
    
    public static function getImgSize($image, $case) {
        if(is_file($image)){
            // 0 => width, 1 => height, 2 => type, 3 => attributes
            $size = getimagesize($image);
            return $size[$case];
        }
    }
    
    public static function shortenString($string, $len = 150){
        if(strlen($string) > $len) {
            $string = trim(substr($string, 0, $len));
            $string = substr($string, 0, strrpos($string, " "))."&hellip;";
        }else{
            $string .= "&hellip;";
        }
    }
    
    public static function redirect($url = null){
        if(!empty($url)){
            header("Location: {$url}");
            exit;
        }
    }
    
    public static function currency($value,$decimal=0,$country=NULL,$vat=FALSE){
        switch($country){
            case "id" : $money = new Money("Rp ",0.1,",","."); break;
            case "us" : $money = new Money("$ ",0.2,".",","); break;
            default : $money = new Money("");
        }
        $money->setDecimal(0);
        if(strip_tags(!isset($_POST['export']))){
            return $money->display($value);
        } else {
            return $value;
        }
    }
    
    public static function number($number,$decimal=0){
        return number_format($number,$decimal,",",".");
    }
    
    public static function dateToMySqlSystem($date){
        //$result = date_create_from_format("d-m-Y",$date);
        $result = DateTime::createFromFormat("d-m-Y",$date);
        //return $result->format("Y-m-d");
        return date_format($result, "Y-m-d");
    }
    
    public static function dateFromMySqlSystem($date){
        $result = date_create_from_format("Y-m-d",$date);
        //return $result->format("d-m-Y");
        return date_format($result,"d-m-Y");
    }
    
    
    public static function hash($algoritm, $data, $salt)
    {
        $template = hash_init($algoritm, HASH_HMAC, $salt);
        hash_update($template, $data);
        return hash_final($template);
    }
}
