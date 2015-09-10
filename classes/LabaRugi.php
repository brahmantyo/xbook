<?php
class LabaRugi extends Application {
    protected $_result_count;
    public $_startDate;
    public $_endDate;
    public function hitungLabaRugiCabang($tgl1,$tgl2,$cabang){
        //$auth = $this->getAuth();
        $auth = $this->role($_SESSION['aid']);
        switch($auth){
            case "SUPER"    : $sql = "CALL HitungRLCabang('".$tgl1."','".$tgl2."',".$cabang.")";break;
            case "OWNER"    : $sql = "CALL HitungRLCabang('".$tgl1."','".$tgl2."',".$cabang.")";break;
            case "MANAGER"  : $sql = "CALL HitungRLCabangStaff('".$tgl1."','".$tgl2."',".$cabang.")";break;
        default:
                $sql="CALL HitungRLCabangStaff('".$tgl1."','".$tgl2."',".$cabang.")";
        }
        if($sql){ $result= $this->db->query($sql);}
        return $result;
    }    
   
    public function hitungLabaRugiGlobal($tgl1,$tgl2){
        //$this->db->query("TRUNCATE rugilaba");
        //$auth = $this->getAuth();
        $auth = $this->role($_SESSION['aid']);
        switch($auth){
            case "SUPER"    : $sql = "CALL HitungLabaGlobal('".$tgl1."','".$tgl2."')";break;
            case "OWNER"    : $sql = "CALL HitungLabaGlobal('".$tgl1."','".$tgl2."')";break;
            case "MANAGER"  : $sql = "CALL HitungLabaGlobalStaff('".$tgl1."','".$tgl2."')";break;
        default:
                $sql="CALL HitungLabaGlobalStaff('".$tgl1."','".$tgl2."')";
        }
        if($sql){ $result= $this->db->query($sql);}
        return $result;
    }

    public function getLabaRugiAll(){
        $sql = "SELECT * FROM rugilaba";
        return $sql;
    }
    
    public function getData($tgl1,$tgl2,$cabang){
        $this->_startDate = $tgl1;
        $this->_endDate = $tgl2;
        if($cabang!=0) {
            $hitungLR = $this->hitungLabaRugiCabang($tgl1, $tgl2, $cabang);
        } else {
            $hitungLR = $this->hitungLabaRugiGlobal($tgl1, $tgl2);
        }
        if(isset($hitungLR)){
            $result= $this->db->fetchOne($this->getLabaRugiAll());
        }
        $this->_result_count += $this->db->_affected_rows;
        return $result;
    }
    
/*    public function getAuth(){
              
        //Roles for user Admin
        if($_SESSION['level']=='SUPER'){
            return $_SESSION['level'];
        }

        //Roles for user Munis
        elseif($_SESSION['aid']==2 && $_SESSION['level']=='OWNER'){
            return $_SESSION['level'];
        } 

        //Roles for user Agus
        elseif($_SESSION['aid']==3 && $_SESSION['level']=='MANAGER'){
            return $_SESSION['level'];
        }                
        else {
            return "STAFF";
        }
    }*/

    public function role($user){
        $sql = "SELECT level FROM admin WHERE id=".$user." LIMIT 1";
        $result= $this->db->fetchOne($sql);
        return $result['level'];
    }
}