<?php
class Pembelian extends Application {
    public $_startDate;
    public $_endDate;
    public $_cabang;
    public $_direction;
    public $_result_count;
    
    public function getPembelianAll($group,$value){
        $sql = "SELECT 
            bl.tgl, bl.nota, bl.sales AS pegawai, bl.bayar, bl.cur, bl.idcabang, 
            db.part, db.iditems AS sn, db.nama AS nmbarang, db.itipe AS tipe, db.qty, db.hrgbeliidr2, db.hrgbeliusd2, db.hbeliidrr, db.hbeliusdr, db.mowner,
            b.branch_name AS cabang
        FROM dbeli db
        LEFT JOIN beli bl ON (bl.nota=db.id) 
        LEFT JOIN branch b ON (b.branch_id=db.idcabang )";

        if ($this->_cabang || ($this->_startDate && $this->_endDate) ){
            $sql .= " WHERE ";
            if($this->_cabang){
                $sql .= " bl.idcabang = ".$this->_cabang;
                if($this->_startDate && $this->_endDate){
                    $sql .= " AND bl.tgl >= '".$this->_startDate."' AND bl.tgl <= '".$this->_endDate."'"; 
                }
            }else if($this->_startDate && $this->_endDate){
                $sql .= " bl.tgl >= '".$this->_startDate."' AND bl.tgl <= '".$this->_endDate."'"; 
            }
        }
        
        switch ($group){
            case 'part'      : $sql .= " AND db.part = '".$value."' ORDER BY bl.tgl ".$this->_direction;break;
            case 'tanggal'   : $sql .= " AND bl.tgl = '".$value."' ORDER BY bl.tgl ".$this->_direction;break;
        } 
        //echo $sql;
        return $sql;
    }
    
    public function getPart(){
        $sql = "SELECT DISTINCT part,nama FROM dbeli";
        return $this->db->fetchAll($sql);
    }
    
    public function getData($group,$value){
        $result= $this->db->fetchAll($this->getPembelianAll($group,$value));
        
        $this->_result_count += $this->db->_affected_rows;
        return $result;
    }
    
    public function getDataByGroup($group,$direction="DESC"){

        $serial = array();
        $this->_direction = $direction;
        
        switch ($group){
        case 'part' :    $parts = $this->getPart();
                        foreach ($parts as $part){
                            $result = $this->getData($group,$part['part']);
                            if($result){
                                $serial[$part['part'].'/'.$part['nama']]=$result;
                            }
                        }
                        break;
        case 'tanggal': $tanggals = $this->getSemuaTanggalPembelian($direction);
                        foreach ($tanggals AS $tanggal) {
                            $result = $this->getData($group,$tanggal['tgl']);
                            if ($result) {
                                $serial[$tanggal['tgl']]=$result;
                                unset($result);
                            }
                        }
                        break;
        }
        $serial = $this->role($serial);
        return $serial;
    }
    public function getSemuaTanggalPembelian($direction){
        $sql = "SELECT tgl FROM beli ORDER BY tgl ".$direction;
        return $this->db->fetchAll($sql);
    }
    public function getTanggalPembelian(){
        //$sql = "SELECT MIN(tgl) AS awal, MAX(tgl) AS akhir FROM beli";
        $sql = "SELECT (CASE WHEN (MIN(tgl)<CURDATE())
                THEN
                    (SELECT CONCAT(YEAR(CURDATE()),'-',MONTH(CURDATE()),'-1'))
                ELSE
                    MIN(tgl)
                END) AS `awal`,CURDATE() AS `akhir` FROM beli";        
        return $this->db->fetchOne($sql);
    }
    
    private function role($data){
        foreach($data as $partKey=>$part){
            foreach($part as $listKey=>$list){
                
                //Roles for user Admin
                if($_SESSION['aid']==1){
                    $data[$partKey][$listKey]['hrgbeliidr'] = $list['hbeliidrr'];
                    $data[$partKey][$listKey]['hrgbeliusd'] = $list['hbeliusdr'];                    
                }
                
                //Roles for user Munis
                elseif($_SESSION['aid']==2){
                    $data[$partKey][$listKey]['hrgbeliidr'] = $list['hbeliidrr'];
                    $data[$partKey][$listKey]['hrgbeliusd'] = $list['hbeliusdr'];
                } 
                
                //Roles for user Agus
                elseif($_SESSION['aid']==3 && $list['idcabang']!=768 && $list['mowner']!=1){
                    $data[$partKey][$listKey]['hrgbeliidr'] = $list['hbeliidrr'];
                    $data[$partKey][$listKey]['hrgbeliusd'] = $list['hbeliusdr'];
                } 
                
                else {
                    $data[$partKey][$listKey]['hrgbeliidr'] = $list['hrgbeliidr2'];
                    $data[$partKey][$listKey]['hrgbeliusd'] = $list['hrgbeliusd2'];
                }
            }
        }
        return $data;
    }
}
