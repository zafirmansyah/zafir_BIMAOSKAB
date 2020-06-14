<?php 
/**
 * 
 */
class Tciku_form_m extends Bismillah_Model
{
	
    public function loadgrid($va){
        $cUserName  = getsession($this,'username') ;
        $limit      = $va['offset'].",".$va['limit'] ;
        $search	    = isset($va['search'][0]['value']) ? $va['search'][0]['value'] : "" ;
        $search     = $this->escape_like_str($search) ;
        $where 	    = array() ; 
        if($search !== "") $where[]	= "(f.Kode LIKE '{$search}%' OR m.Subject LIKE '%{$search}%')" ;
        if(getsession($this,"Jabatan") > "002") $where[] = "f.UserName='{$cUserName}'";
        $where 	    = implode(" AND ", $where) ;
        $join       = "left join iku_master m on m.Kode=f.Kode";
        $dbd        = $this->select("iku_form f", "f.*,m.*", $where, $join, "", "f.Kode DESC", $limit) ;
        $dba        = $this->select("iku_form f", "f.ID", $where) ;

        return array("db"=>$dbd, "rows"=> $this->rows($dba) ) ;
    }
    
    public function getKodeIKU()
    {
        $dYM        = date('Ym') ;
        $cKey  		= "IKU" . $dYM;
        $n    		= $this->getincrement($cKey,true,3);
        $cCIF    	= $cKey . "." . $n ;
        return $cCIF ;
    }

    public function saving($va){

        //var_dump($va);    
        $cKode = $va['optKodeIKU'] ;

        $cUserName                 = getsession($this,'username') ;
        
        $this->delete("iku_form", "Kode = '{$cKode}' and UserName = '{$cUserName}'" ) ;
        $vaData         = array("Kode"=>$cKode, 
                                "Tgl"=>date_2s($va['dTgl']),
                                "Deskripsi"=>$va['cDeskripsi'],
                                "UserName"=>$cUserName ,
                                "DateTime"=>date('Y-m-d H:i:s')
                                ) ;
        $this->insert("iku_form",$vaData);
        
        return $vaData ;
    }

    public function saveFile($va)
    {
        $cKode          = $va['optKodeIKU'] ;
        $cUserName      = getsession($this,'username') ;
        $vaData = array("Kode"=>$cKode, 
                        "Tgl"=>date_2s($va['dTgl']),
                        "FilePath"=>$va['FilePath'],
                        "UserName"=>$cUserName ,
                        "DateTime"=>date('Y-m-d H:i:s')
        ) ;
        $where      = "Kode = " . $this->escape($cKode) ;
        $this->insert("iku_form_file", $vaData, $where, "") ;
    }

    public function deleteFile($va)
    {
        $cKode  = $va['cKode'] ;
        $cWhere = "Kode = '$cKode'" ;
        $this->delete('iku_form_file',$cWhere);
    }

    public function getdata($id){
        $data = array() ;
        if($d = $this->getval("*", "Kode = " . $this->escape($id), "iku_form")){
        $data = $d;
        }
        return $data ;
    }

    public function deleting($id){
        $this->delete("iku_form", "Kode = " . $this->escape($id)) ;
    }

    public function seekKodeIKU($search)
    {
        $cWhere     = array() ; 
        $cWhere[]   = "Kode <> ''" ;
        if($search !== "") $cWhere[]   = "(Kode LIKE '%{$search}%' OR Subject LIKE '%{$search}%')" ;
        $cWhere     = implode(" AND ", $cWhere) ;
        $dbd        = $this->select("iku_master", "Kode,Subject", $cWhere, "", "", "Kode ASC") ;
        return array("db"=>$dbd) ;
    }

    public function getDataTargetDisposisi($cKode)
    {
        $data = array() ;
		if($d = $this->getval("*", "KodeKaryawan = " . $this->escape($cKode), "sys_username")){
            $data = $d;
		}
		return $data ;
    }
}

 ?>