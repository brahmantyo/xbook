<?php

class Login {
    
    public static $_login_page_front = "/?page=login";
    public static $_dashboard_front = "/?page=order";
    public static $_login_front = "cid";
    
    public static $_login_page_admin = "/?page=login";
    public static $_dashboard_admin = "/?page=index";
    public static $_login_admin_id = "aid";
    public static $_login_admin_first = "first_name";
    public static $_login_admin_last = "last_name";
    public static $_login_admin_level = "level";
    
    
    public static $_valid_login = "valid";
    
    public static $_referrer = "refer";

    public static function restrictFront(){
        if(!self::isLogged(self::$_login_front)){
            $url = Url::cPage() != 'logout'?
                    SITE_URL.self::$_login_page_front."&".self::$_referrer."=".Url::cPage() :
                    SITE_URL.self::$_login_page_front;
            Helper::redirect($url);
        }
    }
    
    public static function restrictAdmin(){
        if(!self::isLogged(self::$_login_admin_id)){
             Helper::redirect(SITE_URL.self::$_login_page_admin);           
        }
    }
    
    public static function isLogged($case = null){
        if(!empty($case)){
            if(isset($_SESSION[self::$_valid_login]) && $_SESSION[self::$_valid_login]==1){
                return isset($_SESSION[$case])? true : false;
            }
            return false;
        }
        return false;
    }
    
    public static function string2hash($string = null){
        if(!empty($string)){
            //return hash('sha512', $string);
            return Helper::hash("sha256", $string, HASH_PASSWORD_KEY);
        }
    }

    public static function loginFront($id, $url = NULL){
        $url = !empty($url) ? $url : self::$_dashboard_front;
        $_SESSION[self::$_login_front] = $id;
        $_SESSION[self::$_valid_login] = 1;
        Helper::redirect($url);
    }
    
    public static function loginAdmin($user, $url = NULL){
        $url = !empty($url) ? SITE_URL.$url : SITE_URL.self::$_dashboard_admin;
        $_SESSION[self::$_login_admin_id] = $user['id'];
        $_SESSION[self::$_login_admin_first] = $user['first_name'];
        $_SESSION[self::$_login_admin_last] = $user['last_name'];
        $_SESSION[self::$_login_admin_level] = $user['level'];
        
        $_SESSION[self::$_valid_login] = 1;
        Helper::redirect($url);
    }
    
    public static function logout($case = NULL){
        //
        //session_destroy();
        
        if(!empty($case)){
            $_SESSION[$case] = NULL;
            $_SESSION[self::$_valid_login] = NULL;
            $_SESSION[self::$_login_admin_id] = NULL;
            $_SESSION[self::$_login_admin_first] = NULL;
            $_SESSION[self::$_login_admin_last] = NULL;
            $_SESSION[self::$_login_admin_level] = NULL;
            
            unset($_SESSION[$case]);
            unset($_SESSION[self::$_valid_login]);
            unset($_SESSION[self::$_login_admin_id]);
            unset($_SESSION['level']);

        } else {
            session_destroy();
        }

         
    }
}
