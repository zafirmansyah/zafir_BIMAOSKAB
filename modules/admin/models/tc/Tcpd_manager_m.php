<?php 


/**
 * 
 */
class Tcpd_manager_m extends Bismillah_Model
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
    $where[]    = "username = '$cUserName'";
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
    $dbd        = $this->select($cTableName, $cFieldName, $where, $join, "pd.username", "pd.status DESC", $limit) ;
    $dba        = $this->select($cTableName, "pd.id", $where, $join, "pd.username") ;
    
    return array("db"=>$dbd, "rows"=> $this->rows($dba) ) ;
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
    $cWhere  = "username = '$cUsername'" ;
    $dba     = $this->select("performance_dialog", "status", $cWhere,"","","status DESC") ;
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
    // echo(print_r($vaData)) ;
    return "OK" ;
  }

}