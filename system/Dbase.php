<?php
error_reporting(E_ALL ^ E_DEPRECATED);
class Dbase {
    
    private $_host = DB_HOST;
    private $_user = DB_USER;
    private $_password = DB_PASSWORD;
    private $_name = DB_NAME;
    
    private $_conndb = false;
    public $_last_query = null;
    public $_affected_rows = 0;
    
    public $_insert_keys = array();
    public $_insert_values = array();
    public $_update_sets = array();
    
    public $_id;
    
    public function __construct() {
        $this->connect();
    }
    
    private function connect() {
        $this->_conndb = mysql_connect($this->_host, $this->_user, $this->_password);
        
        if(!$this->_conndb){
            die("Database connection failed : ".  mysql_error());
        } else {
            $_select = mysql_select_db($this->_name, $this->_conndb);
            if(!$_select){
                die("Database selection failed :". mysql_error());
            }
        }
        mysql_set_charset("utf8", $this->_conndb);
    }
    
    public function close() {
        if(!mysql_close($this->_conndb)){
            die("Database closing failed.");
        }
    }
    
    public function escape($value){
        if(function_exists("mysql_real_escape_string")){
            if(get_magic_quotes_gpc()){
                $value = stripslashes($value);
            }
            $value = mysql_real_escape_string($value);
        } else {
            if(!get_magic_quotes_gpc()){
                $value = addslashes($value);
            }
        }
        return $value;
    }
    
    public function query($sql){
        $this->_last_query = $sql;
        $result  = mysql_query($sql, $this->_conndb);
        $this->display_query($result);
        return $result;
    }
    
    public function display_query($result){
        if(!$result){
            $output = "Database query failed :". mysql_error()."<br />";
            $output .= "Last query was :". $this->_last_query;
            die($output);
        } else {
            $this->_affected_rows = mysql_affected_rows($this->_conndb);
        }
    }
    
    public function fetchAll($sql) {
        $result = $this->query($sql); //echo $sql;echo "<br />";
        $out = array();
        while($row=  mysql_fetch_assoc($result)){
            
            //$n++;
            //echo sprintf( "%7d %12d\n", $n, memory_get_peak_usage() );
           
            $out[]=$row;
            //unset( $row );
        }
        mysql_free_result($result);
        return $out;
    }
    
    public function fetchOne($sql) {
        $out = $this->fetchAll($sql);
        return array_shift($out);
    }
    /*
    public function fetchGroup($sql,$groups){
        $tmpResult = $this->fetchAll($sql);
        print_r($tmpResult);
        foreach($groups as $group){
            
        }
    }
    */
    
    public function lastId(){
        return mysql_insert_id($this->_conndb);
    }
}
