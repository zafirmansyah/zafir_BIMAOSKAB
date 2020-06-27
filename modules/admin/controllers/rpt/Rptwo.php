<?php

class Rptwo extends Bismillah_Controller
{
    public function __construct(){
        parent::__construct() ;
        $this->load->model('rpt/rptwo_m') ;
        $this->load->helper('bdate') ;
        $this->load->helper('bsite') ;

        $this->bdb = $this->rptwo_m ;
    }

    public function index(){
        $this->load->view('rpt/rptwo') ;
    }

    public function init()
    {
        savesession($this, "ss_Data_FormWO","") ;
        savesession($this, "ss_Kode_WO","") ;
        savesession($this, "ss_ID_FormWO","") ;
        savesession($this, "ss_UserName_FormWO","") ;
        savesession($this, "ss_Status_FormWO","") ;
        savesession($this, "ss_Deskripsi_FormWO","") ;
        savesession($this, "ss_Tgl_FormWO","") ;
        savesession($this, "ss_EndDateTime_FormWO","") ;
        savesession($this, "ss_File_FormWO","");
        
    }

    public function loadgrid(){
        $va     = json_decode($this->input->post('request'), true) ;
        $vare   = array() ;
        $vdb    = $this->bdb->loadgrid($va) ;
        $dbd    = $vdb['db'] ;
        while( $dbr = $this->bdb->getrow($dbd) ){
            $cTglProses             = $dbr['TglProses'];
            $cTglAkhir              = $dbr['TglStatusAkhir'];
            $lStatus                = $dbr['Status'];
            $cStatus                = "<span class='text-default'>New<span>";
            $btnClass               = "btn-default";
            if($lStatus == "1"){ //proses
                $cStatus  = "<span class='text-info'>Proses<span>";
            }else if($lStatus == "2"){ //pending
                $cStatus  = "<span class='text-warning'>Pending<span>";
            }else if($lStatus == "3"){ // reject
                $cStatus  = "<span class='text-danger'>Reject<span>";
            }else if($lStatus == "F"){ // finish
                $cStatus  = "<span class='text-success'>Finish<span>";
            }
            if($dbr['TglProses'] !== "-"){
                $dTglProses = date_create($dbr['TglProses']);
                $cTglProses = date_format($dTglProses,"d-m-Y H:i");
            }
            if($dbr['TglStatusAkhir'] !== "-"){
                $dTglAkhir  = date_create($dbr['TglStatusAkhir']);
                $cTglAkhir  = date_format($dTglAkhir,"d-m-Y H:i");
            }
            $vaset   = $dbr ;
            $vaset['Tgl']            = date_2d($dbr['Tgl']) ;
            $vaset['TglProses']      = $cTglProses;
            $vaset['TglStatusAkhir'] = $cTglAkhir;
            $vaset['Status']         = html_entity_decode($cStatus);
            $vaset['cmdDetail']       = '<a onClick="bos.rptwo.cmdDetail(\''.$dbr['Kode'].'\')">'.strtoupper($dbr['Subject']).'</a>' ;
            $vaset['cmdDetail']	    = html_entity_decode($vaset['cmdDetail']) ;
            $vare[]		= $vaset ;
        }

        $vare 	= array("total"=>$vdb['rows'], "records"=>$vare ) ;
        echo(json_encode($vare)) ;
    }

    public function setSessionIDWO()
    {
        $cKode      = $this->input->post('cKode');
        $dbData     = $this->bdb->getDetailFormWO($cKode);
        savesession($this,"ss_Kode_WO",$cKode);
        $vaSess     = array() ;
        $vaData     = array() ;
        while($dbRow = $this->bdb->getrow($dbData)){   
            $cFaktur        = $dbRow['Faktur'];
            $cDeskripsi     = $dbRow['Deskripsi'];
            $cStatus        = $dbRow['Status'];
            $dTgl           = $dbRow['Tgl'];
            $dStartDateTime = "";
            $dEndDateTime   = "";
            if(!empty($dbRow['StartDateTime'])){
                $cStartDateTime     = date_create($dbRow['StartDateTime']); 
                $dStartDateTime     = date_format($cStartDateTime,"d-m-Y H:i");
            }
            if(!empty($dbRow['EndDateTime'])){
                $cEndDateTime       = date_create($dbRow['EndDateTime']);
                $dEndDateTime       = date_format($cEndDateTime,"d-m-Y H:i");
            } 
            $cUserName      = $dbRow['UserName'];
            $vaFileList     = $this->getFileFormWO($cFaktur);
            $vaData[$dTgl][$cFaktur] = array("Faktur"       =>$cFaktur,
                                             "Deskripsi"    =>$cDeskripsi,
                                             "Status"       =>$cStatus,
                                             "Tgl"          =>$dTgl,
                                             "StartDateTime"=>$dStartDateTime,
                                             "EndDateTime"  =>$dEndDateTime,
                                             "UserName"     =>$cUserName,
                                             "File"         =>$vaFileList);
        }
        print_r($vaData);
        savesession($this,"ss_Data_FormWO",$vaData);
    }

    public function getFileFormWO($cFaktur){
        $dbData = $this->bdb->getFileFormWO($cFaktur);
        $vaData = array();
        while($dbRow = $this->bdb->getrow($dbData)){
            $vaData[]=$dbRow;
        }        
        return $vaData;
    }
}

?>