<?php
class CashFlow extends Application {
    public $_startDate;
    public $_endDate;
    public $_cabang;
    public $_bank;

    public function __construct() {
        parent::__construct();
        //getTanggal();
    }
    
/*    public function getBanks(){
        $sql = "SELECT norek,bank,an FROM banks";
        $result = $this->db->fetchAll($sql);
        if($result){
            return $result;
        }
    }*/
    
    

    public function getTanggal(){
        //$sql = "SELECT MIN(tgl) AS start, MAX(tgl) AS end FROM dbanks";
        $sql = "SELECT (CASE WHEN (MIN(tgl)<CURDATE())
                THEN
                    (SELECT CONCAT(YEAR(CURDATE()),'-',MONTH(CURDATE()),'-1'))
                ELSE
                    MIN(tgl)
                END) AS `start`,CURDATE() AS `end` FROM dbanks";
        $result = $this->db->fetchOne($sql);
        $this->_startDate = $result['start'];
        $this->_endDate = $result['end'];
    }


    public function getCashFlow() {
        $sql = "SELECT db.tgl,db.idbank AS rek,b.bank,b.an,b.matauang,db.ket,db.db AS debet,db.cr AS kredit
                FROM dbanks db
                LEFT JOIN banks b ON (db.idbank=b.norek) ";
        
            $sql .= " WHERE ";
            $sql .= "  db.tgl >= '".$this->_startDate."' AND db.tgl <= '".$this->_endDate."'"; 
        $result = $this->db->fetchAll($sql);
        if($result){
            return $result;
        }
    }
    
    public function getCashFlowByBank($bank) {
        $sql = "SELECT db.tgl,db.idbank AS rek,b.bank,b.an,b.matauang,db.ket,db.db AS debet,db.cr AS kredit
                FROM dbanks db
                LEFT JOIN banks b ON (db.idbank=b.norek)
                WHERE db.idbank='".$bank."'";
        

                    $sql .= " AND db.tgl >= '".$this->_startDate."' AND db.tgl <= '".$this->_endDate."'"; 
 
               
        $result = $this->db->fetchAll($sql);
        if($result){
            return $result;
        }
    }
    
    
}
