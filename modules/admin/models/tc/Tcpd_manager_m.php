<?php 


/**
 * 
 */
class Tcpd_manager_m extends Bismillah_Model
{
	
  public function loadgrid($va){
    // echo print_r($va) ;
    $cKodeKaryawan  = getsession($this,"KodeKaryawan");
    $cUserName      = getsession($this,"username");
    $limit          = $va['offset'].",".$va['limit'] ;
    $cSrchField     = isset($va['search'][0]['field']) ? $va['search'][0]['field'] : "" ;
    $cSrchValue     = isset($va['search'][0]['value']) ? $va['search'][0]['value'] : "" ;
    
    $cSrchField     = $this->escape_like_str($cSrchField) ;
    $cSrchValue     = $this->escape_like_str($cSrchValue) ;

    if($cSrchField == "s.Tgl" || $cSrchField == "d.Tgl") $cSrchValue = date_2s($cSrchValue);
    $where 	    = array() ; 
    $where[]    = "pd.username = '$cUserName'";
    if($cSrchValue !== "") $where[]	= "{$cSrchField} LIKE '%{$cSrchValue}%'" ;
    $where 	    = implode(" AND ", $where) ;
    if($cUserName == "asda" || $cUserName == "super") $where = "" ;
    $join       = "LEFT JOIN sys_username u ON u.username = pd.username ";
    $cTableName = "performance_dialog pd" ;

    // SELECT u.fullname , pd.status from performance_dialog pd 
    // LEFT JOIN sys_username u ON u.username = pd.username 
    // WHERE pd.username_superior = 'asda' 
    // GROUP BY  pd.username
    // ORDER BY pd.status DESC;
    $cFieldName = "pd.username as uname_pelapor, u.fullname as fullname_pelapor, pd.status as status" ;
    $dbd        = $this->select($cTableName, $cFieldName, $where, $join, "pd.username", "pd.status DESC") ;
    $dba        = $this->select($cTableName, "pd.id", $where, $join, "pd.username") ;
    
    return array("db"=>$dbd, "rows"=> $this->rows($dbd) ) ;
  }

  function isUserAlreadyInputOnThisPeriode($cUsername, $nTahun, $nPeriode) {
    $cWhere = "username = '$cUsername' AND tahun = '$nTahun' AND periode = '$nPeriode'" ;
    // echo($cWhere) ;
    $dba      = $this->select("performance_dialog", "count(id) as row", $cWhere) ;
    // $rows     = $this->rows($dba) ;
    $vaReturn = array("db"=> $dba) ;
    return $vaReturn ;
  }

  function getStatusLaporanByUname($cUsername) {
    // SELECT status from performance_dialog pd WHERE username = '16199' ORDER by status DESC LIMIT 1;
    $nRetval = 0 ;
    $cWhere  = "username = '$cUsername' AND status < 9" ;
    $dba     = $this->select("performance_dialog", "status", $cWhere,"","","datetime DESC") ;
    if($dbr = $this->getrow($dba)){
      $nRetval = $dbr['status'] ;
    }  
    // $vaReturn = array("db"=> $dba) ;
    return $nRetval ;
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
    $vaData       = array("tanggal_response"             => date_2s($va['dTgl']),
                          "umpan_balik_evaluasi_kerja"   => $va['cKomentarPelaksanaanTugas'],
                          "rencana_pengembangan_pegawai" => $va['cAreaPeningkatanKinerja'],
                          "datetime_response_superior"   => date("Y-m-d H:i:s"),
                          "status"                       => 1);
    $where      = "kode = " . $this->escape($va['cKode']) ;
    $this->update($cTableName, $vaData, $where, "") ;
    return "OK" ;
  }

  function getdata($va){
    $cPeriode       = $va['periode'];
    $nTahun         = $va['tahun'];
    $cUnameKaryawan = $va['uname_karyawan'] ;
    $vaRetval       = array() ;
    $cTable         = "performance_dialog p" ;
    $cField         = "p.*, u.fullname" ;
    $cJoin          = "LEFT JOIN sys_username u ON u.username = p.username " ;
    $cWhere         = "p.tahun = '$nTahun' AND p.periode = '$cPeriode' and p.username = '$cUnameKaryawan' and status < 9" ;
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

  function editNoComent($cKode){
    $vaUpd = array('status'=>"2") ;
    $where = "kode = " . $this->escape($cKode) ;
    $this->update("performance_dialog", $vaUpd, $where, "") ; 
  }

}