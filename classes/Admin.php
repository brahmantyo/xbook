<?php
class Admin extends Application {
    
    private $_table = 'admin';
    public $_id;
    public $_user = array();
    public $_level;
    
    public function isUser($user = NULL, $password = NULL) {

        if(!empty($user) && !empty($password) ){
            
            $password = Login::string2hash($password);
            $sql = "SELECT * FROM `{$this->_table}`"
            . "WHERE `username` = '".$this->db->escape($user)."'"
            . "      AND `password` = '".$this->db->escape($password)."'";

            $result = $this->db->fetchOne($sql);

            if(!empty($result)){
                echo 'disini';
                $this->_user['id'] = $result['id'];
                $this->_user['first_name'] = $result['first_name'];
                $this->_user['last_name'] = $result['last_name'];
                $this->_user['level'] = $result['level'];

                $_SESSION['aid'] = $result['id'];
                $_SESSION['level'] = $result['level'];
                return TRUE;
            }

            return "failed";
        }
        return false;
    }
}