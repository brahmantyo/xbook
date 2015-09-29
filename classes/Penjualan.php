<?php
class Penjualan extends Application {
    public $_startDate;
    public $_endDate;
    public $_cabang;
    public $_direction;
    public $_result_count;
    

    public function getPenjualanAll($group,$value){
        $sqlSelect = "SELECT 
                    dj.part,dj.nama AS nmbarang,dj.asl AS asal,peg.nama AS nmsales,jl.nota,jl.tgl,jl.sales AS salesid,dj.iditems,dj.qty,dj.hrgbeliidr2,dj.hrgbeliusd2,dj.hbeliidrr,dj.hbeliusdr,dj.hrgjualidr,dj.hrgjualusd,dj.disc,jl.bayar,jl.cur,jl.branchid,b.branch_name,dj.isowner,dj.vaktifasi AS aktivasi,dj.vbonus AS bonus";

        $sqlFrom = " FROM djual dj";
        $sqlJoin = " INNER JOIN jual jl ON (dj.id=jl.nota)
                     INNER JOIN branch b ON (jl.branchID=b.branch_id) 
                     INNER JOIN pegawai peg ON (jl.sales=peg.Id)";

        if ($this->_cabang || ($this->_startDate && $this->_endDate) ){
            $sqlWhere = " WHERE ";
            if($this->_cabang){
                $sqlWhere .= " jl.branchid = ".$this->_cabang;
                if($this->_startDate && $this->_endDate){
                    $sqlWhere .= " AND jl.tgl >= '".$this->_startDate."' AND jl.tgl <= '".$this->_endDate."'"; 
                }
            } else if($this->_startDate && $this->_endDate){
                $sqlWhere .= " jl.tgl >= '".$this->_startDate."' AND jl.tgl <= '".$this->_endDate."'"; 
            }
        }
        $sqlOrder = " ORDER BY jl.nota,dj.hrgjualidr DESC";
        switch ($group){
            case 'part'      : $sqlWhere .= " AND jl.validate='1'";// AND dj.part = '".$value."'";
                               $sqlOrder .=" , jl.tgl ".$this->_direction;
                               break;
            case 'tanggal'   : $sqlWhere .= " AND jl.validate='1'";// AND jl.tgl = '".$value."'";
                               $sqlOrder .=" , jl.tgl ".$this->_direction;
                               break;
            case 'sales'     : $sqlWhere .= " AND jl.validate='1'";
                               $sqlOrder .=", jl.sales ".$this->_direction;
                               break;
        }

        $sql = $sqlSelect.$sqlFrom.$sqlJoin.$sqlWhere.$sqlOrder;
        //echo $sql;exit();
        return $sql;
    }
    
    public function getPart(){
        $sql = "SELECT DISTINCT part,nama FROM djual";
        return $this->db->fetchAll($sql);
    }
    
    public function getData($group,$value){
        $result= $this->db->fetchAll($this->getPenjualanAll($group,$value));
        
        $this->_result_count += $this->db->_affected_rows;
        return $result;
    }
    
    public function getDataByGroup($group,$direction="DESC"){
        $serial = array();
        $this->_direction = $direction;
        switch ($group){
        case'part' :    //$parts = $this->getPart();
                        //foreach ($parts as $part){
                            $result = $this->getData($group,'');
                            
                            if($result){
                                for($i=0;$i<$this->_result_count;$i++){
                                    $serial[$result[$i]['part'].'/'.$result[$i]['nmbarang']][]=$result[$i];
                                }
                                unset($result);
                            }
                        //}
                        break;
        case 'tanggal': 
                        //$tanggals = $this->getSemuaTanggalPenjualan();
                        //foreach ($tanggals AS $tanggal) {
                            $result = $this->getData($group,'');
                            if ($result) {
                                for($i=0;$i<$this->_result_count;$i++){
                                    $serial[$result[$i]['tgl']][]=$result[$i];
                                }
                                unset($result);
                            }
                        //}
                        break;
        case 'sales':   $sales = $this->getSales();
                        //foreach ($sales as $s) {
                        $serial=array();
                        $result = $this->getData($group,'');//$s['salesid']);
                        foreach($sales as $s){
                            $serial[$s['nama']]=array();
                        }

                        foreach($result as $r){
                            $serial[$r['nmsales']][] = $r;
                        }
                        break;
        }
        $serial = $this->role($serial);
        return $serial;
    }
    public function getSemuaTanggalPenjualan(){
        $sql = "SELECT DISTINCT tgl FROM jual WHERE tgl>= '".$this->_startDate."' AND tgl <= '".$this->_endDate."' ORDER BY tgl ".$this->_direction;
        return $this->db->fetchAll($sql);
    }
    public function getTanggalPenjualan(){
        //$sql = "SELECT MIN(tgl) AS awal, MAX(tgl) AS akhir FROM jual";
        $sql = "SELECT (CASE WHEN (MIN(tgl)<CURDATE())
                THEN
                    (SELECT CONCAT(YEAR(CURDATE()),'-',MONTH(CURDATE()),'-1'))
                ELSE
                    MIN(tgl)
                END) AS `awal`,CURDATE() AS `akhir` FROM jual";        
        return $this->db->fetchOne($sql);
    }
    
    public function getSales(){
        $sql = "SELECT DISTINCT pegawai.id AS salesid, pegawai.nama FROM jual INNER JOIN pegawai on jual.sales=pegawai.id";
        return $this->db->fetchAll($sql);
    }
    public function getInvoice($invoice){
        $sql = "SELECT j.nota AS noinvoice,j.tgl, p.Nama AS sales FROM jual j
                LEFT JOIN pegawai p ON p.Id = j.sales
                WHERE j.nota = '".$invoice."'";
        $result = $this->db->fetchOne($sql);
        return $result;
    }
    public function getPenjualanInvoice($noinvoice){
        $sql = "SELECT dj.part,dj.iditems AS sn,dj.nama,dj.qty,dj.hrgjualidr AS harga,dj.disc,dj.subtotal AS jumlah FROM djual dj
                LEFT JOIN jual jl ON dj.id=jl.nota
                WHERE jl.nota='".$noinvoice."'";
        return $this->db->fetchAll($sql);
    }

    private function role($data){
        foreach($data as $partKey=>$part){
            foreach($part as $listKey=>$list){
                
                //Roles for user Admin
                if(($_SESSION['aid']==1)||($_SESSION['aid']==0)){
                    $data[$partKey][$listKey]['hrgbeliidr'] = $list['hbeliidrr'];
                    $data[$partKey][$listKey]['hrgbeliusd'] = $list['hbeliusdr'];                    
                }
                
                //Roles for user Munis
                elseif($_SESSION['aid']==2){
                    $data[$partKey][$listKey]['hrgbeliidr'] = $list['hbeliidrr'];
                    $data[$partKey][$listKey]['hrgbeliusd'] = $list['hbeliusdr'];
                } 
                
                //Roles for user Agus
                elseif($_SESSION['aid']==3 && $list['asal']!=768 && $list['isowner']!=1){
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
