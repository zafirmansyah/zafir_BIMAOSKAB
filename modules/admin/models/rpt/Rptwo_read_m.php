<?php

class Rptwo_read_m extends Bismillah_Model
{

    public function saving($va){

        $cKode         = $va['cKode'] ;
        $cFaktur       = $va['cFaktur'];
        $cOpsi         = $va['cOpsi'];
        if($cOpsi == "reject"){   //reject
            $cFakturReject = $va['cFakturReject'];
            $cDeskripsi    = $va['cDeskripsi'];
            $cUserName = getsession($this,'username') ;
            $dDateTime = date('Y-m-d H:i:s');
            $vaData    = array('Kode'=>$cKode,
                                'Faktur'=>$cFakturReject,
                                'Tgl'=>date('Y-m-d'),
                                'Deskripsi'=>$cDeskripsi,
                                'StartDateTime'=>$dDateTime,
                                'EndDateTime'=>$dDateTime,
                                'UserName'=>$cUserName,
                                "Status"=>"3"
                        );
            $vaUpd     = array("Status"=>"3");
            $where     = "Faktur = ".$this->escape($cFaktur);
            $this->update("work_order_form",$vaUpd,$where,"");        // update Status form WO

            $this->insert("work_order_form",$vaData);                 // insert data reject WO ke work_order_form
            $this->updateStatusWO($cKode,"3");                        // update status master WO
            //return $vaUpd ;
        }else{          //finish
            $vaUpd     = array("CaseClosed"=>"1");
            $where     = "Kode = ".$this->escape($cKode);
            $this->update("work_order_master",$vaUpd,$where,"");        // update Status form WO
            //return $vaUpd ;
        }
        
    }
    public function getFakturRejectWO()
    {
        $dYM            = date('Ym') ;
        $cKey  		    = "RW" . $dYM;
        $n    		    = $this->getincrement($cKey,true,4);
        $cFaktur    	= $cKey . "." . $n ;
        return $cFaktur ;
    }

    public function updateStatusWO($cKode,$cStatus="1")
    {
        $where   = "Kode = ".$this->escape($cKode);
        $this->update("work_order_master",array('Status'=>$cStatus),$where,"");
    }
}
?>