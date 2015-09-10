<?php
class Bank extends Application {
	
	private $_table = "banks";

	public function getData(){
        $sql = "SELECT norek,bank,an FROM banks";
		return $this->db->fetchAll($sql);
	}

	public function getNama($id){
		$sql = "SELECT CONCAT(bank,'-',an) AS nama FROM banks WHERE norek = '".$id."'";
		$bank = $this->db->fetchOne($sql);
		return $bank['nama']?$bank['nama']:"Semua";
	}

}