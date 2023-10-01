<?php 


/**
 * 
 */
class Tcpd_pegawai_m extends Bismillah_Model
{
	
  public function loadgrid($va){
    $cKodeKaryawan  = getsession($this,"KodeKaryawan");
    $cUserName      = getsession($this,"username");
    $limit          = $va['offset'].",".$va['limit'] ;
    $cSrchField     = isset($va['search'][0]['field']) ? $va['search'][0]['field'] : "" ;
    $cSrchValue     = isset($va['search'][0]['value']) ? $va['search'][0]['value'] : "" ;
    
    $cSrchField     = $this->escape_like_str($cSrchField) ;
    $cSrchValue     = $this->escape_like_str($cSrchValue) ;

    if($cSrchField == "s.Tgl" || $cSrchField == "d.Tgl") $cSrchValue = date_2s($cSrchValue);
    $where 	    = array() ; 
    $where[]    = "username = '$cUserName' AND status < '9'";
    if($cSrchValue !== "") $where[]	= "{$cSrchField} LIKE '%{$cSrchValue}%'" ;
    $where 	    = implode(" AND ", $where) ;
    if($cUserName == "asda" || $cUserName == "super") $where = "status < '9'" ;
    $join       = "";
    $cTableName = "performance_dialog" ;
    $cFieldName = "kode, tahun, tanggal , CONCAT(tahun,' - Triwulan ',SUM(periode+1)) as periode_triwulan, 
                   judul , komentar_pelaksanaan_tugas , area_peningkatan_kinerja, status, username" ;
    $dbd        = $this->select("performance_dialog s", $cFieldName, $where, $join, "s.Kode", "s.tahun DESC , s.periode ASC", $limit) ;
    $dba        = $this->select("performance_dialog s", "s.id", $where, $join) ;
    
    return array("db"=>$dbd, "rows"=> $this->rows($dba) ) ;
  }

  public function getdata($id){
    $data = array() ;
    if($d = $this->getval("*", "Kode = " . $this->escape($id), "performance_dialog")){
      $data = $d;
    }
    return $data ;
  }

  function getDataPreview($id){
    // $cPeriode       = $va['periode'];
    // $nTahun         = $va['tahun'];
    // $cUnameKaryawan = $va['uname_karyawan'] ;
    $vaRetval       = array() ;
    $cTable         = "performance_dialog p" ;
    $cField         = "p.*, u.fullname" ;
    $cJoin          = "LEFT JOIN sys_username u ON u.username = p.username " ;
    $cWhere         = "Kode = " . $this->escape($id) ;
    $dbdata 	      = $this->select($cTable, $cField, $cWhere, $cJoin) ;
    if($dbRow = $this->getrow($dbdata)){
      $vaRetval = $dbRow ;
    }  
    return $vaRetval ;
    
    /**
     * 
     * [periode] => 2 [tahun] => 2023 [uname_karyawan] => suworo
      SELECT
        p.*,
        u.fullname 
      from
        performance_dialog p
      
      WHERE
        
    */
    
  }

  function isUserAlreadyInputOnThisPeriode($cUsername, $nTahun, $nPeriode) {
    $cWhere = "username = '$cUsername' AND tahun = '$nTahun' AND periode = '$nPeriode' AND status < 9" ;
    $dba      = $this->select("performance_dialog", "count(id) as row", $cWhere) ;
    // $rows     = $this->rows($dba) ;
    $vaReturn = array("db"=> $dba) ;
    return $vaReturn ;
  }

  public function getKodePerformanceDialog()
  {
    $dYM      = date('Ym') ;
    $cKey  		= "PDLG" . $dYM;
    $n    		= $this->getincrement($cKey,true,3);
    $cKode    	= $cKey . "." . $n ;
    return $cKode ;
  }

  function saveData($va){
    $cTableName   = "performance_dialog" ;
    $cUnameAtasan = getsession($this,'superior') ;
    $vaData       = array("kode"                       => $va['cKode'] ,
                          "tanggal"                    => date_2s($va['dTgl']),
                          "judul"                      => $va['cSubject'],
                          "tahun"                      => $va['optTahun'],
                          "periode"                    => $va['optPeriodeTriwulan'],
                          "komentar_pelaksanaan_tugas" => $va['cKomentarPelaksanaanTugas'],
                          "area_peningkatan_kinerja"   => $va['cAreaPeningkatanKinerja'],
                          "username"                   => $va['cUsername'],
                          "username_superior"          => $cUnameAtasan,
                          "datetime"                   => date("Y-m-d H:i:s"),
                          "status"                     => 3);
    $where      = "kode = " . $this->escape($va['cKode']) ;
    $this->update($cTableName, $vaData, $where, "") ;
    return "OK" ;
  }

  public function deleting($id){
    $vaUpd = array('Status'=>"9") ;
    $where = "kode = " . $this->escape($id) ;
    $this->update("performance_dialog", $vaUpd, $where, "") ;
  }

}