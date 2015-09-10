<?php
class Cabang extends Application {
    
    private $_table = "branch";

    //public function __construct() {
    //    parent::__construct();
    //    return $this->getData();
    //}
    
    public function getData(){
        $sql = "SELECT * FROM branch WHERE branch_id <> 0";
        return $this->db->fetchAll($sql);

    }
    public function getNama($id){
    	$sql = "SELECT branch_name FROM branch WHERE branch_id=".$id;
        $nm = $this->db->fetchOne($sql);
        return $id > 0 ?$nm['branch_name']:"Semua Cabang";

    }
}
