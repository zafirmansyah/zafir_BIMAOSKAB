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
        savesession($this, "ss_Data_WO","");
        savesession($this, "ss_Kode_WO","") ;
        
    }

    public function loadgrid(){
        $va     = json_decode($this->input->post('request'), true) ;
        $vare   = array() ;
        $vdb    = $this->bdb->loadgrid($va) ;
        $dbd    = $vdb['db'] ;
        while( $dbr = $this->bdb->getrow($dbd) ){
            $cTglProses             = $dbr['TglProses'];
            $cTglAkhir              = $dbr['TglStatusAkhir'];
            $cStatus                = $dbr['Status'];
            $cCaseClosed            = $this->bdb->getStatusCaseClosed($dbr['Kode']);
            $cTextStatus                = "<span class='text-default'>New<span>";
            $btnClass               = "btn-default";
            if($cStatus == "1"){ //proses
                $cTextStatus  = "<span class='text-info'>Proses<span>";
            }else if($cStatus == "2"){ //pending
                $cTextStatus  = "<span class='text-warning'>Pending<span>";
            }else if($cStatus == "3"){ // reject
                $cTextStatus  = "<span class='text-danger'>Reject<span>";
            }else if($cStatus == "F"){ // finish
                $cTextStatus  = "<span class='text-olive'><i class='fa fa-clock-o'></i>&nbsp;Menunggu Persetujuan</span>";
                if($cCaseClosed == "1"){
                    $cTextStatus  = "<span class='text-success'><i class='fa fa-check'></i>&nbsp;Finish</span>";
                }
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
            $vaset['Status']         = html_entity_decode($cTextStatus);
            $vaset['cmdDetail']      = '<span>'.strtoupper($dbr['Subject']).'</span>' ;
            if($dbr['TglProses'] !== "-" || $dbr['TglStatusAkhir'] !== "-"){
                $vaset['cmdDetail']      = '<a onClick="bos.rptwo.cmdDetail(\''.$dbr['Kode'].'\')">'.strtoupper($dbr['Subject']).'</a>' ;
            }
            $vaset['cmdDetail']	    = html_entity_decode($vaset['cmdDetail']) ;
            $vare[]		= $vaset ;
        }

        $vare 	= array("total"=>$vdb['rows'], "records"=>$vare ) ;
        echo(json_encode($vare)) ;
    }

    public function setSessionIDWO()
    {
        $cKode      = $this->input->post('cKode');
        $this->setSessionDataWO($cKode);
        savesession($this,"ss_Kode_WO",$cKode);        
        $vaData     = array() ;
        $dbData     = $this->bdb->getDetailFormWO($cKode);
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
            $cCaseClosed    = $this->bdb->getStatusCaseClosed($cKode);
            $cUserName      = $dbRow['UserName'];
            $vaFileList     = $this->getFileFormWO($cFaktur);
            $vaDataForm[$dTgl][$cFaktur] = array("Faktur"       =>$cFaktur,
                                             "Deskripsi"    =>$cDeskripsi,
                                             "Status"       =>$cStatus,
                                             "Tgl"          =>$dTgl,
                                             "StartDateTime"=>$dStartDateTime,
                                             "EndDateTime"  =>$dEndDateTime,
                                             "UserName"     =>$cUserName,
                                             "CaseClosed"   =>$cCaseClosed,
                                             "File"         =>$vaFileList);
        }
        //print_r($vaDataForm);
        savesession($this,"ss_Data_FormWO",$vaDataForm);
    }

    public function setSessionDataWO($cKode)
    {
        $vaDataWO = array();
        $data = $this->bdb->getDataWO($cKode);
        if(!empty($data)){
            $vaDataWO = $data;
            $vaDataWO['File'] = $this->getFileWO($cKode);
        }
        savesession($this,"ss_Data_WO",$vaDataWO);
    }

    public function getFileFormWO($cKode)
    {
        $dbData = $this->bdb->getFileFormWO($cKode);
        $vaData = array();
        while($dbr = $this->bdb->getrow($dbData)){
            $cPathWO     = $dbr['FilePath'];
            $cFileSize   = "0.00";
            $cNamaFileWO = "File Not Found";
            if(file_exists($cPathWO)){
                $nFileSize      = filesize($cPathWO);
                $vaPathWO       = explode("/",$cPathWO);
                $cNamaFileWO    = end($vaPathWO); 
                $cFileSize      = formatSizeUnits($nFileSize);
            }
            $dbr['FileSize'] = $cFileSize;
            $dbr['FileName'] = $cNamaFileWO;
            $vaData[] = $dbr;
        }        
        return $vaData;
    }

    public function getFileWO($cFaktur)
    {
        $dbData = $this->bdb->getFileWO($cFaktur);
        $vaData = array();
        while($dbr = $this->bdb->getrow($dbData)){
            $cPathWO     = $dbr['FilePath'];
            $cFileSize   = "0.00";
            $cNamaFileWO = "File Not Found";
            if(file_exists($cPathWO)){
                $nFileSize      = filesize($cPathWO);
                $vaPathWO       = explode("/",$cPathWO);
                $cNamaFileWO    = end($vaPathWO); 
                $cFileSize      = formatSizeUnits($nFileSize);
            }
            $dbr['FileSize'] = $cFileSize;
            $dbr['FileName'] = $cNamaFileWO;
            $vaData[] = $dbr;
        }        
        return $vaData;
    }
}

?>