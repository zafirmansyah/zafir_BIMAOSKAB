<?php

class Mstsurat_cetak_m extends Bismillah_Model
{
    public function loadgrid($va){
        $limit      = $va['offset'].",".$va['limit'] ;
        $search	    = isset($va['search'][0]['value']) ? $va['search'][0]['value'] : "" ;
        $search     = $this->escape_like_str($search) ;
        $where 	    = array() ; 
        if($search !== "") $where[]	= "(Subject LIKE '%{$search}%')" ;
        $where 	    = implode(" AND ", $where) ;
        $dbd        = $this->select("cetak_dokumen", "*", $where, "", "", "ID ASC", $limit) ;
        $dba        = $this->select("cetak_dokumen", "ID", $where) ;

        return array("db"=>$dbd, "rows"=> $this->rows($dba) ) ;
    }

    public function getKodeTemplate()
    {
        $dYM        = date('Ym') ;
        $cKey  		= "TEMPLATE_CETAK" . $dYM;
        $n    		= $this->getincrement($cKey,true,3);
        $cCIF    	= $cKey . "." . $n ;
        return $cCIF ;
    }

    public function getdata($id){
        $data = array() ;
        if($d = $this->getval("*", "Kode = " . $this->escape($id), "cetak_dokumen")){
          $data = $d;
        }
        return $data ;
    }

    public function saving($va){

        //var_dump($va);    
        $cKode = $va['cKode'] ;

        $cUserName                 = getsession($this,'username') ;
        
        $this->delete("cetak_dokumen", "Kode = '{$cKode}'" ) ;
        $where          = "Kode='{$cKode}'";
        $vaData         = array("Kode"=>$cKode, 
                                "Tgl"=>date('Y-m-d'),
                                "Subject"=>$va['cKeterangan'],
                                "UserName"=>$cUserName ,
                                "DateTime"=>date('Y-m-d H:i:s'),
                                "Status"=>"1"
                                ) ;
        $this->update("cetak_dokumen",$vaData,$where,"");
        
        return $vaData ;
    }

    public function saveFile($va)
    {
        $cKode          = $va['cKode'] ;
        $cUserName      = getsession($this,'username') ;
        $vaData         = array("Kode"=>$cKode, 
                                "Tgl"=>date('Y-m-d'),
                                "FilePath"=>$va['FilePath'],
                                "UserName"=>$cUserName ,
                                "DateTime"=>date('Y-m-d H:i:s')
        ) ;
        $where      = "Kode = " . $this->escape($cKode) ;
        $this->insert("cetak_dokumen_file", $vaData, $where, "") ;
    }

    public function deleteFile($va)
    {
        $cKode  = $va['cKode'] ;
        $cWhere = "Kode = '$cKode'" ;
        $this->delete('cetak_dokumen_file',$cWhere);
    }
    public function deleting($id){
        $this->delete("cetak_dokumen", "Kode = " . $this->escape($id)) ;
      }
}


?>